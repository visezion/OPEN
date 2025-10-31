@extends('layouts.main')

@push('css')
<style>
    .dash-sidebar {
        display: none !important;
    }
    .dash-container {
        margin-left: 0 !important;
    }
</style>

<style>
#reader {
    width: 100%;
    max-width: 480px;
    margin: 25px auto;
    border: 2px dashed #ccc;
    border-radius: 12px;
    background: #fafafa;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: border-color 0.3s ease;
}
.scan-result {
    text-align: center;
    font-size: 1.1rem;
    margin-top: 20px;
    min-height: 40px;
}
.success { color: #16a34a; font-weight: bold; }
.error { color: #dc2626; font-weight: bold; }
.offline-banner {
    background: #facc15;
    color: #000;
    padding: 8px;
    text-align: center;
    font-weight: 600;
    display: none;
}
.camera-control {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    margin: 15px 0;
}
.camera-control select {
    width: auto;
    padding: 6px 12px;
    border-radius: 8px;
}
#startBtn { margin-top: 15px; }
</style>
@endpush

@section('content')
<div class="container text-center">
    <h2 class="fw-bold">{{ $event->title ?? 'Attendance Event' }}</h2>
    <h4 class="text-muted mb-3">{{ __('Scan a member’s QR code to mark attendance.') }}</h4>

    <button id="startBtn" class="btn btn-primary">
        <i class="ti ti-camera"></i> {{ __('Start Scanner') }}
    </button>

    <div class="camera-control mt-3" style="display:none;" id="camControls">
        <select id="cameraSelect" class="form-select d-inline w-auto"></select>
        <button id="switchBtn" class="btn btn-outline-primary btn-sm">
            <i class="ti ti-refresh"></i> {{ __('Switch Camera') }}
        </button>
    </div>

    <div id="reader" style="display:none;"></div>
    <div class="offline-banner" id="offlineBanner">{{ __('⚠️ Offline Mode: Scans will sync later') }}</div>
    <div id="scanResult" class="scan-result"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const markUrl = "{{ route('churchly.attendance_events.mark', $event->id) }}";
const resultBox = document.getElementById('scanResult');
const offlineBanner = document.getElementById('offlineBanner');
const cameraSelect = document.getElementById('cameraSelect');
const switchBtn = document.getElementById('switchBtn');
const startBtn = document.getElementById('startBtn');
const camControls = document.getElementById('camControls');
const readerEl = document.getElementById('reader');

let html5QrCode, currentCameraId, lastScan = '';
let offlineQueue = JSON.parse(localStorage.getItem('offlineScans') || "[]");
let recentScans = [];

// 🔊 SOUND DEFINITIONS
const sounds = {
    success: new Audio("{{ asset('sounds/success.mp3') }}"),
    error: new Audio("{{ asset('sounds/error.mp3') }}"),
    offline: new Audio("{{ asset('sounds/offline.mp3') }}"),
    denied: new Audio("{{ asset('sounds/denied.mp3') }}")
};

function unlockAudio() {
    Object.values(sounds).forEach(a => {
        a.play().then(()=>a.pause()).catch(()=>{});
    });
}
function playSound(type) {
    const audio = sounds[type];
    if (audio) audio.play().catch(()=>{});
}

// 🗣️ Text-to-Speech
function speak(text, lang = 'en-US') {
    if (!window.speechSynthesis) return;
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = lang;
    utter.rate = 1;
    utter.pitch = 1;
    speechSynthesis.cancel();
    speechSynthesis.speak(utter);
}

// 🌐 Connectivity
window.addEventListener('offline', () => {
    offlineBanner.style.display = 'block';
    playSound('offline');
});
window.addEventListener('online', () => {
    offlineBanner.style.display = 'none';
    syncOffline();
});

// 📋 Attendance Logic
function markAttendance(qrData) {
    if (qrData === lastScan) return;
    lastScan = qrData;

    if (!navigator.onLine) {
        offlineQueue.push({ qr: qrData, event_id: {{ $event->id }}, ts: Date.now() });
        localStorage.setItem('offlineScans', JSON.stringify(offlineQueue));
        playSound('offline');
        resultBox.innerHTML = `<span class='error'>📡 Offline – will sync later</span>`;
        return;
    }

    fetch(markUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ qr: qrData })
    })
    .then(r => r.json())
    .then(res => {
        // ✅ SUCCESS
        if (res.ok) {
            playSound('success');
            animateBorder('#16a34a');
            resultBox.innerHTML = `<span class='success'>✅ ${res.message}</span>`;

            const memberName = res.member_name || res.message || "Member";
            speak(`${memberName} marked present!`);
            addRecentScan(memberName);
        }
        // ⚠️ ALREADY MARKED PRESENT
        else if (res.already_marked) {
            playSound('error');
            animateBorder('#f59e0b');
            const name = res.member_name || "This member";
            resultBox.innerHTML = `
                <span class='error'>⚠️ ${name} already marked present!<br>No need to retry.<br>God bless you 🙏</span>`;
            speak("Already marked present. No need to retry. God bless you.");
        }
        // ❌ OTHER ERRORS
        else {
            playSound('error');
            animateBorder('#dc2626');
            resultBox.innerHTML = `<span class='error'>❌ ${res.error}</span>`;
            speak("Error marking attendance");
        }
        setTimeout(() => lastScan = '', 2000);
    })
    .catch(() => {
        playSound('error');
        animateBorder('#dc2626');
        resultBox.innerHTML = `<span class='error'>⚠️ Network error</span>`;
        speak("Network error");
        setTimeout(() => lastScan = '', 2000);
    });
}

function syncOffline() {
    if (offlineQueue.length === 0) return;
    const queue = [...offlineQueue];
    offlineQueue = [];
    localStorage.setItem('offlineScans', "[]");
    queue.forEach(scan => markAttendance(scan.qr));
}

// 🎥 Camera Control
function startScanner(cameraId) {
    if (html5QrCode) html5QrCode.stop().catch(()=>{}).then(()=>html5QrCode.clear());
    html5QrCode = new Html5Qrcode("reader");
    html5QrCode.start(
        { deviceId: { exact: cameraId }},
        { fps: 10, qrbox: 250 },
        text => markAttendance(text)
    ).catch(err => {
        playSound('denied');
        resultBox.innerHTML = `<span class='error'>Unable to start camera.<br>${err}</span>`;
        speak("Camera access failed");
    });
}

function loadCameras() {
    Html5Qrcode.getCameras().then(devices => {
        if (!devices || devices.length === 0) {
            resultBox.innerHTML = `<span class="error">⚠️ No camera found. Check permissions or browser.</span>`;
            playSound('denied');
            speak("No camera found");
            return;
        }

        cameraSelect.innerHTML = "";
        devices.forEach((device, i) => {
            const opt = document.createElement('option');
            opt.value = device.id;
            opt.textContent = device.label || `Camera ${i + 1}`;
            cameraSelect.appendChild(opt);
        });

        currentCameraId = devices[0].id;
        cameraSelect.value = currentCameraId;
        startScanner(currentCameraId);
    }).catch(err => {
        playSound('denied');
        showPermissionPrompt();
        speak("Camera permission denied");
    });
}

// 🔐 Permissions
async function requestPermission() {
    try {
        await navigator.mediaDevices.getUserMedia({ video: true });
        loadCameras();
    } catch (err) {
        playSound('denied');
        showPermissionPrompt();
        speak("Please allow camera access");
    }
}
function showPermissionPrompt() {
    resultBox.innerHTML = `
        <div class="error mt-3">
            ❌ Camera access denied.<br><br>
            Click 🔒 near the URL → Allow Camera → Retry.<br><br>
            <button class="btn btn-primary btn-sm" onclick="retryPermission()">🔁 Retry</button>
        </div>`;
}
function retryPermission() { requestPermission(); }

// 🔄 Switch Cameras
switchBtn.addEventListener('click', () => {
    const opts = Array.from(cameraSelect.options);
    if (opts.length < 2) return;
    let idx = opts.findIndex(o => o.value === cameraSelect.value);
    idx = (idx + 1) % opts.length;
    currentCameraId = opts[idx].value;
    cameraSelect.value = currentCameraId;
    startScanner(currentCameraId);
});
cameraSelect.addEventListener('change', e => {
    currentCameraId = e.target.value;
    startScanner(currentCameraId);
});

// ✨ Helpers
function animateBorder(color) {
    readerEl.style.borderColor = color;
    setTimeout(() => readerEl.style.borderColor = '#ccc', 700);
}

// ✅ Store and show recent scans
function addRecentScan(name) {
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    recentScans.unshift({ name, time });
    if (recentScans.length > 5) recentScans.pop();
    renderRecentScans();
}

function renderRecentScans() {
    let html = "<div class='mt-3'><h5 class='fw-bold'>Recent Scans</h5><ul class='list-unstyled mb-0'>";
    recentScans.forEach((s, i) => {
        html += `<li>${i + 1}. <strong>${s.name}</strong> <span class="text-muted">– ${s.time}</span></li>`;
    });
    html += "</ul></div>";
    document.getElementById('recentScansBox')?.remove();
    const box = document.createElement('div');
    box.id = 'recentScansBox';
    box.innerHTML = html;
    resultBox.insertAdjacentElement('afterend', box);
}

// ▶️ Init
startBtn.addEventListener('click', () => {
    unlockAudio();
    startBtn.style.display = 'none';
    readerEl.style.display = 'block';
    camControls.style.display = 'flex';
    requestPermission();
});
</script>
@endpush

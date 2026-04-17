@extends('layouts.main')

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/scanner.css') }}">

@endpush

@section('content')
<div class="container text-center">
    <h2 class="fw-bold">{{ $event->title ?? 'Attendance Event' }}</h2>
    <h4 class="text-muted mb-3">{{ __('Scan a memberÃ¢â‚¬â„¢s QR code to mark attendance.') }}</h4>

    <button id="startBtn" class="btn btn-primary">
        <i class="ti ti-camera"></i> {{ __('Start Scanner') }}
    </button>

    <div class="camera-control mt-3 churchmeet-hidden" id="camControls">
        <select id="cameraSelect" class="form-select d-inline w-auto"></select>
        <button id="switchBtn" class="btn btn-outline-primary btn-sm">
            <i class="ti ti-refresh"></i> {{ __('Switch Camera') }}
        </button>
    </div>

    <div id="reader" class="churchmeet-hidden"></div>
    <div class="offline-banner" id="offlineBanner">{{ __('Ã¢Å¡Â Ã¯Â¸Â Offline Mode: Scans will sync later') }}</div>
    <div id="scanResult" class="scan-result"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
const markUrl = "{{ route('churchmeet.attendance_events.mark', $event->id) }}";
const resultBox = document.getElementById('scanResult');
const offlineBanner = document.getElementById('offlineBanner');
const cameraSelect = document.getElementById('cameraSelect');
const switchBtn = document.getElementById('switchBtn');
const startBtn = document.getElementById('startBtn');
const camControls = document.getElementById('camControls');
const readerEl = document.getElementById('reader');
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

let html5QrCode, currentCameraId, lastScan = '';
let offlineQueue = JSON.parse(localStorage.getItem('offlineScans') || "[]");
let recentScans = [];

// Ã°Å¸â€Å  SOUND DEFINITIONS
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

// Ã°Å¸â€”Â£Ã¯Â¸Â Text-to-Speech
function speak(text, lang = 'en-US') {
    if (!window.speechSynthesis) return;
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = lang;
    utter.rate = 1;
    utter.pitch = 1;
    speechSynthesis.cancel();
    speechSynthesis.speak(utter);
}

// Ã°Å¸Å’Â Connectivity
window.addEventListener('offline', () => {
    offlineBanner.style.display = 'block';
    playSound('offline');
});
window.addEventListener('online', () => {
    offlineBanner.style.display = 'none';
    syncOffline();
});

// Ã°Å¸â€œâ€¹ Attendance Logic
function markAttendance(qrData) {
    if (qrData === lastScan) return;
    lastScan = qrData;

    if (!navigator.onLine) {
        offlineQueue.push({ qr: qrData, event_id: {{ $event->id }}, ts: Date.now() });
        localStorage.setItem('offlineScans', JSON.stringify(offlineQueue));
        playSound('offline');
        resultBox.innerHTML = `<span class='error'>Ã°Å¸â€œÂ¡ Offline Ã¢â‚¬â€œ will sync later</span>`;
        return;
    }

    fetch(markUrl, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ qr: qrData, _token: csrfToken })
    })
    .then(r => r.json())
    .then(res => {
        // Ã¢Å“â€¦ SUCCESS
        if (res.ok) {
            playSound('success');
            animateBorder('#16a34a');
            resultBox.innerHTML = `<span class='success'>Ã¢Å“â€¦ ${res.message}</span>`;

            const memberName = res.member_name || res.message || "Member";
            speak(`${memberName} marked present!`);
            addRecentScan(memberName);
        }
        // Ã¢Å¡Â Ã¯Â¸Â ALREADY MARKED PRESENT
        else if (res.already_marked) {
            playSound('error');
            animateBorder('#f59e0b');
            const name = res.member_name || "This member";
            resultBox.innerHTML = `
                <span class='error'>Ã¢Å¡Â Ã¯Â¸Â ${name} already marked present!<br>No need to retry.<br>God bless you Ã°Å¸â„¢Â</span>`;
            speak("Already marked present. No need to retry. God bless you.");
        }
        // Ã¢ÂÅ’ OTHER ERRORS
        else {
            playSound('error');
            animateBorder('#dc2626');
            resultBox.innerHTML = `<span class='error'>Ã¢ÂÅ’ ${res.error}</span>`;
            speak("Error marking attendance");
        }
        setTimeout(() => lastScan = '', 2000);
    })
    .catch(() => {
        playSound('error');
        animateBorder('#dc2626');
        resultBox.innerHTML = `<span class='error'>Ã¢Å¡Â Ã¯Â¸Â Network error</span>`;
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

// Ã°Å¸Å½Â¥ Camera Control
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
            resultBox.innerHTML = `<span class="error">Ã¢Å¡Â Ã¯Â¸Â No camera found. Check permissions or browser.</span>`;
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

// Ã°Å¸â€Â Permissions
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
            Ã¢ÂÅ’ Camera access denied.<br><br>
            Click Ã°Å¸â€â€™ near the URL Ã¢â€ â€™ Allow Camera Ã¢â€ â€™ Retry.<br><br>
            <button class="btn btn-primary btn-sm" onclick="retryPermission()">Ã°Å¸â€Â Retry</button>
        </div>`;
}
function retryPermission() { requestPermission(); }

// Ã°Å¸â€â€ž Switch Cameras
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

// Ã¢Å“Â¨ Helpers
function animateBorder(color) {
    readerEl.style.borderColor = color;
    const defaultBorderColor = getComputedStyle(document.documentElement)
        .getPropertyValue('--app-card-border-color')
        .trim() || 'rgb(226 232 240 / var(--tw-border-opacity, 1))';
    setTimeout(() => readerEl.style.borderColor = defaultBorderColor, 700);
}

// Ã¢Å“â€¦ Store and show recent scans
function addRecentScan(name) {
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    recentScans.unshift({ name, time });
    if (recentScans.length > 5) recentScans.pop();
    renderRecentScans();
}

function renderRecentScans() {
    let html = "<div class='mt-3'><h5 class='fw-bold'>Recent Scans</h5><ul class='list-unstyled mb-0'>";
    recentScans.forEach((s, i) => {
        html += `<li>${i + 1}. <strong>${s.name}</strong> <span class="text-muted">Ã¢â‚¬â€œ ${s.time}</span></li>`;
    });
    html += "</ul></div>";
    document.getElementById('recentScansBox')?.remove();
    const box = document.createElement('div');
    box.id = 'recentScansBox';
    box.innerHTML = html;
    resultBox.insertAdjacentElement('afterend', box);
}

// Ã¢â€“Â¶Ã¯Â¸Â Init
startBtn.addEventListener('click', () => {
    unlockAudio();
    startBtn.style.display = 'none';
    readerEl.style.display = 'block';
    camControls.style.display = 'flex';
    requestPermission();
});
</script>
@endpush


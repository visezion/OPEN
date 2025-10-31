@extends('layouts.main')

@section('page-title', __('Church Program Timer'))

@section('content')
<style>
    .bodys {
 
    color: black;
    font-family: Arial, sans-serif;
    text-align: center;
    padding: 20px;
    }

    .circle-timer svg {
        transform: rotate(-90deg);
    }

    .circle-timer {
        margin: 20px auto;
    }

    .message {
        font-size: 40px;
        margin: 10px;
    }

    .program-list {
        max-height: 300px;
        overflow-y: auto;
        background: rgba(255, 255, 255, 0.1);
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
    }

    .program-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 5px;
    }

    input,
    button,
    label {
        margin: 5px;
        padding: 10px;
        font-size: 16px;
    }

    .log {
        margin-top: 20px;
        background: rgba(0, 0, 0, 0.3);
        padding: 10px;
        border-radius: 5px;
        white-space: pre-line;
    }

    .clock {
        font-size: 20px;
        margin-bottom: 10px;
    }

    .card-body {
        flex: 1 1 auto;
        padding: var(--bs-card-spacer-y) var(--bs-card-spacer-x);
        color: #000;
        background: #fff;
    }

    </style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div styly="background: #2a314c;"class="card-body">
                

<div class="bodys">
    <a href="{{ route('timer.doc') }}" class="btn btn-dark">
    <b>CLICK TO LEARN HOW TO USE THE TIMER</b>
</a><br><br>
<hr><br>
    <h1>Stage Timer</h1>
    <div class="clock" id="realClock"></div>
    <div id="programLabel">Waiting for program...</div>
    <div class="circle-timer">
        <svg width="200" height="200">
            <circle r="90" cx="100" cy="100" stroke="#555" stroke-width="15" fill="none"></circle>
            <circle id="progressRing" r="90" cx="100" cy="100" stroke="limegreen" stroke-width="15" fill="none" stroke-dasharray="565.48" stroke-dashoffset="565.48"></circle>
        </svg>
    </div>
    <div class="message" id="message">00:00</div>
    <label><input type="checkbox" id="autoStartSchedule"> Auto Start Schedule</label><br>
    <button class="btn btn-danger ms-2" onclick="loadPredefinedPrograms()">Load Schedule</button>
    <button class="btn btn-success ms-2" onclick="savePrograms()">Save Schedule</button>
    <button class="btn btn-info ms-2" onclick="loadSavedPrograms()">Load Saved</button>
    <button class="btn btn-warning   ms-2" onclick="addNewProgram()">Add Program</button>
    <button class="btn btn-dark" onclick="openMonitorView()">Open Monitor View</button>
    <div class="program-list" id="programList"></div>
    <div class="log" id="log"></div>

    <script>
        let programs = [];
        let timerInterval = null;
        let log = [];
        let monitorWindow = null;

        function updateClock() {
            document.getElementById('realClock').textContent = new Date().toLocaleTimeString();
            if (monitorWindow && !monitorWindow.closed) {
                monitorWindow.postMessage({ type: 'clock', time: new Date().toLocaleTimeString() }, '*');
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        function updateProgramList() {
            const list = document.getElementById('programList');
            list.innerHTML = '';
            programs.forEach((prog, index) => {
                const item = document.createElement('div');
                item.className = 'program-item';
                item.innerHTML = `
                    <input value="${prog.type}" onchange="programs[${index}].type=this.value" />
                    <input type="time" value="${prog.startTime || ''}" onchange="programs[${index}].startTime=this.value" />
                    <input type="number" value="${prog.duration}" onchange="programs[${index}].duration=parseInt(this.value)" />
                    <label><input type="checkbox" ${prog.showExitMessage ? 'checked' : ''} onchange="programs[${index}].showExitMessage=this.checked" /> Show 'Exit Stage'</label>
                    <button class="btn btn-success ms-2" onclick="startProgram(${index})">Play</button>
                    <button class="btn btn-dark ms-2" onclick="moveUp(${index})">Up</button>
                    <button class="btn btn-dark ms-2" onclick="moveDown(${index})">Down</button>
                    <button class="btn btn-danger ms-2" onclick="deleteProgram(${index})">Delete</button>
                `;
                list.appendChild(item);
            });
        }

        function moveUp(index) { if (index > 0) { [programs[index], programs[index - 1]] = [programs[index - 1], programs[index]]; updateProgramList(); } }
        function moveDown(index) { if (index < programs.length - 1) { [programs[index], programs[index + 1]] = [programs[index + 1], programs[index]]; updateProgramList(); } }
        function deleteProgram(index) { programs.splice(index, 1); updateProgramList(); }

        function startProgram(index) {
            clearInterval(timerInterval);
            const ring = document.getElementById('progressRing');
            const msg = document.getElementById('message');
            const prog = programs[index];
            if (!prog) return;
            let total = prog.duration * 60;
            let remaining = total;
            document.getElementById('programLabel').textContent = prog.type;
            ring.style.strokeDashoffset = 565.48;
            if (monitorWindow && !monitorWindow.closed) {
                monitorWindow.postMessage({ type: 'start', label: prog.type, time: '00:00' }, '*');
            }
            timerInterval = setInterval(() => {
                let percent = ((total - remaining) / total) * 100;
                ring.style.strokeDashoffset = 565.48 - (565.48 * percent / 100);
                if (remaining > 45) {
                    const min = String(Math.floor(remaining / 60)).padStart(2, '0');
                    const sec = String(remaining % 60).padStart(2, '0');
                    msg.textContent = `${min}:${sec}`;
                    if (monitorWindow && !monitorWindow.closed) {
                        monitorWindow.postMessage({ type: 'update', time: `${min}:${sec}` }, '*');
                    }
                } else if (remaining <= 45 && remaining >= 0) {
                    msg.textContent = 'TIME UP!!!';
                    if (prog.showExitMessage) {
                        document.getElementById('programLabel').textContent = 'KINDLY EXIT THE STAGE !!!';
                        if (monitorWindow && !monitorWindow.closed) {
                            monitorWindow.postMessage({ type: 'label', label: 'KINDLY EXIT THE STAGE !!!' }, '*');
                        }
                    }
                    if (monitorWindow && !monitorWindow.closed) {
                        monitorWindow.postMessage({ type: 'update', time: 'TIME UP!!!' }, '*');
                    }
                }
                if (remaining === 0) {
                    clearInterval(timerInterval);
                    log.push(`${prog.type} finished at ${new Date().toLocaleTimeString()}`);
                    document.getElementById('log').textContent = log.join('\n');
                    const nextProg = programs[index + 1];
                    if (document.getElementById('autoStartSchedule').checked && nextProg) {
                        setTimeout(() => { startProgram(index + 1); }, 3000);
                    }
                }
                remaining--;
            }, 1000);
        }

        function addNewProgram() {
            programs.push({ type: '🆕 New', duration: 5, startTime: '', showExitMessage: true });
            updateProgramList();
        }

        function savePrograms() { localStorage.setItem('churchPrograms', JSON.stringify(programs)); alert('Schedule saved!'); }
        function loadSavedPrograms() { const saved = localStorage.getItem('churchPrograms'); if (saved) { programs = JSON.parse(saved); updateProgramList(); alert('Schedule loaded!'); } }

        function loadPredefinedPrograms() {
            programs = [
                { type: "🙏 Opening Prayer", duration: 5, startTime: "10:00", showExitMessage: true },
                { type: "🎶 Worship and Hymn", duration: 10, startTime: "10:05", showExitMessage: true },
                { type: "🎶 Praise", duration: 10, startTime: "10:15", showExitMessage: true },
                { type: "🙏 Prayer 1", duration: 6, startTime: "10:25", showExitMessage: true },
                { type: "🙏 Prayer 2", duration: 6, startTime: "10:31", showExitMessage: true },
                { type: "🗣️ Testimony", duration: 10, startTime: "10:37", showExitMessage: true },
                { type: "🎤 Ministration", duration: 15, startTime: "10:47", showExitMessage: true },
                { type: "🎤 Special Ministration", duration: 8, startTime: "11:02", showExitMessage: true },
                { type: "🙏 Special Prayer", duration: 5, startTime: "11:10", showExitMessage: true },
                { type: "📖 Sermon", duration: 40, startTime: "11:15", showExitMessage: false },
                { type: "📢 Announcement", duration: 5, startTime: "11:55", showExitMessage: true },
                { type: "🙏 Prayer", duration: 5, startTime: "12:00", showExitMessage: true }
            ];
            updateProgramList();
            alert('Predefined schedule loaded!');
        }

        function openMonitorView() {
            monitorWindow = window.open('', 'Monitor View', 'width=800,height=600');
            const content = `<!DOCTYPE html><html><head><title>Monitor View</title><style>body{background:black;color:white;text-align:center;font-family:sans-serif;padding-top:50px;}#clock{font-size:24px;margin-bottom:20px;}#time{font-size:150px;margin:20px 0;}#label{font-size:24px;}</style></head><body><div id='clock'>--:--:--</div><div id='time'>00:00</div><div id='label'>Waiting for program...</div><script>window.addEventListener('message',function(e){if(e.data.type==='clock'){document.getElementById('clock').textContent=e.data.time;}else if(e.data.type==='update'){document.getElementById('time').textContent=e.data.time;}else if(e.data.type==='start'){document.getElementById('label').textContent=e.data.label;document.getElementById('time').textContent=e.data.time;}else if(e.data.type==='label'){document.getElementById('label').textContent=e.data.label;}});<\/script></body></html>`;
            monitorWindow.document.write(content);
        }
    </script>
</div>


@endsection

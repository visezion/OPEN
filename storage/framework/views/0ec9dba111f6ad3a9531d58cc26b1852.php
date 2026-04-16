<?php $__env->startSection('page-title', __('LiveKit Room')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('ChurchMeet')); ?>,<?php echo e(__('LiveKit Room')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
    .livekit-room .card { border: 1px solid #d8e2ef !important; box-shadow: none !important; }
    .livekit-room .stage {
        border-radius: 14px;
        background: linear-gradient(180deg, #19324a, #0f2234);
        color: #fff;
        padding: 1rem;
        min-height: 460px;
    }
    .livekit-room .participant-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
    }
    .livekit-room .participant-card {
        border: 1px solid rgba(255,255,255,.12);
        background: rgba(255,255,255,.06);
        border-radius: 12px;
        overflow: hidden;
    }
    .livekit-room .participant-header {
        display: flex;
        justify-content: space-between;
        gap: .75rem;
        align-items: center;
        padding: .75rem .9rem;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .livekit-room .participant-media {
        position: relative;
        min-height: 180px;
        background: rgba(11,18,27,.6);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: .75rem;
    }
    .livekit-room .participant-media video,
    .livekit-room .participant-media audio {
        max-width: 100%;
        width: 100%;
        border-radius: 10px;
        background: #000;
    }
    .livekit-room .participant-placeholder {
        color: rgba(255,255,255,.68);
        text-align: center;
        font-size: .9rem;
    }
    .livekit-room .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        display: inline-block;
        background: #f59e0b;
    }
    .livekit-room .status-dot.connected {
        background: #22c55e;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row livekit-room">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"><?php echo e($attendanceEvent->event->title ?? __('LiveKit Room')); ?></h5>
                    <small class="text-muted"><?php echo e(__('Room')); ?>: <?php echo e($livekitRoomName); ?></small>
                </div>
                <div class="text-end">
                    <div class="fw-semibold"><span id="connection-dot" class="status-dot"></span> <span id="connection-status"><?php echo e(__('Not connected')); ?></span></div>
                    <small class="text-muted"><?php echo e($participantName); ?></small>
                </div>
            </div>
            <div class="card-body">
                <div class="stage">
                    <div class="participant-grid" id="participant-grid">
                        <div class="participant-card" data-participant="placeholder">
                            <div class="participant-header">
                                <strong><?php echo e(__('Waiting for room connection')); ?></strong>
                            </div>
                            <div class="participant-media">
                                <div class="participant-placeholder"><?php echo e(__('Connect to load your local stream and any remote participants.')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="room-message" class="alert alert-warning py-2 px-3 mt-3 mb-0 d-none"></div>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <button type="button" class="btn btn-primary" id="join-room"><?php echo e(__('Reconnect LiveKit Room')); ?></button>
                    <button type="button" class="btn btn-outline-dark" id="toggle-fullscreen"><?php echo e(__('Full Screen')); ?></button>
                    <button type="button" class="btn btn-outline-secondary" id="toggle-mic" disabled><?php echo e(__('Mute Mic')); ?></button>
                    <button type="button" class="btn btn-outline-secondary" id="toggle-camera" disabled><?php echo e(__('Stop Camera')); ?></button>
                    <button type="button" class="btn btn-outline-danger" id="leave-room" disabled><?php echo e(__('Leave Room')); ?></button>
                </div>
                <small class="text-muted d-block mt-2"><?php echo e(__('ChurchMeet will mark your presence when the room connects and update it again when you leave.')); ?></small>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white"><h6 class="mb-0"><?php echo e(__('Room Details')); ?></h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Platform')); ?></span><strong><?php echo e(__('LiveKit')); ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Room Name')); ?></span><strong><?php echo e($livekitRoomName); ?></strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted"><?php echo e(__('Server URL')); ?></span><strong><?php echo e($livekitServerUrl); ?></strong></div>
                <div class="d-flex justify-content-between"><span class="text-muted"><?php echo e(__('Attendance Mode')); ?></span><strong><?php echo e(ucfirst($attendanceEvent->mode ?: 'online')); ?></strong></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0"><?php echo e(__('Usage Notes')); ?></h6></div>
            <div class="card-body">
                <p class="text-muted mb-2"><?php echo e(__('LiveKit rooms are browser-based. Members can join directly from ChurchMeet without leaving OPEN.')); ?></p>
                <p class="text-muted mb-0"><?php echo e(__('If camera or microphone permissions are blocked, reconnect after granting access in your browser settings.')); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="module">
import { Room, RoomEvent, Track } from 'https://cdn.jsdelivr.net/npm/livekit-client@2.18.2/dist/livekit-client.esm.mjs';

const serverUrl = <?php echo json_encode($livekitServerUrl, 15, 512) ?>;
const token = <?php echo json_encode($livekitToken, 15, 512) ?>;
const participantName = <?php echo json_encode($participantName, 15, 512) ?>;
const presenceUrl = <?php echo json_encode(route('churchmeet.meetings.presence', $attendanceEvent->id), 512) ?>;

const grid = document.getElementById('participant-grid');
const joinButton = document.getElementById('join-room');
const leaveButton = document.getElementById('leave-room');
const fullscreenButton = document.getElementById('toggle-fullscreen');
const micButton = document.getElementById('toggle-mic');
const cameraButton = document.getElementById('toggle-camera');
const connectionStatus = document.getElementById('connection-status');
const connectionDot = document.getElementById('connection-dot');
const roomMessage = document.getElementById('room-message');
const stage = document.querySelector('.livekit-room .stage');

let room = null;
let isMicEnabled = true;
let isCameraEnabled = true;
let hasJoinedPresence = false;
let autoJoinAttempted = false;

function setStatus(label, connected = false) {
    connectionStatus.textContent = label;
    connectionDot.classList.toggle('connected', connected);
}

function syncFullscreenButton() {
    if (!fullscreenButton) {
        return;
    }

    fullscreenButton.textContent = document.fullscreenElement ? 'Exit Full Screen' : 'Full Screen';
}

function setRoomMessage(message = '', type = 'warning') {
    if (!roomMessage) {
        return;
    }

    roomMessage.className = `alert alert-${type} py-2 px-3 mt-3 mb-0`;
    roomMessage.textContent = message;
    roomMessage.classList.toggle('d-none', !message);
}

function resetGrid() {
    grid.innerHTML = `
        <div class="participant-card" data-participant="placeholder">
            <div class="participant-header">
                <strong>Waiting for room connection</strong>
            </div>
            <div class="participant-media">
                <div class="participant-placeholder">Connect to load your local stream and any remote participants.</div>
            </div>
        </div>
    `;
}

function ensureCard(identity, name, isLocal = false) {
    grid.querySelector('[data-participant="placeholder"]')?.remove();

    let card = grid.querySelector(`[data-participant="${CSS.escape(identity)}"]`);
    if (card) {
        return card;
    }

    card = document.createElement('div');
    card.className = 'participant-card';
    card.dataset.participant = identity;
    card.innerHTML = `
        <div class="participant-header">
            <strong>${name || identity}</strong>
            <span class="badge bg-light text-dark">${isLocal ? 'You' : 'Remote'}</span>
        </div>
        <div class="participant-media">
            <div class="participant-placeholder">Waiting for media...</div>
        </div>
    `;
    grid.appendChild(card);

    return card;
}

function attachTrack(track, identity, name, isLocal = false) {
    const card = ensureCard(identity, name, isLocal);
    const media = card.querySelector('.participant-media');
    const placeholder = media.querySelector('.participant-placeholder');

    if (track.kind === Track.Kind.Video) {
        media.querySelectorAll('video').forEach((element) => element.remove());
        placeholder?.remove();

        const element = track.attach();
        element.autoplay = true;
        element.playsInline = true;
        element.muted = isLocal;
        media.appendChild(element);
        return;
    }

    if (track.kind === Track.Kind.Audio) {
        placeholder?.remove();
        const element = track.attach();
        element.autoplay = true;
        media.appendChild(element);
    }
}

function detachParticipant(identity) {
    grid.querySelector(`[data-participant="${CSS.escape(identity)}"]`)?.remove();

    if (!grid.children.length) {
        resetGrid();
    }
}

async function markPresence(action) {
    if (action === 'join') {
        hasJoinedPresence = true;
    }

    await fetch(presenceUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ action }),
    }).catch(() => null);
}

function sendLeaveBeacon() {
    if (!hasJoinedPresence) {
        return;
    }

    const payload = new URLSearchParams({ action: 'leave' });
    navigator.sendBeacon(presenceUrl, payload);
    hasJoinedPresence = false;
}

async function joinRoom() {
    if (room || !serverUrl || !token) {
        return;
    }

    joinButton.disabled = true;
    setStatus('Connecting...');
    setRoomMessage('');

    try {
        room = new Room();

        room.on(RoomEvent.Connected, async () => {
            setStatus('Connected', true);
            leaveButton.disabled = false;
            micButton.disabled = false;
            cameraButton.disabled = false;
            await markPresence('join');
        });

        room.on(RoomEvent.Disconnected, () => {
            sendLeaveBeacon();
            setStatus('Disconnected');
            setRoomMessage('');
            leaveButton.disabled = true;
            micButton.disabled = true;
            cameraButton.disabled = true;
            joinButton.disabled = false;
            room = null;
            isMicEnabled = true;
            isCameraEnabled = true;
            micButton.textContent = 'Mute Mic';
            cameraButton.textContent = 'Stop Camera';
            resetGrid();
        });

        room.on(RoomEvent.LocalTrackPublished, (publication) => {
            if (publication.track) {
                attachTrack(publication.track, room.localParticipant.identity, participantName, true);
            }
        });

        room.on(RoomEvent.TrackSubscribed, (track, publication, participant) => {
            attachTrack(track, participant.identity, participant.name || participant.identity, false);
        });

        room.on(RoomEvent.TrackUnsubscribed, (track, publication, participant) => {
            track.detach().forEach((element) => element.remove());
            const card = grid.querySelector(`[data-participant="${CSS.escape(participant.identity)}"]`);
            if (card && !card.querySelector('video') && !card.querySelector('audio')) {
                card.querySelector('.participant-media').innerHTML = '<div class="participant-placeholder">Waiting for media...</div>';
            }
        });

        room.on(RoomEvent.ParticipantConnected, (participant) => {
            ensureCard(participant.identity, participant.name || participant.identity, false);
        });

        room.on(RoomEvent.ParticipantDisconnected, (participant) => {
            detachParticipant(participant.identity);
        });

        room.on(RoomEvent.ConnectionStateChanged, (state) => {
            if (state === 'reconnecting') {
                setStatus('Reconnecting...');
            }
        });

        await room.connect(serverUrl, token);
        ensureCard(room.localParticipant.identity, participantName, true);

        try {
            await room.localParticipant.setMicrophoneEnabled(true);
            micButton.textContent = 'Mute Mic';
            micButton.disabled = false;
        } catch (error) {
            isMicEnabled = false;
            micButton.textContent = 'Mic unavailable';
            micButton.disabled = true;
            setRoomMessage('Connected, but microphone access was blocked or unavailable.', 'warning');
        }

        try {
            await room.localParticipant.setCameraEnabled(true);
            cameraButton.textContent = 'Stop Camera';
            cameraButton.disabled = false;
        } catch (error) {
            isCameraEnabled = false;
            cameraButton.textContent = 'Camera unavailable';
            cameraButton.disabled = true;
            setRoomMessage(
                roomMessage?.textContent
                    ? `${roomMessage.textContent} Camera access was also blocked or unavailable.`
                    : 'Connected, but camera access was blocked or unavailable.',
                'warning'
            );
        }

        room.remoteParticipants.forEach((participant) => {
            ensureCard(participant.identity, participant.name || participant.identity, false);
            participant.trackPublications.forEach((publication) => {
                if (publication.track) {
                    attachTrack(publication.track, participant.identity, participant.name || participant.identity, false);
                }
            });
        });
    } catch (error) {
        console.error(error);
        setStatus('Connection failed');
        setRoomMessage(error?.message || 'Unable to connect to the LiveKit room.', 'danger');
        joinButton.disabled = false;
        leaveButton.disabled = true;
        micButton.disabled = true;
        cameraButton.disabled = true;
        room = null;
    }
}

function attemptAutoJoin() {
    if (autoJoinAttempted) {
        return;
    }

    autoJoinAttempted = true;

    if (!serverUrl || !token) {
        setRoomMessage('LiveKit room details are incomplete. Check the integration settings and room token.', 'danger');
        return;
    }

    setStatus('Connecting...');
    setRoomMessage('Connecting to the LiveKit room automatically...', 'info');
    joinRoom();
}

async function leaveRoom() {
    if (!room) {
        return;
    }

    sendLeaveBeacon();
    room.disconnect();
}

joinButton.addEventListener('click', joinRoom);
leaveButton.addEventListener('click', leaveRoom);

fullscreenButton?.addEventListener('click', async () => {
    if (!stage) {
        return;
    }

    try {
        if (document.fullscreenElement) {
            await document.exitFullscreen();
        } else {
            await stage.requestFullscreen();
        }
    } catch (error) {
        setRoomMessage('Fullscreen mode is not available in this browser.', 'warning');
    }
});

micButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    isMicEnabled = !isMicEnabled;
    await room.localParticipant.setMicrophoneEnabled(isMicEnabled);
    micButton.textContent = isMicEnabled ? 'Mute Mic' : 'Unmute Mic';
});

cameraButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    isCameraEnabled = !isCameraEnabled;
    await room.localParticipant.setCameraEnabled(isCameraEnabled);
    cameraButton.textContent = isCameraEnabled ? 'Stop Camera' : 'Start Camera';
});

window.addEventListener('beforeunload', () => {
    sendLeaveBeacon();
});

document.addEventListener('fullscreenchange', syncFullscreenButton);

attemptAutoJoin();
syncFullscreenButton();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\integrations\livekit_join.blade.php ENDPATH**/ ?>
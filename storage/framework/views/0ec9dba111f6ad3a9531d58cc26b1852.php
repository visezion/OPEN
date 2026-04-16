<?php $__env->startSection('page-title', __('LiveKit Room')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('ChurchMeet')); ?>,<?php echo e(__('LiveKit Room')); ?>

<?php $__env->stopSection(); ?>

<?php
    $meetingTitle = $attendanceEvent->event->title ?? __('LiveKit Room');
    $meetingMode = strtoupper($attendanceEvent->mode ?: 'online');
    $participantBadge = \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(preg_replace('/\s+/', '', $participantName), 0, 2));
    $companySettings = getCompanyAllSetting(creatorId());
    $themePalette = [
        'theme-1' => '#0CAF60',
        'theme-2' => '#75C251',
        'theme-3' => '#584ED2',
        'theme-4' => '#145388',
        'theme-5' => '#B9406B',
        'theme-6' => '#008ECC',
        'theme-7' => '#922C88',
        'theme-8' => '#C0A145',
        'theme-9' => '#48494B',
        'theme-10' => '#0C7785',
    ];
    $rawBrandColor = trim((string) ($companySettings['color'] ?? 'theme-1'));
    $normalizedBrandColor = strtolower($rawBrandColor);
    $brandPrimary = '#145388';

    if (isset($themePalette[$normalizedBrandColor])) {
        $brandPrimary = $themePalette[$normalizedBrandColor];
    } else {
        $candidateBrandColor = $rawBrandColor;
        if ($candidateBrandColor !== '') {
            if (!str_starts_with($candidateBrandColor, '#')) {
                $candidateBrandColor = '#' . $candidateBrandColor;
            }

            if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $candidateBrandColor)) {
                $brandPrimary = $candidateBrandColor;
            }
        }
    }

    $brandHex = ltrim($brandPrimary, '#');
    if (strlen($brandHex) === 3) {
        $brandHex = preg_replace('/(.)/', '$1$1', $brandHex);
    }
    $brandRgb = sscanf(substr($brandHex, 0, 6), '%02x%02x%02x') ?: [20, 83, 136];
    $brandRgbString = implode(', ', $brandRgb);
?>

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/livekit-room.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="livekit-room" data-brand-primary="<?php echo e($brandPrimary); ?>" data-brand-rgb="<?php echo e($brandRgbString); ?>">
    <div class="livekit-room-shell">
        <div class="meeting-topbar">
            <div class="meeting-brand">
                <span class="brand-mark"><i class="ti ti-brand-webrtc"></i></span>
                <div>
                    <div class="meeting-kicker"><?php echo e(__('ChurchMeet Live Session')); ?></div>
                    <h2 class="meeting-title"><?php echo e($meetingTitle); ?></h2>
                    <p class="meeting-subtitle"><?php echo e(__('Join, chat, and watch the room from one screen.')); ?></p>
                </div>
            </div>

            <div class="meeting-status-cluster">
                <div class="meeting-pill">
                    <span id="connection-dot" class="status-dot"></span>
                    <span id="connection-status"><?php echo e(__('Not connected')); ?></span>
                </div>

                <div class="meeting-pill meeting-pill-live">
                    <span class="live-dot"></span>
                    <strong><?php echo e(__('Live')); ?></strong>
                    <span id="joined-minutes"><?php echo e(__('0 min')); ?></span>
                </div>

                <a href="<?php echo e(route('churchmeet.events.show', $attendanceEvent->event_id)); ?>" class="meeting-pill text-decoration-none">
                    <i class="ti ti-external-link"></i>
                    <span><?php echo e(__('Open Event')); ?></span>
                </a>

                <div class="meeting-avatar"><?php echo e($participantBadge ?: 'LK'); ?></div>
            </div>
        </div>

        <div class="meeting-layout">
            <section class="stage-panel">
                <div class="stage-meta">
                    <div>
                        <div class="meta-tags">
                            <span class="meta-tag">
                                <i class="ti ti-device-tv"></i>
                                <span id="room-short-name"><?php echo e(\Illuminate\Support\Str::limit($livekitRoomName, 18, '...')); ?></span>
                            </span>
                            <span class="meta-tag">
                                <i class="ti ti-sparkles"></i>
                                <span><?php echo e($meetingMode); ?></span>
                            </span>
                            <span class="meta-tag">
                                <i class="ti ti-user-circle"></i>
                                <span><?php echo e($participantName); ?></span>
                            </span>
                        </div>

                        <h3 class="mt-3"><?php echo e(__('Meeting Stage')); ?></h3>
                        <p><?php echo e(__('Live tiles with quick controls below.')); ?></p>
                    </div>

                    <div class="meta-stats">
                        <div class="meta-stat">
                            <span><?php echo e(__('Attendance')); ?></span>
                            <strong id="attendance-percent"><?php echo e(__('Pending')); ?></strong>
                        </div>
                        <div class="meta-stat">
                            <span><?php echo e(__('Participants')); ?></span>
                            <strong id="participant-count">0</strong>
                        </div>
                    </div>
                </div>

                <div class="stage-shell">
                    <div class="stage-topbar">
                        <div class="stage-indicator">
                            <span id="stage-connection-dot" class="status-dot"></span>
                            <span id="stage-connection-status"><?php echo e(__('Waiting for connection')); ?></span>
                        </div>

                        <div class="stage-helper"><?php echo e(__('Room controls stay pinned below.')); ?></div>
                    </div>

                    <div class="stage">
                        <div class="participant-grid" id="participant-grid">
                            <div class="participant-card" data-participant="placeholder">
                                <div class="participant-media">
                                    <div class="participant-avatar">
                                        <span>LK</span>
                                    </div>
                                    <div class="participant-placeholder"><?php echo e(__('Connect to load your local stream and any remote participants.')); ?></div>
                                </div>
                                <div class="participant-footer">
                                    <span class="participant-name"><?php echo e(__('Waiting for room')); ?></span>
                                    <span class="participant-chip"><?php echo e(__('Lobby')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="room-message" class="meeting-alert is-warning d-none"></div>

                <div class="stage-footer">
                    <div class="stage-dots" aria-hidden="true">
                        <span class="is-active"></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="control-dock">
                        <button type="button" class="meeting-control is-primary" id="join-room">
                            <i class="control-icon ti ti-rotate-2"></i>
                            <span class="control-label"><?php echo e(__('Reconnect')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-sidebar">
                            <i class="control-icon ti ti-layout-sidebar-right-collapse"></i>
                            <span class="control-label"><?php echo e(__('Hide Sidebar')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-fullscreen">
                            <i class="control-icon ti ti-maximize"></i>
                            <span class="control-label"><?php echo e(__('Full Screen')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-mic" disabled>
                            <i class="control-icon ti ti-microphone"></i>
                            <span class="control-label"><?php echo e(__('Mute Mic')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-camera" disabled>
                            <i class="control-icon ti ti-video"></i>
                            <span class="control-label"><?php echo e(__('Stop Camera')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-screen-share" disabled>
                            <i class="control-icon ti ti-screen-share"></i>
                            <span class="control-label"><?php echo e(__('Share Screen')); ?></span>
                        </button>

                        <button type="button" class="meeting-control" id="toggle-screen-audio-share" disabled>
                            <i class="control-icon ti ti-device-audio-tape"></i>
                            <span class="control-label"><?php echo e(__('Share Screen + Audio')); ?></span>
                        </button>

                        <button type="button" class="meeting-control is-danger" id="leave-room" disabled>
                            <i class="control-icon ti ti-phone-off"></i>
                            <span class="control-label"><?php echo e(__('Leave')); ?></span>
                        </button>
                    </div>
                </div>
            </section>

            <aside class="sidebar-panel">
                <div class="sidebar-card sidebar-card-main">
                    <div class="sidebar-header">
                        <div>
                            <div class="sidebar-eyebrow"><?php echo e(__('Live Sidebar')); ?></div>
                            <h4><?php echo e(__('Chat & People')); ?></h4>
                        </div>

                        <div class="sidebar-live-pill">
                            <i class="ti ti-message-circle"></i>
                            <span id="chat-count">0</span>
                        </div>
                    </div>

                    <div class="sidebar-tabs">
                        <button type="button" class="sidebar-tab is-active" id="sidebar-tab-chat">
                            <i class="ti ti-message-circle"></i>
                            <span><?php echo e(__('Chat')); ?></span>
                            <span class="sidebar-tab-badge" id="chat-tab-count">0</span>
                        </button>
                        <button type="button" class="sidebar-tab" id="sidebar-tab-participants">
                            <i class="ti ti-users"></i>
                            <span><?php echo e(__('Participants')); ?></span>
                            <span class="sidebar-tab-badge" id="participants-tab-count">0</span>
                        </button>
                    </div>

                    <div class="sidebar-view" id="chat-view">
                        <div class="chat-stream" id="chat-stream">
                            <div class="chat-empty" id="chat-empty-state">
                                <div>
                                    <i class="ti ti-message-circle-2 fs-3 d-block mb-2"></i>
                                    <div class="fw-semibold"><?php echo e(__('No messages yet')); ?></div>
                                    <div><?php echo e(__('Chat clears when the meeting ends.')); ?></div>
                                </div>
                            </div>
                        </div>

                        <form class="chat-compose" id="chat-form">
                            <div class="compose-row">
                                <span class="compose-chip">
                                    <i class="ti ti-clock-hour-4"></i>
                                    <span><?php echo e(__('Temporary')); ?></span>
                                </span>
                                <span class="sidebar-note"><?php echo e(__('Messages disappear after the room closes.')); ?></span>
                            </div>

                            <div class="compose-target-row">
                                <select id="chat-target" class="compose-target-select" aria-label="<?php echo e(__('Choose message recipient')); ?>">
                                    <option value=""><?php echo e(__('Everyone')); ?></option>
                                </select>
                                <span class="compose-chip" id="chat-target-chip">
                                    <i class="ti ti-users"></i>
                                    <span><?php echo e(__('Everyone')); ?></span>
                                </span>
                            </div>

                            <div class="compose-input-wrap">
                                <input type="text" id="chat-input" class="compose-input-control" maxlength="400" placeholder="<?php echo e(__('Message everyone')); ?>">
                                <button type="submit" class="compose-send" id="chat-send" disabled>
                                    <i class="ti ti-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="sidebar-view is-hidden" id="participants-view">
                        <div class="participants-list" id="participants-list">
                            <div class="chat-empty">
                                <div>
                                    <i class="ti ti-users fs-3 d-block mb-2"></i>
                                    <div class="fw-semibold"><?php echo e(__('Waiting for participants')); ?></div>
                                    <div><?php echo e(__('People and their mic/camera status will appear here.')); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-card sidebar-card-compact">
                    <div class="sidebar-note"><?php echo e(__('Session overview')); ?></div>

                    <div class="sidebar-stats">
                        <div class="sidebar-stat">
                            <span><?php echo e(__('In Room')); ?></span>
                            <strong id="participant-count-sidebar">0</strong>
                        </div>
                        <div class="sidebar-stat">
                            <span><?php echo e(__('Messages')); ?></span>
                            <strong id="chat-count-sidebar">0</strong>
                        </div>
                        <div class="sidebar-stat">
                            <span><?php echo e(__('Room')); ?></span>
                            <strong><?php echo e(\Illuminate\Support\Str::limit($livekitRoomName, 14, '...')); ?></strong>
                        </div>
                        <div class="sidebar-stat">
                            <span><?php echo e(__('Mode')); ?></span>
                            <strong><?php echo e($meetingMode); ?></strong>
                        </div>
                    </div>

                    <p class="sidebar-note mb-0"><?php echo e(__('Presence is tracked automatically while the room is connected.')); ?></p>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/js/churchmeet-view-helpers.js')); ?>"></script>
<script type="module">
import { Room, RoomEvent, Track } from 'https://cdn.jsdelivr.net/npm/livekit-client@2.18.2/dist/livekit-client.esm.mjs';

const serverUrl = <?php echo json_encode($livekitServerUrl, 15, 512) ?>;
const token = <?php echo json_encode($livekitToken, 15, 512) ?>;
const participantName = <?php echo json_encode($participantName, 15, 512) ?>;
const participantAvatarUrl = <?php echo json_encode($participantAvatarUrl ?? null, 15, 512) ?>;
const presenceUrl = <?php echo json_encode(route('churchmeet.meetings.presence', $attendanceEvent->id), 512) ?>;

const grid = document.getElementById('participant-grid');
const meetingLayout = document.querySelector('.meeting-layout');
const joinButton = document.getElementById('join-room');
const leaveButton = document.getElementById('leave-room');
const sidebarToggleButton = document.getElementById('toggle-sidebar');
const fullscreenButton = document.getElementById('toggle-fullscreen');
const micButton = document.getElementById('toggle-mic');
const cameraButton = document.getElementById('toggle-camera');
const screenShareButton = document.getElementById('toggle-screen-share');
const screenAudioShareButton = document.getElementById('toggle-screen-audio-share');
const connectionStatus = document.getElementById('connection-status');
const connectionDot = document.getElementById('connection-dot');
const stageConnectionStatus = document.getElementById('stage-connection-status');
const stageConnectionDot = document.getElementById('stage-connection-dot');
const roomMessage = document.getElementById('room-message');
const stage = document.querySelector('.livekit-room .stage');
const joinedMinutes = document.getElementById('joined-minutes');
const attendancePercent = document.getElementById('attendance-percent');
const participantCount = document.getElementById('participant-count');
const participantCountSidebar = document.getElementById('participant-count-sidebar');
const participantsTabCount = document.getElementById('participants-tab-count');
const participantsList = document.getElementById('participants-list');
const chatStream = document.getElementById('chat-stream');
const chatEmptyState = document.getElementById('chat-empty-state');
const chatForm = document.getElementById('chat-form');
const chatTargetSelect = document.getElementById('chat-target');
const chatTargetChip = document.getElementById('chat-target-chip');
const chatInput = document.getElementById('chat-input');
const chatSendButton = document.getElementById('chat-send');
const chatCount = document.getElementById('chat-count');
const chatTabCount = document.getElementById('chat-tab-count');
const chatCountSidebar = document.getElementById('chat-count-sidebar');
const chatView = document.getElementById('chat-view');
const participantsView = document.getElementById('participants-view');
const chatTabButton = document.getElementById('sidebar-tab-chat');
const participantsTabButton = document.getElementById('sidebar-tab-participants');
const textEncoder = new TextEncoder();
const textDecoder = new TextDecoder();

let room = null;
let isMicEnabled = true;
let isCameraEnabled = true;
let hasJoinedPresence = false;
let autoJoinAttempted = false;
let isScreenShareEnabled = false;
let screenShareMode = 'none';
let isSidebarCollapsed = false;
let pinnedParticipantKey = null;
let localScreenTracks = [];
let chatMessages = [];
const participantStates = new Map();
const everyoneLabel = 'Everyone';
const messageEveryonePlaceholder = 'Message everyone';
const messagePrivatePlaceholder = 'Send a private message';

function setStatus(label, connected = false) {
    connectionStatus.textContent = label;
    connectionDot.classList.toggle('connected', connected);
    if (stageConnectionStatus) {
        stageConnectionStatus.textContent = label;
    }
    if (stageConnectionDot) {
        stageConnectionDot.classList.toggle('connected', connected);
    }
}

function setButtonLabel(button, label, icon = null) {
    if (!button) {
        return;
    }

    const labelNode = button.querySelector('.control-label');
    if (labelNode) {
        labelNode.textContent = label;
    } else {
        button.textContent = label;
    }

    if (!icon) {
        return;
    }

    const iconNode = button.querySelector('.control-icon');
    if (iconNode) {
        iconNode.className = `control-icon ti ${icon}`;
    }
}

function formatChatTime(value = new Date()) {
    const date = value instanceof Date ? value : new Date(value);

    return Number.isNaN(date.getTime())
        ? '--:--'
        : date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
}

function createMessageId() {
    if (globalThis.crypto?.randomUUID) {
        return globalThis.crypto.randomUUID();
    }

    return `msg-${Date.now()}-${Math.random().toString(16).slice(2)}`;
}

function setSidebarTab(target = 'chat') {
    const showChat = target === 'chat';
    chatTabButton?.classList.toggle('is-active', showChat);
    participantsTabButton?.classList.toggle('is-active', !showChat);
    chatView?.classList.toggle('is-hidden', !showChat);
    participantsView?.classList.toggle('is-hidden', showChat);
}

function getRemoteParticipantOptions() {
    return [...participantStates.values()]
        .filter((state) => !state.isLocal)
        .sort((left, right) => left.name.localeCompare(right.name));
}

function getSelectedChatTarget() {
    const targetIdentity = chatTargetSelect?.value || '';
    if (!targetIdentity) {
        return null;
    }

    const target = participantStates.get(targetIdentity);
    return target && !target.isLocal ? target : null;
}

function updateChatTargetChip() {
    if (!chatTargetChip) {
        return;
    }

    const target = getSelectedChatTarget();
    const icon = chatTargetChip.querySelector('i');
    const label = chatTargetChip.querySelector('span');

    if (icon) {
        icon.className = `ti ${target ? 'ti-lock' : 'ti-users'}`;
    }

    if (label) {
        label.textContent = target ? `Private to ${target.name}` : everyoneLabel;
    }

    if (chatInput) {
        chatInput.placeholder = target ? `${messagePrivatePlaceholder}: ${target.name}` : messageEveryonePlaceholder;
    }
}

function renderChatTargetOptions() {
    if (!chatTargetSelect) {
        return;
    }

    const selectedValue = chatTargetSelect.value;
    const options = getRemoteParticipantOptions();

    chatTargetSelect.innerHTML = [
        `<option value="">${escapeHtml(everyoneLabel)}</option>`,
        ...options.map((state) => `<option value="${escapeHtml(state.identity)}">${escapeHtml(state.name)}</option>`),
    ].join('');

    const hasSelectedValue = options.some((state) => state.identity === selectedValue);
    chatTargetSelect.value = hasSelectedValue ? selectedValue : '';
    updateChatTargetChip();
}

function setSidebarCollapsed(collapsed) {
    isSidebarCollapsed = !!collapsed;
    meetingLayout?.classList.toggle('is-sidebar-collapsed', isSidebarCollapsed);

    setButtonLabel(
        sidebarToggleButton,
        isSidebarCollapsed ? 'Show Sidebar' : 'Hide Sidebar',
        isSidebarCollapsed ? 'ti-layout-sidebar-right-expand' : 'ti-layout-sidebar-right-collapse'
    );
}

function renderChatMessages() {
    if (!chatStream) {
        return;
    }

    const existingMessages = chatStream.querySelectorAll('.chat-item');
    existingMessages.forEach((node) => node.remove());

    if (!chatMessages.length) {
        chatEmptyState?.classList.remove('d-none');
        return;
    }

    chatEmptyState?.classList.add('d-none');

    chatMessages.forEach((message) => {
        const item = document.createElement('div');
        item.className = `chat-item${message.isLocal ? ' is-self' : ''}${message.isSystem ? ' is-system' : ''}`;
        item.innerHTML = `
            <span class="chat-avatar">${message.isSystem ? '<i class="ti ti-sparkles"></i>' : escapeHtml(getInitials(message.author))}</span>
            <div class="chat-body">
                <div class="chat-meta">
                    <span class="chat-author">
                        <strong>${escapeHtml(message.author)}</strong>
                        ${message.role ? `<span>${escapeHtml(message.role)}</span>` : ''}
                    </span>
                    <span class="chat-time">${formatChatTime(message.sentAt)}</span>
                </div>
                <div class="chat-bubble${message.isLocal ? ' is-you' : ''}${message.isPrivate ? ' is-private' : ''}">${escapeHtml(message.body)}</div>
            </div>
        `;
        chatStream.appendChild(item);
    });

    chatStream.scrollTop = chatStream.scrollHeight;
}

function updateChatCounters() {
    const count = String(chatMessages.filter((message) => !message.isSystem).length);

    if (chatCount) {
        chatCount.textContent = count;
    }
    if (chatTabCount) {
        chatTabCount.textContent = count;
    }
    if (chatCountSidebar) {
        chatCountSidebar.textContent = count;
    }
}

function appendChatMessage(message) {
    chatMessages.push({
        id: message.id || createMessageId(),
        author: message.author || 'Guest',
        role: message.role || '',
        body: message.body || '',
        sentAt: message.sentAt || new Date().toISOString(),
        isLocal: !!message.isLocal,
        isSystem: !!message.isSystem,
        isPrivate: !!message.isPrivate,
    });
    updateChatCounters();
    renderChatMessages();
}

function resetChat() {
    chatMessages = [];
    updateChatCounters();
    renderChatMessages();
}

function updateChatComposerState() {
    const enabled = !!room;
    if (chatTargetSelect) {
        chatTargetSelect.disabled = !enabled;
    }
    if (chatInput) {
        chatInput.disabled = !enabled;
    }
    if (chatSendButton) {
        chatSendButton.disabled = !enabled;
    }
}

function getParticipantState(identity, name = identity, isLocal = false) {
    if (!participantStates.has(identity)) {
        participantStates.set(identity, {
            identity,
            name,
            isLocal,
            avatarUrl: null,
            micOn: false,
            cameraOn: false,
            screenOn: false,
        });
    }

    return participantStates.get(identity);
}

function renderParticipantsList() {
    const states = [...participantStates.values()].sort((left, right) => {
        if (left.isLocal !== right.isLocal) {
            return left.isLocal ? -1 : 1;
        }

        return left.name.localeCompare(right.name);
    });

    const count = String(states.length);
    if (participantCount) {
        participantCount.textContent = count;
    }
    if (participantCountSidebar) {
        participantCountSidebar.textContent = count;
    }
    if (participantsTabCount) {
        participantsTabCount.textContent = count;
    }

    if (!participantsList) {
        renderChatTargetOptions();
        return;
    }

    if (!states.length) {
        participantsList.innerHTML = `
            <div class="chat-empty">
                <div>
                    <i class="ti ti-users fs-3 d-block mb-2"></i>
                    <div class="fw-semibold">Waiting for participants</div>
                    <div>People and their mic/camera status will appear here.</div>
                </div>
            </div>
        `;
        renderChatTargetOptions();
        return;
    }

    participantsList.innerHTML = states.map((state) => `
        <div class="participant-list-item">
            <div class="participant-list-main">
                <span class="participant-list-avatar">${escapeHtml(getInitials(state.name))}</span>
                <div class="participant-list-meta">
                    <span class="participant-list-name">${escapeHtml(state.name)}</span>
                    <span class="participant-list-role">${state.isLocal ? 'You' : 'Guest'}${state.screenOn ? ' / Sharing screen' : ''}</span>
                </div>
            </div>
            <div class="participant-status-icons">
                <span class="status-pill${state.micOn ? '' : ' is-off'}"><i class="ti ${state.micOn ? 'ti-microphone' : 'ti-microphone-off'}"></i></span>
                <span class="status-pill${state.cameraOn ? '' : ' is-off'}"><i class="ti ${state.cameraOn ? 'ti-video' : 'ti-video-off'}"></i></span>
            </div>
        </div>
    `).join('');
    renderChatTargetOptions();
}

function refreshParticipantSummary() {
    renderParticipantsList();
}

function syncFullscreenButton() {
    if (!fullscreenButton) {
        return;
    }

    setButtonLabel(
        fullscreenButton,
        document.fullscreenElement ? 'Exit Full Screen' : 'Full Screen',
        document.fullscreenElement ? 'ti-minimize' : 'ti-maximize'
    );
}

function updateMicButton() {
    if (!micButton) {
        return;
    }

    micButton.classList.toggle('is-off', !isMicEnabled);
    setButtonLabel(
        micButton,
        isMicEnabled ? 'Mute Mic' : 'Unmute Mic',
        isMicEnabled ? 'ti-microphone' : 'ti-microphone-off'
    );
}

function updateCameraButton() {
    if (!cameraButton) {
        return;
    }

    cameraButton.classList.toggle('is-off', !isCameraEnabled);
    setButtonLabel(
        cameraButton,
        isCameraEnabled ? 'Stop Camera' : 'Start Camera',
        isCameraEnabled ? 'ti-video' : 'ti-video-off'
    );
}

function updateScreenShareButtons() {
    if (!screenShareButton || !screenAudioShareButton) {
        return;
    }

    const canUseShareControls = !!room;

    if (!canUseShareControls) {
        setButtonLabel(screenShareButton, 'Share Screen', 'ti-screen-share');
        setButtonLabel(screenAudioShareButton, 'Share Screen + Audio', 'ti-device-audio-tape');
        screenShareButton.classList.remove('is-highlight');
        screenAudioShareButton.classList.remove('is-highlight');
        screenShareButton.disabled = true;
        screenAudioShareButton.disabled = true;
        return;
    }

    if (!isScreenShareEnabled) {
        setButtonLabel(screenShareButton, 'Share Screen', 'ti-screen-share');
        setButtonLabel(screenAudioShareButton, 'Share Screen + Audio', 'ti-device-audio-tape');
        screenShareButton.classList.remove('is-highlight');
        screenAudioShareButton.classList.remove('is-highlight');
        screenShareButton.disabled = false;
        screenAudioShareButton.disabled = false;
        return;
    }

    if (screenShareMode === 'screen_audio') {
        setButtonLabel(screenShareButton, 'Share Screen', 'ti-screen-share');
        setButtonLabel(screenAudioShareButton, 'Stop Screen + Audio', 'ti-device-audio-tape');
        screenShareButton.classList.remove('is-highlight');
        screenAudioShareButton.classList.add('is-highlight');
        screenShareButton.disabled = true;
        screenAudioShareButton.disabled = false;
        return;
    }

    setButtonLabel(screenShareButton, 'Stop Screen Share', 'ti-screen-share-off');
    setButtonLabel(screenAudioShareButton, 'Share Screen + Audio', 'ti-device-audio-tape');
    screenShareButton.classList.add('is-highlight');
    screenAudioShareButton.classList.remove('is-highlight');
    screenShareButton.disabled = false;
    screenAudioShareButton.disabled = true;
}

function setRoomMessage(message = '', type = 'warning') {
    if (!roomMessage) {
        return;
    }

    roomMessage.className = `meeting-alert is-${type}`;
    roomMessage.textContent = message;
    roomMessage.classList.toggle('d-none', !message);
}

function escapeHtml(value = '') {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function getInitials(name) {
    const text = String(name || '')
        .trim()
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part.charAt(0).toUpperCase())
        .join('');

    return text || 'LK';
}

function buildMediaPlaceholder(name, source = 'camera') {
    const label = source === 'screen' ? 'Waiting for screen share...' : 'Waiting for media...';
    const avatarUrl = arguments[2] || null;
    return `
        ${avatarUrl
            ? `<img src="${escapeHtml(avatarUrl)}" alt="${escapeHtml(name)}" class="participant-avatar-image" loading="lazy" referrerpolicy="no-referrer">`
            : `<div class="participant-avatar">
                <span>${getInitials(name)}</span>
            </div>`}
        <div class="participant-placeholder">${label}</div>
    `;
}

function resetGrid() {
    pinnedParticipantKey = null;
    grid.innerHTML = `
        <div class="participant-card" data-participant="placeholder">
            <div class="participant-media">
                <div class="participant-avatar">
                    <span>LK</span>
                </div>
                <div class="participant-placeholder">Connect to load your local stream and any remote participants.</div>
            </div>
            <div class="participant-footer">
                <span class="participant-name">Waiting for room</span>
                <span class="participant-chip">Lobby</span>
            </div>
        </div>
    `;
    refreshParticipantSummary();
    syncPinnedParticipantStage();
}

function normalizeSource(source) {
    const value = String(source || '').toLowerCase();

    if (value.includes('screen')) {
        return 'screen';
    }

    return 'camera';
}

function getTrackSource(track, publication = null) {
    return publication?.source || track?.source || 'camera';
}

function getTrackKey(track, publication = null, fallbackSource = 'camera') {
    return publication?.trackSid || publication?.track?.sid || track?.sid || `${fallbackSource}-${track.kind}`;
}

function getCardSelector(identity, source) {
    return `[data-participant-key="${CSS.escape(`${identity}::${source}`)}"]`;
}

function parseParticipantMetadata(participant = null) {
    if (!participant?.metadata) {
        return {};
    }

    try {
        const parsed = JSON.parse(participant.metadata);
        return parsed && typeof parsed === 'object' ? parsed : {};
    } catch (error) {
        return {};
    }
}

function resolveAvatarUrl(value) {
    const avatarUrl = String(value || '').trim();
    return avatarUrl !== '' ? avatarUrl : null;
}

function setPinnedParticipant(participantKey = null) {
    pinnedParticipantKey = participantKey || null;
    syncPinnedParticipantStage();
}

function togglePinnedParticipant(participantKey) {
    setPinnedParticipant(pinnedParticipantKey === participantKey ? null : participantKey);
}

function syncPinnedParticipantStage() {
    if (!grid) {
        return;
    }

    const pinnedCard = pinnedParticipantKey
        ? grid.querySelector(`[data-participant-key="${CSS.escape(pinnedParticipantKey)}"]`)
        : null;

    if (!pinnedCard) {
        pinnedParticipantKey = null;
    }

    const activePinnedCard = pinnedParticipantKey
        ? grid.querySelector(`[data-participant-key="${CSS.escape(pinnedParticipantKey)}"]`)
        : null;

    grid.classList.toggle('has-pinned', !!activePinnedCard);

    grid.querySelectorAll('.participant-card').forEach((card) => {
        const isPinned = !!activePinnedCard && card === activePinnedCard;
        const pinButton = card.querySelector('[data-pin-toggle]');
        const pinLabel = isPinned ? 'Unpin from stage' : 'Pin to stage';

        card.classList.toggle('is-pinned', isPinned);

        if (!pinButton) {
            return;
        }

        pinButton.classList.toggle('is-active', isPinned);
        pinButton.setAttribute('aria-pressed', isPinned ? 'true' : 'false');
        pinButton.setAttribute('aria-label', pinLabel);
        pinButton.setAttribute('title', pinLabel);
    });
}

function participantSourceLabel(isLocal, source) {
    const base = isLocal ? 'You' : 'Guest';
    return source === 'screen' ? `${base} / Screen` : base;
}

function getPublicationSource(publication, track = null) {
    return String(publication?.source || track?.source || '').toLowerCase();
}

function updateParticipantCardIndicators(identity) {
    const state = participantStates.get(identity);
    if (!state) {
        return;
    }

    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((card) => {
        const micBadge = card.querySelector('[data-state-icon="mic"]');
        const cameraBadge = card.querySelector('[data-state-icon="camera"]');

        if (micBadge) {
            micBadge.classList.toggle('is-off', !state.micOn);
            micBadge.innerHTML = `<i class="ti ${state.micOn ? 'ti-microphone' : 'ti-microphone-off'}"></i>`;
        }

        if (cameraBadge) {
            cameraBadge.classList.toggle('is-off', !state.cameraOn);
            cameraBadge.innerHTML = `<i class="ti ${state.cameraOn ? 'ti-video' : 'ti-video-off'}"></i>`;
        }
    });
}

function updateParticipantCardPlaceholder(identity) {
    const state = participantStates.get(identity);
    if (!state) {
        return;
    }

    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((card) => {
        const media = card.querySelector('.participant-media');
        if (!media || media.querySelector('video')) {
            return;
        }

        const avatarUrl = resolveAvatarUrl(state.avatarUrl);
        card.dataset.avatarUrl = avatarUrl || '';
        media.innerHTML = buildMediaPlaceholder(
            card.dataset.displayName || state.name || identity,
            card.dataset.source || 'camera',
            avatarUrl
        );
    });
}

function setParticipantState(identity, payload = {}) {
    const state = getParticipantState(identity, payload.name || identity, payload.isLocal || false);
    Object.assign(state, payload);
    renderParticipantsList();
    updateParticipantCardIndicators(identity);
    updateParticipantCardPlaceholder(identity);
}

function removeParticipantState(identity) {
    participantStates.delete(identity);
    renderParticipantsList();
}

function syncParticipantStatus(participant, isLocal = false) {
    if (!participant) {
        return;
    }

    const metadata = parseParticipantMetadata(participant);
    const avatarUrl = resolveAvatarUrl(metadata.avatarUrl || (isLocal ? participantAvatarUrl : null));

    let micOn = false;
    let cameraOn = false;
    let screenOn = false;

    participant.trackPublications?.forEach((publication) => {
        const source = getPublicationSource(publication, publication?.track);
        const isMuted = !!publication?.isMuted;

        if (source.includes('microphone')) {
            micOn = micOn || !isMuted;
        }

        if (source.includes('camera')) {
            cameraOn = cameraOn || !isMuted;
        }

        if (source.includes('screen')) {
            screenOn = screenOn || !isMuted;
        }
    });

    setParticipantState(participant.identity, {
        name: participant.name || participant.identity,
        isLocal,
        avatarUrl,
        micOn,
        cameraOn,
        screenOn,
    });
}

function ensureCard(identity, name, isLocal = false, source = 'camera') {
    grid.querySelector('[data-participant="placeholder"]')?.remove();

    const sourceKey = normalizeSource(source);
    const participantKey = `${identity}::${sourceKey}`;
    const displayName = name || identity;
    const state = participantStates.get(identity);
    const avatarUrl = resolveAvatarUrl(state?.avatarUrl || (isLocal ? participantAvatarUrl : null));
    let card = grid.querySelector(getCardSelector(identity, sourceKey));
    if (card) {
        card.dataset.avatarUrl = avatarUrl || '';
        return card;
    }

    card = document.createElement('div');
    card.className = 'participant-card';
    card.dataset.participant = identity;
    card.dataset.participantKey = participantKey;
    card.dataset.source = sourceKey;
    card.dataset.displayName = displayName;
    card.dataset.avatarUrl = avatarUrl || '';
    card.innerHTML = `
        <div class="participant-media">
            ${buildMediaPlaceholder(displayName, sourceKey, avatarUrl)}
        </div>
        <div class="participant-footer">
            <div class="participant-footer-meta">
                <span class="participant-name">${displayName}</span>
                <span class="participant-chip">${participantSourceLabel(isLocal, sourceKey)}</span>
            </div>
            <div class="participant-footer-icons">
                <button type="button" class="participant-pin-button" data-pin-toggle aria-label="Pin to stage" title="Pin to stage" aria-pressed="false">
                    <i class="ti ti-pin"></i>
                </button>
                <span class="participant-state-icon is-off" data-state-icon="mic"><i class="ti ti-microphone-off"></i></span>
                <span class="participant-state-icon is-off" data-state-icon="camera"><i class="ti ti-video-off"></i></span>
            </div>
        </div>
    `;
    grid.appendChild(card);
    updateParticipantCardIndicators(identity);
    refreshParticipantSummary();
    syncPinnedParticipantStage();

    return card;
}

function attachTrack(track, identity, name, isLocal = false, publication = null) {
    const source = getTrackSource(track, publication);
    const sourceKey = normalizeSource(source);
    const trackKey = getTrackKey(track, publication, sourceKey);
    const card = ensureCard(identity, name, isLocal, sourceKey);
    const media = card.querySelector('.participant-media');

    if (track.kind === Track.Kind.Video) {
        media.querySelectorAll('[data-track-kind="video"], .participant-avatar, .participant-avatar-image, .participant-placeholder').forEach((element) => element.remove());

        const element = track.attach();
        element.autoplay = true;
        element.playsInline = true;
        element.muted = isLocal;
        const wrapper = document.createElement('div');
        wrapper.className = sourceKey === 'screen' ? 'track-frame is-screen' : 'track-frame';
        wrapper.dataset.trackKey = trackKey;
        wrapper.dataset.trackKind = 'video';
        wrapper.appendChild(element);
        media.appendChild(wrapper);
        return;
    }

    if (track.kind === Track.Kind.Audio) {
        if (media.querySelector(`[data-track-key="${CSS.escape(trackKey)}"]`)) {
            return;
        }

        const element = track.attach();
        element.autoplay = true;
        element.muted = isLocal;
        element.classList.add('track-audio-element');
        const wrapper = document.createElement('div');
        wrapper.className = 'track-frame';
        wrapper.dataset.trackKey = trackKey;
        wrapper.dataset.trackKind = 'audio';
        wrapper.appendChild(element);
        media.appendChild(wrapper);
    }
}

function detachTrack(track, identity, publication = null) {
    const source = getTrackSource(track, publication);
    const sourceKey = normalizeSource(source);
    const trackKey = getTrackKey(track, publication, sourceKey);
    const card = grid.querySelector(getCardSelector(identity, sourceKey));

    track.detach().forEach((element) => element.remove());
    card?.querySelectorAll(`[data-track-key="${CSS.escape(trackKey)}"]`).forEach((element) => element.remove());

    if (!card) {
        refreshParticipantSummary();
        return;
    }

    const media = card.querySelector('.participant-media');
    const hasVideo = !!media.querySelector('video');
    const hasAudio = !!media.querySelector('audio');

    if (!hasVideo && !hasAudio) {
        if (sourceKey === 'screen') {
            card.remove();
        } else {
            media.innerHTML = buildMediaPlaceholder(
                card.dataset.displayName || identity,
                sourceKey,
                resolveAvatarUrl(card.dataset.avatarUrl)
            );
        }
    }

    if (!grid.children.length) {
        resetGrid();
    } else {
        refreshParticipantSummary();
        syncPinnedParticipantStage();
    }
}

function detachParticipant(identity) {
    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((element) => element.remove());

    if (!grid.children.length) {
        resetGrid();
    } else {
        refreshParticipantSummary();
        syncPinnedParticipantStage();
    }

    removeParticipantState(identity);
}

async function sendChatMessage(body) {
    if (!room || !body.trim()) {
        return;
    }

    const target = getSelectedChatTarget();
    const payload = {
        type: 'chat',
        id: createMessageId(),
        body: body.trim(),
        sender: participantName,
        senderIdentity: room.localParticipant.identity,
        sentAt: new Date().toISOString(),
        targetIdentity: target?.identity || null,
        targetName: target?.name || null,
    };

    appendChatMessage({
        author: participantName,
        body: payload.body,
        sentAt: payload.sentAt,
        role: target ? `Private to ${target.name}` : 'You',
        isLocal: true,
        isPrivate: !!target,
    });

    await room.localParticipant.publishData(textEncoder.encode(JSON.stringify(payload)), {
        reliable: true,
        destinationIdentities: target ? [target.identity] : undefined,
    });
}

function handleIncomingData(payload, participant) {
    let parsed = null;

    try {
        parsed = JSON.parse(textDecoder.decode(payload));
    } catch (error) {
        return;
    }

    if (parsed?.type !== 'chat' || !parsed.body) {
        return;
    }

    const localIdentity = room?.localParticipant?.identity || null;
    const senderIdentity = participant?.identity || parsed.senderIdentity || null;
    const isPrivate = !!parsed.targetIdentity;

    if (senderIdentity && localIdentity && senderIdentity === localIdentity) {
        return;
    }

    if (isPrivate && parsed.targetIdentity && localIdentity && parsed.targetIdentity !== localIdentity) {
        return;
    }

    appendChatMessage({
        id: parsed.id,
        author: participant?.name || parsed.sender || participant?.identity || 'Guest',
        body: parsed.body,
        sentAt: parsed.sentAt,
        role: isPrivate ? 'Private to you' : (participant ? 'Guest' : ''),
        isPrivate,
    });
}

async function markPresence(action) {
    if (action === 'join') {
        hasJoinedPresence = true;
    }

    const response = await fetch(presenceUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ action }),
    }).catch(() => null);

    if (!response) {
        return null;
    }

    const data = await response.json().catch(() => null);
    if (data?.stats) {
        if (joinedMinutes) {
            joinedMinutes.textContent = `${data.stats.joined_minutes ?? 0} min`;
        }
        if (attendancePercent) {
            attendancePercent.textContent = data.stats.attendance_percent !== null && data.stats.attendance_percent !== undefined
                ? `${data.stats.attendance_percent}%`
                : 'Pending';
        }
    }

    return data;
}

function sendLeaveBeacon() {
    if (!hasJoinedPresence) {
        return;
    }

    const payload = new URLSearchParams({ action: 'leave' });
    navigator.sendBeacon(presenceUrl, payload);
    hasJoinedPresence = false;
    if (joinedMinutes) {
        joinedMinutes.textContent = '0 min';
    }
    if (attendancePercent) {
        attendancePercent.textContent = 'Pending';
    }
}

async function startScreenShare(withAudio = false) {
    if (!room || isScreenShareEnabled) {
        return;
    }

    if (!navigator.mediaDevices?.getDisplayMedia) {
        setRoomMessage('This browser does not support screen sharing.', 'warning');
        return;
    }

    try {
        setRoomMessage(
            withAudio
                ? 'Choose a browser tab and enable audio sharing in the browser prompt if available.'
                : 'Choose the screen, window, or tab you want to share.',
            'info'
        );

        const tracks = await room.localParticipant.createScreenTracks(withAudio ? { audio: true } : {});

        if (!tracks?.length) {
            throw new Error(withAudio ? 'No screen or browser-audio tracks were created.' : 'No screen tracks were created.');
        }

        const publishedScreenTracks = [];

        for (const track of tracks) {
            const publication = await room.localParticipant.publishTrack(track);
            attachTrack(track, room.localParticipant.identity, participantName, true, publication);

            track.mediaStreamTrack?.addEventListener('ended', () => {
                stopScreenShare(true).catch(() => null);
            }, { once: true });

            publishedScreenTracks.push({ track, publication });
        }

        localScreenTracks = publishedScreenTracks;
        isScreenShareEnabled = true;
        screenShareMode = withAudio ? 'screen_audio' : 'screen';
        updateScreenShareButtons();
        setRoomMessage(
            withAudio
                ? 'Screen sharing with browser audio is active.'
                : 'Screen sharing is active.',
            'success'
        );
    } catch (error) {
        for (const item of localScreenTracks) {
            try {
                room?.localParticipant.unpublishTrack(item.track, true);
            } catch (cleanupError) {
                // Ignore partial publish cleanup failures.
            }

            try {
                item.track.stop();
            } catch (cleanupError) {
                // Ignore stop failures during cleanup.
            }
        }

        localScreenTracks = [];
        isScreenShareEnabled = false;
        screenShareMode = 'none';
        updateScreenShareButtons();
        setRoomMessage(
            error?.message || (withAudio ? 'Unable to start screen and audio sharing.' : 'Unable to start screen sharing.'),
            'danger'
        );
    }
}

async function stopScreenShare(fromTrackEnded = false) {
    if (!room || !localScreenTracks.length) {
        isScreenShareEnabled = false;
        screenShareMode = 'none';
        updateScreenShareButtons();
        return;
    }

    const tracksToStop = [...localScreenTracks];
    localScreenTracks = [];

    for (const item of tracksToStop) {
        try {
            room.localParticipant.unpublishTrack(item.track, true);
        } catch (error) {
            // Ignore cleanup failures and continue stopping remaining tracks.
        }

        try {
            item.track.stop();
        } catch (error) {
            // Ignore stop failures.
        }

        detachTrack(item.track, room.localParticipant.identity, item.publication);
    }

    isScreenShareEnabled = false;
    screenShareMode = 'none';
    updateScreenShareButtons();

    if (!fromTrackEnded) {
        setRoomMessage('Screen sharing stopped.', 'info');
    }
}

async function joinRoom() {
    if (room || !serverUrl || !token) {
        return;
    }

    joinButton.disabled = true;
    setButtonLabel(joinButton, 'Connecting...', 'ti-loader-2');
    setStatus('Connecting...');
    setRoomMessage('');

    try {
        room = new Room();

        room.on(RoomEvent.Connected, async () => {
            setStatus('Connected', true);
            leaveButton.disabled = false;
            micButton.disabled = false;
            cameraButton.disabled = false;
            updateScreenShareButtons();
            updateMicButton();
            updateCameraButton();
            setButtonLabel(joinButton, 'Reconnect', 'ti-rotate-2');
            updateChatComposerState();
            resetChat();
            appendChatMessage({
                author: 'System',
                body: 'Ephemeral chat is live for this meeting.',
                sentAt: new Date().toISOString(),
                isSystem: true,
            });
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
            isScreenShareEnabled = false;
            screenShareMode = 'none';
            localScreenTracks = [];
            updateMicButton();
            updateCameraButton();
            setButtonLabel(joinButton, 'Reconnect', 'ti-rotate-2');
            updateScreenShareButtons();
            participantStates.clear();
            resetGrid();
            resetChat();
            updateChatComposerState();
            renderParticipantsList();
        });

        room.on(RoomEvent.LocalTrackPublished, (publication) => {
            if (publication.track) {
                attachTrack(publication.track, room.localParticipant.identity, participantName, true, publication);
            }
            syncParticipantStatus(room.localParticipant, true);
        });

        room.on(RoomEvent.LocalTrackUnpublished, (publication) => {
            if (publication.track) {
                detachTrack(publication.track, room.localParticipant.identity, publication);
            }
            syncParticipantStatus(room.localParticipant, true);
        });

        room.on(RoomEvent.TrackSubscribed, (track, publication, participant) => {
            attachTrack(track, participant.identity, participant.name || participant.identity, false, publication);
            syncParticipantStatus(participant, false);
        });

        room.on(RoomEvent.TrackPublished, (publication, participant) => {
            syncParticipantStatus(participant, false);
        });

        room.on(RoomEvent.TrackUnpublished, (publication, participant) => {
            syncParticipantStatus(participant, false);
        });

        room.on(RoomEvent.TrackUnsubscribed, (track, publication, participant) => {
            detachTrack(track, participant.identity, publication);
            syncParticipantStatus(participant, false);
        });

        room.on(RoomEvent.ParticipantConnected, (participant) => {
            ensureCard(participant.identity, participant.name || participant.identity, false, 'camera');
            syncParticipantStatus(participant, false);
            appendChatMessage({
                author: 'System',
                body: `${participant.name || participant.identity} joined the room.`,
                sentAt: new Date().toISOString(),
                isSystem: true,
            });
        });

        room.on(RoomEvent.ParticipantDisconnected, (participant) => {
            detachParticipant(participant.identity);
            appendChatMessage({
                author: 'System',
                body: `${participant.name || participant.identity} left the room.`,
                sentAt: new Date().toISOString(),
                isSystem: true,
            });
        });

        room.on(RoomEvent.ConnectionStateChanged, (state) => {
            if (state === 'reconnecting') {
                setStatus('Reconnecting...');
            }
        });

        room.on(RoomEvent.TrackMuted, (publication, participant) => {
            syncParticipantStatus(participant, participant?.identity === room?.localParticipant?.identity);
        });

        room.on(RoomEvent.TrackUnmuted, (publication, participant) => {
            syncParticipantStatus(participant, participant?.identity === room?.localParticipant?.identity);
        });

        room.on(RoomEvent.DataReceived, (payload, participant) => {
            handleIncomingData(payload, participant);
        });

        await room.connect(serverUrl, token);
        ensureCard(room.localParticipant.identity, participantName, true, 'camera');
        syncParticipantStatus(room.localParticipant, true);

        try {
            await room.localParticipant.setMicrophoneEnabled(true);
            isMicEnabled = true;
            micButton.disabled = false;
            updateMicButton();
            syncParticipantStatus(room.localParticipant, true);
        } catch (error) {
            isMicEnabled = false;
            setButtonLabel(micButton, 'Mic unavailable', 'ti-microphone-off');
            micButton.disabled = true;
            micButton.classList.add('is-off');
            setRoomMessage('Connected, but microphone access was blocked or unavailable.', 'warning');
        }

        try {
            await room.localParticipant.setCameraEnabled(true);
            isCameraEnabled = true;
            cameraButton.disabled = false;
            updateCameraButton();
            syncParticipantStatus(room.localParticipant, true);
        } catch (error) {
            isCameraEnabled = false;
            setButtonLabel(cameraButton, 'Camera unavailable', 'ti-video-off');
            cameraButton.disabled = true;
            cameraButton.classList.add('is-off');
            setRoomMessage(
                roomMessage?.textContent
                    ? `${roomMessage.textContent} Camera access was also blocked or unavailable.`
                    : 'Connected, but camera access was blocked or unavailable.',
                'warning'
            );
        }

        room.remoteParticipants.forEach((participant) => {
            ensureCard(participant.identity, participant.name || participant.identity, false, 'camera');
            participant.trackPublications.forEach((publication) => {
                if (publication.track) {
                    attachTrack(publication.track, participant.identity, participant.name || participant.identity, false, publication);
                }
            });
            syncParticipantStatus(participant, false);
        });

        joinButton.disabled = false;
    } catch (error) {
        console.error(error);
        setStatus('Connection failed');
        setRoomMessage(error?.message || 'Unable to connect to the LiveKit room.', 'danger');
        setButtonLabel(joinButton, 'Reconnect', 'ti-rotate-2');
        joinButton.disabled = false;
        leaveButton.disabled = true;
        micButton.disabled = true;
        cameraButton.disabled = true;
        updateScreenShareButtons();
        room = null;
        participantStates.clear();
        renderParticipantsList();
        resetChat();
        updateChatComposerState();
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
chatTabButton?.addEventListener('click', () => setSidebarTab('chat'));
participantsTabButton?.addEventListener('click', () => setSidebarTab('participants'));

grid?.addEventListener('click', (event) => {
    const pinButton = event.target.closest('[data-pin-toggle]');
    if (!pinButton) {
        return;
    }

    const card = pinButton.closest('.participant-card');
    const participantKey = card?.dataset?.participantKey;
    if (!participantKey) {
        return;
    }

    togglePinnedParticipant(participantKey);
});

grid?.addEventListener('dblclick', (event) => {
    if (event.target.closest('[data-pin-toggle]')) {
        return;
    }

    const card = event.target.closest('.participant-card');
    const participantKey = card?.dataset?.participantKey;
    if (!participantKey) {
        return;
    }

    togglePinnedParticipant(participantKey);
});

chatForm?.addEventListener('submit', async (event) => {
    event.preventDefault();

    if (!chatInput) {
        return;
    }

    const body = chatInput.value.trim();
    if (!body || !room) {
        return;
    }

    try {
        await sendChatMessage(body);
        chatInput.value = '';
    } catch (error) {
        setRoomMessage(error?.message || 'Unable to send chat message.', 'warning');
    }
});

chatTargetSelect?.addEventListener('change', () => {
    updateChatTargetChip();
});

sidebarToggleButton?.addEventListener('click', () => {
    setSidebarCollapsed(!isSidebarCollapsed);
});

fullscreenButton?.addEventListener('click', async () => {
    if (!stage) {
        return;
    }

    try {
        if (document.fullscreenElement) {
            await document.exitFullscreen();
        } else {
            const pinnedCard = pinnedParticipantKey
                ? grid?.querySelector(`[data-participant-key="${CSS.escape(pinnedParticipantKey)}"]`)
                : null;
            const fullscreenTarget = pinnedCard || stage;
            await fullscreenTarget.requestFullscreen();
        }
    } catch (error) {
        setRoomMessage('Fullscreen mode is not available in this browser.', 'warning');
    }
});

micButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    const nextState = !isMicEnabled;

    try {
        await room.localParticipant.setMicrophoneEnabled(nextState);
        isMicEnabled = nextState;
        updateMicButton();
        syncParticipantStatus(room.localParticipant, true);
    } catch (error) {
        setRoomMessage(error?.message || 'Unable to update microphone state.', 'warning');
    }
});

cameraButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    const nextState = !isCameraEnabled;

    try {
        await room.localParticipant.setCameraEnabled(nextState);
        isCameraEnabled = nextState;
        updateCameraButton();
        syncParticipantStatus(room.localParticipant, true);
    } catch (error) {
        setRoomMessage(error?.message || 'Unable to update camera state.', 'warning');
    }
});

screenShareButton?.addEventListener('click', async () => {
    if (isScreenShareEnabled && screenShareMode === 'screen') {
        await stopScreenShare();
        return;
    }

    if (!isScreenShareEnabled) {
        await startScreenShare(false);
    }
});

screenAudioShareButton?.addEventListener('click', async () => {
    if (isScreenShareEnabled && screenShareMode === 'screen_audio') {
        await stopScreenShare();
        return;
    }

    if (!isScreenShareEnabled) {
        await startScreenShare(true);
    }
});

window.addEventListener('beforeunload', () => {
    sendLeaveBeacon();
});

document.addEventListener('fullscreenchange', syncFullscreenButton);

resetGrid();
resetChat();
renderParticipantsList();
updateMicButton();
updateCameraButton();
updateChatComposerState();
renderChatTargetOptions();
setSidebarCollapsed(false);
setSidebarTab('chat');
attemptAutoJoin();
syncFullscreenButton();
updateScreenShareButtons();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Resources\views\integrations\livekit_join.blade.php ENDPATH**/ ?>
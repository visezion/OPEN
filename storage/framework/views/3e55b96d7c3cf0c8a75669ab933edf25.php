<?php $__env->startSection('page-title', __('Meeting Room')); ?>

<?php $__env->startSection('page-breadcrumb'); ?>
    <?php echo e(__('ChurchMeet')); ?>,<?php echo e(__('Meeting Room')); ?>

<?php $__env->stopSection(); ?>

<?php
    $meetingTitle = $attendanceEvent->event->title ?? __('Meeting Room');
    $meetingMode = strtoupper($attendanceEvent->mode ?: 'online');
    $meetingShareUrl = route('churchmeet.meetings.join', $attendanceEvent->public_join_key);
    $meetingLoginUrl = route('login', ['lang' => app()->getLocale(), 'redirect_to' => url()->current()]);
    $guestDisplayName = trim((string) (request('guest_name', session('churchmeet_guest_display_name', $participantName ?? ''))));
    $requiresGuestName = (bool) ($requiresGuestName ?? (!Auth::check() && $guestDisplayName === ''));
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
    <?php
        $livekitRoomCssPath = base_path('packages/workdo/ChurchMeet/src/Resources/assets/css/livekit-room.css');
    ?>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_file($livekitRoomCssPath)): ?>
        <style>
            <?php echo file_get_contents($livekitRoomCssPath); ?>

        </style>
    <?php else: ?>
        <link rel="stylesheet" href="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/css/livekit-room.css')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('churchmeet.events.show', optional($attendanceEvent->event)->public_view_key ?? $attendanceEvent->event_id)); ?>" class="meeting-pill text-decoration-none">
                        <i class="ti ti-external-link"></i>
                        <span><?php echo e(__('Open Event')); ?></span>
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <button type="button" class="meeting-pill meeting-copy-trigger" data-copy-text="<?php echo e($meetingShareUrl); ?>" data-copy-default="<?php echo e(__('Copy Invite')); ?>" data-copy-success="<?php echo e(__('Copied')); ?>">
                    <i class="ti ti-link"></i>
                    <span><?php echo e(__('Copy Invite')); ?></span>
                </button>

                <div class="meeting-avatar"><?php echo e($participantBadge ?: 'WD'); ?></div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($requiresGuestName): ?>
            <section class="meeting-gate-panel">
                <div class="meeting-gate-card">
                    <span class="meeting-gate-kicker">
                        <i class="ti ti-user-plus"></i> <?php echo e(__('Public Meeting Access')); ?>

                    </span>
                    <h3><?php echo e(__('Enter your display name')); ?></h3>
                    <p><?php echo e(__('Sign in with your WorkDo account or continue as a guest. Guest access only needs the name other participants should see.')); ?></p>

                    <form action="<?php echo e(url()->current()); ?>" method="GET" class="meeting-gate-form">
                        <div>
                            <label for="guest_name" class="meeting-gate-label"><?php echo e(__('Display Name')); ?></label>
                            <input
                                type="text"
                                id="guest_name"
                                name="guest_name"
                                class="meeting-gate-input"
                                maxlength="60"
                                required
                                autocomplete="name"
                                placeholder="<?php echo e(__('Enter your name')); ?>"
                                value="<?php echo e($guestDisplayName); ?>"
                            >
                        </div>
                        <div class="meeting-gate-actions">
                            <a href="<?php echo e($meetingLoginUrl); ?>" class="meeting-gate-button is-secondary">
                                <i class="ti ti-login"></i>
                                <span><?php echo e(__('Login')); ?></span>
                            </a>
                            <button type="submit" class="meeting-gate-button">
                                <i class="ti ti-door-enter"></i>
                                <span><?php echo e(__('Join as Guest')); ?></span>
                            </button>
                            <span class="meeting-gate-note"><?php echo e(__('Your name will be reused for this browser session until you change it.')); ?></span>
                        </div>
                    </form>
                </div>
            </section>
        <?php else: ?>
        <div class="meeting-layout">
            <section class="stage-panel">
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
                                        <span>WD</span>
                                    </div>
                                    <div class="participant-placeholder"><?php echo e(__('Connect to load your local stream and any remote participants.')); ?></div>
                                </div>
                                <div class="participant-footer">
                                    <span class="participant-name"><?php echo e(__('Waiting for room')); ?></span>
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

                        <div class="control-layout">
                            <div class="control-dock control-dock-left">
                            <button type="button" class="meeting-control is-primary is-stack" id="join-room">
                                <i class="control-icon ti ti-rotate-2"></i>
                                <span class="control-label"><?php echo e(__('Reconnect')); ?></span>
                            </button>
                            </div>

                            <div class="control-dock control-dock-center">
                            <button type="button" class="meeting-control is-stack" id="toggle-mic" data-static-label="<?php echo e(__('Audio')); ?>" aria-label="<?php echo e(__('Mute Mic')); ?>" title="<?php echo e(__('Mute Mic')); ?>" disabled>
                                <i class="control-icon ti ti-microphone"></i>
                                <span class="control-label"><?php echo e(__('Audio')); ?></span>
                            </button>

                            <button type="button" class="meeting-control is-stack" id="toggle-camera" data-static-label="<?php echo e(__('Video')); ?>" aria-label="<?php echo e(__('Stop Camera')); ?>" title="<?php echo e(__('Stop Camera')); ?>" disabled>
                                <i class="control-icon ti ti-video"></i>
                                <span class="control-label"><?php echo e(__('Video')); ?></span>
                            </button>

                            <button type="button" class="meeting-control is-stack" id="toggle-sidebar" aria-label="<?php echo e(__('Hide Participants')); ?>" title="<?php echo e(__('Hide Participants')); ?>">
                                <i class="control-icon ti ti-users"></i>
                                <span class="control-label"><?php echo e(__('Participants')); ?></span>
                            </button>

                            <button type="button" class="meeting-control is-stack" id="toggle-reactions" data-static-label="<?php echo e(__('React')); ?>" aria-label="<?php echo e(__('Open Reactions')); ?>" title="<?php echo e(__('Open Reactions')); ?>" disabled>
                                <i class="control-icon ti ti-mood-smile"></i>
                                <span class="control-label"><?php echo e(__('React')); ?></span>
                            </button>

                            <button type="button" class="meeting-control is-stack" id="toggle-fullscreen" aria-label="<?php echo e(__('Full Screen')); ?>" title="<?php echo e(__('Full Screen')); ?>">
                                <i class="control-icon ti ti-maximize"></i>
                                <span class="control-label"><?php echo e(__('Full Screen')); ?></span>
                            </button>

                            <button type="button" class="meeting-control is-stack" id="toggle-screen-audio-share" data-static-label="<?php echo e(__('Share')); ?>" aria-label="<?php echo e(__('Share Screen + Audio')); ?>" title="<?php echo e(__('Share Screen + Audio')); ?>" disabled>
                                <i class="control-icon ti ti-screen-share"></i>
                                <span class="control-label"><?php echo e(__('Share')); ?></span>
                            </button>
                            </div>

                            <div class="control-dock control-dock-right">
                            <button type="button" class="meeting-control is-danger is-stack" id="leave-room" data-static-label="<?php echo e(__('Exit')); ?>" aria-label="<?php echo e(__('Exit')); ?>" title="<?php echo e(__('Exit')); ?>" disabled>
                                <i class="control-icon ti ti-logout"></i>
                                <span class="control-label"><?php echo e(__('Exit')); ?></span>
                            </button>
                            </div>
                        </div>

                        <div class="reaction-picker" id="reaction-picker" hidden>
                            <button type="button" class="reaction-picker-button" data-reaction="👍" aria-label="<?php echo e(__('Thumbs up')); ?>">👍</button>
                            <button type="button" class="reaction-picker-button" data-reaction="👏" aria-label="<?php echo e(__('Clap')); ?>">👏</button>
                            <button type="button" class="reaction-picker-button" data-reaction="❤️" aria-label="<?php echo e(__('Love')); ?>">❤️</button>
                            <button type="button" class="reaction-picker-button" data-reaction="😂" aria-label="<?php echo e(__('Laugh')); ?>">😂</button>
                            <button type="button" class="reaction-picker-button" data-reaction="🎉" aria-label="<?php echo e(__('Celebrate')); ?>">🎉</button>
                            <button type="button" class="reaction-picker-button" data-reaction="🙏" aria-label="<?php echo e(__('Pray')); ?>">🙏</button>
                        </div>
                    </div>
                </div>
            </section>

            <button type="button" class="sidebar-popup-backdrop" id="sidebar-popup-backdrop" aria-label="<?php echo e(__('Close sidebar popup')); ?>"></button>

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

            </aside>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($requiresGuestName)): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.meeting-copy-trigger').forEach(function (button) {
        button.addEventListener('click', async function () {
            const copyText = button.dataset.copyText || '';
            const defaultLabel = button.dataset.copyDefault || 'Copy Invite';
            const successLabel = button.dataset.copySuccess || 'Copied';
            const label = button.querySelector('span');

            if (!copyText) {
                return;
            }

            try {
                await navigator.clipboard.writeText(copyText);
                if (label) {
                    label.textContent = successLabel;
                }
                setTimeout(function () {
                    if (label) {
                        label.textContent = defaultLabel;
                    }
                }, 1600);
            } catch (error) {
                window.prompt('Copy this link', copyText);
            }
        });
    });
});
</script>
<?php
    $churchmeetViewHelpersPath = base_path('packages/workdo/ChurchMeet/src/Resources/assets/js/churchmeet-view-helpers.js');
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_file($churchmeetViewHelpersPath)): ?>
    <script>
        <?php echo file_get_contents($churchmeetViewHelpersPath); ?>

    </script>
<?php else: ?>
    <script src="<?php echo e(asset('packages/workdo/ChurchMeet/src/Resources/assets/js/churchmeet-view-helpers.js')); ?>"></script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<script type="module">
import { MediaDeviceFailure, Room, RoomEvent, Track } from 'https://cdn.jsdelivr.net/npm/livekit-client@2.18.2/dist/livekit-client.esm.mjs';

const serverUrl = <?php echo json_encode($livekitServerUrl, 15, 512) ?>;
const token = <?php echo json_encode($livekitToken, 15, 512) ?>;
const participantName = <?php echo json_encode($participantName, 15, 512) ?>;
const participantAvatarUrl = <?php echo json_encode($participantAvatarUrl ?? null, 15, 512) ?>;
const presenceUrl = <?php echo json_encode(route('churchmeet.meetings.presence', $attendanceEvent->public_join_key), 512) ?>;

const livekitRoomRoot = document.querySelector('.livekit-room');
const grid = document.getElementById('participant-grid');
const meetingLayout = document.querySelector('.meeting-layout');
const sidebarPanel = document.querySelector('.sidebar-panel');
const sidebarPopupBackdrop = document.getElementById('sidebar-popup-backdrop');
const joinButton = document.getElementById('join-room');
const leaveButton = document.getElementById('leave-room');
const sidebarToggleButton = document.getElementById('toggle-sidebar');
const fullscreenButton = document.getElementById('toggle-fullscreen');
const micButton = document.getElementById('toggle-mic');
const cameraButton = document.getElementById('toggle-camera');
const reactionsButton = document.getElementById('toggle-reactions');
const reactionPicker = document.getElementById('reaction-picker');
const screenAudioShareButton = document.getElementById('toggle-screen-audio-share');
const connectionStatus = document.getElementById('connection-status');
const connectionDot = document.getElementById('connection-dot');
const stageConnectionStatus = document.getElementById('stage-connection-status');
const stageConnectionDot = document.getElementById('stage-connection-dot');
const roomMessage = document.getElementById('room-message');
const stage = document.querySelector('.livekit-room .stage');
const joinedMinutes = document.getElementById('joined-minutes');
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
let isSidebarCollapsed = false;
let isFullscreenSidebarOpen = false;
let pinnedParticipantKey = null;
let localScreenTracks = [];
let chatMessages = [];
let isReactionPickerOpen = false;
let fullscreenUiHideTimer = null;
const participantStates = new Map();
const everyoneLabel = 'Everyone';
const messageEveryonePlaceholder = 'Message everyone';
const messagePrivatePlaceholder = 'Send a private message';
const maxScreenShareVisibleSideTiles = 5;

function isCompactViewport() {
    return window.matchMedia('(max-width: 991.98px)').matches;
}

function isChatComposerFocused() {
    const activeElement = document.activeElement;
    return activeElement === chatInput || activeElement === chatTargetSelect;
}

function scrollChatComposerIntoView() {
    if (!isCompactViewport() || !isChatComposerFocused()) {
        return;
    }

    requestAnimationFrame(() => {
        chatForm?.scrollIntoView({ block: 'nearest', inline: 'nearest' });
        chatInput?.scrollIntoView({ block: 'center', inline: 'nearest' });
    });
}

function syncChatKeyboardInset() {
    if (!livekitRoomRoot) {
        return;
    }

    if (!isCompactViewport()) {
        livekitRoomRoot.style.setProperty('--chat-keyboard-offset', '0px');
        return;
    }

    const viewport = window.visualViewport;
    const keyboardOffset = viewport
        ? Math.max(0, Math.round(window.innerHeight - viewport.height - viewport.offsetTop))
        : 0;
    const shouldLiftComposer = isChatComposerFocused() && keyboardOffset > 0;

    livekitRoomRoot.style.setProperty('--chat-keyboard-offset', shouldLiftComposer ? `${keyboardOffset}px` : '0px');

    if (shouldLiftComposer) {
        scrollChatComposerIntoView();
    }
}

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

    button.setAttribute('aria-label', label);
    button.setAttribute('title', label);

    const visibleLabel = button.dataset.staticLabel || label;

    const labelNode = button.querySelector('.control-label');
    if (labelNode) {
        labelNode.textContent = visibleLabel;
    } else {
        button.textContent = visibleLabel;
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
    syncSidebarToggleButton();
}

function isMeetingLayoutFullscreen() {
    return document.fullscreenElement === meetingLayout;
}

function clearFullscreenUiHideTimer() {
    if (!fullscreenUiHideTimer) {
        return;
    }

    clearTimeout(fullscreenUiHideTimer);
    fullscreenUiHideTimer = null;
}

function setFullscreenUiVisible(visible) {
    meetingLayout?.classList.toggle('is-fullscreen-ui-visible', visible);
}

function showFullscreenUiTemporarily() {
    if (!isMeetingLayoutFullscreen()) {
        clearFullscreenUiHideTimer();
        setFullscreenUiVisible(true);
        return;
    }

    setFullscreenUiVisible(true);
    clearFullscreenUiHideTimer();
    fullscreenUiHideTimer = setTimeout(() => {
        if (!isMeetingLayoutFullscreen()) {
            return;
        }

        setFullscreenUiVisible(false);
    }, 2000);
}

function syncFullscreenSidebarPopup() {
    const popupOpen = isMeetingLayoutFullscreen() && isFullscreenSidebarOpen;
    meetingLayout?.classList.toggle('is-fullscreen-sidebar-open', popupOpen);
    sidebarPanel?.setAttribute('aria-hidden', isMeetingLayoutFullscreen() ? (popupOpen ? 'false' : 'true') : 'false');
}

function syncSidebarToggleButton() {
    if (!sidebarToggleButton) {
        return;
    }

    const label = isMeetingLayoutFullscreen()
        ? (isFullscreenSidebarOpen ? 'Hide Participants' : 'Show Participants')
        : (isSidebarCollapsed ? 'Show Participants' : 'Hide Participants');

    sidebarToggleButton.setAttribute('aria-label', label);
    sidebarToggleButton.setAttribute('title', label);
}

function setFullscreenSidebarOpen(open, preferredTab = 'participants') {
    isFullscreenSidebarOpen = !!open;

    if (isFullscreenSidebarOpen) {
        setSidebarTab(preferredTab);
    }

    syncFullscreenSidebarPopup();
    syncSidebarToggleButton();
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

function setReactionPickerOpen(open) {
    isReactionPickerOpen = !!open && !!room;

    if (reactionPicker) {
        reactionPicker.hidden = !isReactionPickerOpen;
        reactionPicker.classList.toggle('is-open', isReactionPickerOpen);
    }

    if (reactionsButton) {
        reactionsButton.classList.toggle('is-highlight', isReactionPickerOpen);
        reactionsButton.disabled = !room;
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
            hasMicTrack: false,
            hasCameraTrack: false,
            screenOn: false,
            activeReaction: '',
            reactionTimeoutId: null,
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

function getMediaActionLabel(kind) {
    return kind === 'microphone' ? 'Audio' : 'Video';
}

function getMediaPermissionMessage(kind, error) {
    const actionLabel = getMediaActionLabel(kind);
    const deviceLabel = kind === 'microphone' ? 'microphone' : 'camera';
    const failure = typeof MediaDeviceFailure?.getFailure === 'function'
        ? MediaDeviceFailure.getFailure(error)
        : null;
    const errorName = String(error?.name || '').trim();

    if (!navigator.mediaDevices?.getUserMedia) {
        return `${actionLabel} access requires a supported browser on HTTPS or localhost.`;
    }

    if (failure === 'PermissionDenied' || errorName === 'NotAllowedError' || errorName === 'PermissionDeniedError') {
        return `Browser access to your ${deviceLabel} is blocked. Allow it in your browser/site permissions, then tap ${actionLabel} again.`;
    }

    if (failure === 'NotFound' || errorName === 'NotFoundError' || errorName === 'DevicesNotFoundError') {
        return `No ${deviceLabel} was found on this device. Connect one, then tap ${actionLabel} again.`;
    }

    if (failure === 'DeviceInUse' || errorName === 'NotReadableError' || errorName === 'TrackStartError') {
        return `Your ${deviceLabel} is busy in another app or the browser could not start it. Close other apps and tap ${actionLabel} again.`;
    }

    if (errorName === 'SecurityError' || errorName === 'TypeError') {
        return `${actionLabel} access is blocked on this page. Open the meeting from HTTPS or localhost and check browser permissions.`;
    }

    if (errorName === 'AbortError') {
        return `The ${deviceLabel} request was interrupted. Tap ${actionLabel} again.`;
    }

    return error?.message || `Unable to access your ${deviceLabel}. Check permissions and device availability, then tap ${actionLabel} again.`;
}

async function setLocalMediaEnabled(kind, nextState) {
    if (!room?.localParticipant) {
        return false;
    }

    const button = kind === 'microphone' ? micButton : cameraButton;

    try {
        if (kind === 'microphone') {
            await room.localParticipant.setMicrophoneEnabled(nextState);
            isMicEnabled = nextState;
            button?.classList.toggle('is-off', !isMicEnabled);
            updateMicButton();
        } else {
            await room.localParticipant.setCameraEnabled(nextState);
            isCameraEnabled = nextState;
            button?.classList.toggle('is-off', !isCameraEnabled);
            updateCameraButton();
        }

        if (button) {
            button.disabled = false;
        }

        syncParticipantStatus(room.localParticipant, true);
        return true;
    } catch (error) {
        if (kind === 'microphone') {
            isMicEnabled = false;
            updateMicButton();
        } else {
            isCameraEnabled = false;
            updateCameraButton();
        }

        if (button) {
            button.disabled = false;
            button.classList.add('is-off');
        }

        setRoomMessage(getMediaPermissionMessage(kind, error), 'warning');
        return false;
    }
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
    if (!screenAudioShareButton) {
        return;
    }

    const canUseShareControls = !!room;

    if (!canUseShareControls) {
        setButtonLabel(screenAudioShareButton, 'Share Screen + Audio', 'ti-screen-share');
        screenAudioShareButton.classList.remove('is-highlight');
        screenAudioShareButton.disabled = true;
        return;
    }

    if (!isScreenShareEnabled) {
        setButtonLabel(screenAudioShareButton, 'Share Screen + Audio', 'ti-screen-share');
        screenAudioShareButton.classList.remove('is-highlight');
        screenAudioShareButton.disabled = false;
        return;
    }

    setButtonLabel(screenAudioShareButton, 'Stop Screen + Audio', 'ti-screen-share-off');
    screenAudioShareButton.classList.add('is-highlight');
    screenAudioShareButton.disabled = false;
}

function updateReactionControls() {
    if (!reactionsButton) {
        return;
    }

    reactionsButton.disabled = !room;

    if (!room) {
        setReactionPickerOpen(false);
    }
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
    const text = String(name || '').trim();
    const firstCharacter = text.charAt(0).toUpperCase();

    return firstCharacter || 'WD';
}

function buildMediaPlaceholder(name, source = 'camera', avatarUrl = null, label = null) {
    const placeholderLabel = typeof label === 'string'
        ? label
        : (source === 'screen' ? 'Waiting for screen share...' : 'Waiting for media...');
    return `
        ${avatarUrl
            ? `<img src="${escapeHtml(avatarUrl)}" alt="${escapeHtml(name)}" class="participant-avatar-image" loading="lazy" referrerpolicy="no-referrer">`
            : `<div class="participant-avatar">
                <span>${getInitials(name)}</span>
            </div>`}
        ${placeholderLabel ? `<div class="participant-placeholder">${escapeHtml(placeholderLabel)}</div>` : ''}
    `;
}

function resetGrid() {
    pinnedParticipantKey = null;
    grid.innerHTML = `
        <div class="participant-card" data-participant="placeholder">
            <div class="participant-media">
                <div class="participant-avatar">
                    <span>WD</span>
                </div>
                <div class="participant-placeholder">Connect to load your local stream and any remote participants.</div>
            </div>
            <div class="participant-footer">
                <span class="participant-name">Waiting for room</span>
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

function resetMobileParticipantPaging(cards = []) {
    cards.forEach((card) => {
        card.style.removeProperty('grid-column');
        card.style.removeProperty('grid-row');
        card.removeAttribute('data-page-start');
    });
}

function applyMobileParticipantPaging(cards = []) {
    const pageSize = 6;

    cards.forEach((card, index) => {
        const pageIndex = Math.floor(index / pageSize);
        const indexInPage = index % pageSize;
        const column = (indexInPage % 2) + 1;
        const row = Math.floor(indexInPage / 2) + 1;
        const gridColumn = (pageIndex * 2) + column;

        card.style.gridColumn = String(gridColumn);
        card.style.gridRow = String(row);
        card.dataset.pageStart = indexInPage === 0 ? 'true' : 'false';
    });
}

function resetDesktopParticipantPaging(cards = []) {
    cards.forEach((card) => {
        card.style.removeProperty('grid-column');
        card.style.removeProperty('grid-row');
        card.removeAttribute('data-page-start');
    });
}

function removeScreenShareOverflowSummaryCard() {
    grid?.querySelector('[data-summary-card="true"]')?.remove();
}

function buildScreenShareOverflowSummaryCard(overflowCount = 0) {
    const card = document.createElement('div');
    card.className = 'participant-card participant-card-summary';
    card.dataset.summaryCard = 'true';
    card.dataset.source = 'summary';
    card.innerHTML = `
        <div class="participant-media participant-media-summary">
            <div class="participant-summary-count">+${overflowCount}</div>
            <div class="participant-summary-label">${overflowCount === 1 ? 'other' : 'others'}</div>
        </div>
        <div class="participant-footer">
            <div class="participant-footer-meta">
                <span class="participant-name">More attendees</span>
            </div>
        </div>
    `;

    return card;
}

function syncScreenShareOverflow(cards = [], enabled = false, maxVisibleTiles = maxScreenShareVisibleSideTiles) {
    removeScreenShareOverflowSummaryCard();

    const participantCards = cards.filter((card) => card.dataset.summaryCard !== 'true');
    participantCards.forEach((card) => card.classList.remove('is-overflow-hidden'));

    if (!enabled) {
        return participantCards.filter((card) => (card.dataset.source || 'camera') !== 'screen').length;
    }

    const screenCard = participantCards.find((card) => (card.dataset.source || 'camera') === 'screen');
    const sideCards = participantCards.filter((card) => card !== screenCard);

    if (!screenCard || sideCards.length <= maxVisibleTiles) {
        return sideCards.length;
    }

    const visibleParticipantCount = Math.max(0, maxVisibleTiles - 1);
    const overflowCount = sideCards.length - visibleParticipantCount;

    sideCards.forEach((card, index) => {
        card.classList.toggle('is-overflow-hidden', index >= visibleParticipantCount);
    });

    const summaryCard = buildScreenShareOverflowSummaryCard(overflowCount);
    grid.appendChild(summaryCard);

    return visibleParticipantCount + 1;
}

function applyDesktopParticipantPaging(cards = [], columns = 3, rows = 3) {
    const pageSize = Math.max(1, columns * rows);

    cards.forEach((card, index) => {
        const pageIndex = Math.floor(index / pageSize);
        const indexInPage = index % pageSize;
        const column = (indexInPage % columns) + 1;
        const row = Math.floor(indexInPage / columns) + 1;
        const gridColumn = (pageIndex * columns) + column;

        card.style.gridColumn = String(gridColumn);
        card.style.gridRow = String(row);
        card.dataset.pageStart = indexInPage === 0 ? 'true' : 'false';
    });
}

function syncParticipantGridLayout() {
    if (!grid) {
        return;
    }

    const cards = [...grid.querySelectorAll('.participant-card')]
        .filter((card) => card.dataset.participant !== 'placeholder' && card.dataset.summaryCard !== 'true');
    const participantCount = cards.length;
    const screenCards = cards.filter((card) => (card.dataset.source || 'camera') === 'screen');
    const hasSingleScreenShare = screenCards.length === 1;
    const viewportWidth = stage?.clientWidth || window.innerWidth || 0;
    const isMobileViewport = viewportWidth <= 767;
    const isTabletViewport = viewportWidth <= 991;
    const isDesktopViewport = viewportWidth > 991;
    const hasPinnedCard = grid.classList.contains('has-pinned');
    const shouldUseMobilePagedGallery = isMobileViewport && participantCount > 1 && !hasSingleScreenShare && !hasPinnedCard;
    const shouldUseMobileSwipeLayout = isMobileViewport && participantCount > 1 && !hasPinnedCard && !hasSingleScreenShare;
    const shouldUseTabletPagedGallery = !isMobileViewport && isTabletViewport && participantCount > 6 && !hasSingleScreenShare && !hasPinnedCard;
    const shouldUseDesktopPagedGallery = isDesktopViewport && participantCount > 9 && !hasSingleScreenShare && !hasPinnedCard;

    let columns = 1;
    let rows = 1;
    let minWidth = 'min(100%, 220px)';
    let minHeight = 'clamp(180px, 24vh, 320px)';
    let tabletPageColumns = 3;
    let tabletPageRows = 2;
    let desktopPageColumns = 3;
    let desktopPageRows = 3;
    let visibleScreenShareSideTileCount = Math.max(0, participantCount - 1);
    const shouldUseScreenShareOverflow = hasSingleScreenShare && participantCount > 1 && !hasPinnedCard;

    if (shouldUseScreenShareOverflow) {
        visibleScreenShareSideTileCount = syncScreenShareOverflow(cards, true, maxScreenShareVisibleSideTiles);
    } else {
        syncScreenShareOverflow(cards, false, maxScreenShareVisibleSideTiles);
    }

    if (hasSingleScreenShare && participantCount > 1 && !hasPinnedCard) {
        columns = isMobileViewport ? '1' : '2';
        rows = isMobileViewport ? String(participantCount) : String(Math.max(1, visibleScreenShareSideTileCount));
        minWidth = isMobileViewport ? 'min(100%, 100%)' : 'min(100%, 260px)';
        minHeight = isMobileViewport ? 'clamp(120px, 20vh, 220px)' : 'clamp(150px, 18vh, 240px)';
    } else if (shouldUseTabletPagedGallery) {
        tabletPageColumns = viewportWidth >= 860 ? 4 : 3;
        tabletPageRows = 2;
        columns = String(tabletPageColumns);
        rows = String(tabletPageRows);
        minWidth = 'min(100%, 180px)';
        minHeight = 'clamp(150px, 20vh, 220px)';
    } else if (shouldUseDesktopPagedGallery) {
        const pageCount = Math.min(participantCount, 24);
        if (pageCount <= 9) {
            desktopPageColumns = 3;
            desktopPageRows = 3;
        } else if (pageCount <= 12) {
            desktopPageColumns = 4;
            desktopPageRows = 3;
        } else if (pageCount <= 16) {
            desktopPageColumns = 4;
            desktopPageRows = 4;
        } else if (pageCount <= 20) {
            desktopPageColumns = 5;
            desktopPageRows = 4;
        } else {
            desktopPageColumns = 6;
            desktopPageRows = 4;
        }
        columns = String(desktopPageColumns);
        rows = String(desktopPageRows);
        minWidth = 'min(100%, 150px)';
        minHeight = 'clamp(140px, 17vh, 210px)';
    } else if (participantCount <= 1) {
        columns = '1';
        rows = '1';
        minWidth = 'min(100%, 560px)';
        minHeight = 'clamp(240px, 46vh, 520px)';
    } else if (participantCount === 2) {
        columns = isTabletViewport ? '1' : '2';
        rows = isTabletViewport ? '2' : '1';
        minWidth = isTabletViewport ? 'min(100%, 82vw)' : 'min(100%, 360px)';
        minHeight = 'clamp(220px, 34vh, 420px)';
    } else if (participantCount <= 4) {
        columns = '2';
        rows = String(Math.ceil(participantCount / 2));
        minWidth = isTabletViewport ? 'min(100%, 280px)' : 'min(100%, 300px)';
        minHeight = 'clamp(200px, 30vh, 360px)';
    } else if (participantCount <= 6) {
        columns = isTabletViewport ? '2' : '3';
        rows = String(Math.ceil(participantCount / Number(columns)));
        minWidth = 'min(100%, 240px)';
        minHeight = 'clamp(180px, 26vh, 300px)';
    } else if (participantCount <= 9) {
        columns = isTabletViewport ? '2' : '3';
        rows = String(Math.ceil(participantCount / Number(columns)));
        minWidth = 'min(100%, 210px)';
        minHeight = 'clamp(170px, 23vh, 260px)';
    } else {
        columns = viewportWidth >= 1500 ? '4' : '3';
        rows = String(Math.ceil(participantCount / Number(columns)));
        minWidth = 'min(100%, 180px)';
        minHeight = 'clamp(160px, 20vh, 220px)';
    }

    grid.dataset.participantCount = String(participantCount);
    grid.style.setProperty('--participant-columns', columns);
    grid.style.setProperty('--participant-rows', rows);
    grid.style.setProperty('--participant-card-min-width', minWidth);
    grid.style.setProperty('--participant-card-min-height', minHeight);
    grid.style.setProperty('--tablet-page-columns', String(tabletPageColumns));
    grid.style.setProperty('--tablet-page-rows', String(tabletPageRows));
    grid.style.setProperty('--desktop-page-columns', String(desktopPageColumns));
    grid.style.setProperty('--desktop-page-rows', String(desktopPageRows));
    grid.classList.toggle('has-single-screen-share', hasSingleScreenShare && participantCount > 1 && !hasPinnedCard);
    grid.classList.toggle('is-mobile-screen-share', isMobileViewport && hasSingleScreenShare && participantCount > 1 && !hasPinnedCard);
    grid.classList.toggle('is-swipeable', shouldUseMobileSwipeLayout);
    grid.classList.toggle('is-mobile-paged-gallery', shouldUseMobilePagedGallery);
    grid.classList.toggle('is-tablet-paged-gallery', shouldUseTabletPagedGallery);
    grid.classList.toggle('is-desktop-paged-gallery', shouldUseDesktopPagedGallery);
    stage?.classList.toggle('has-tablet-paged-gallery', shouldUseTabletPagedGallery);
    stage?.classList.toggle('has-desktop-paged-gallery', shouldUseDesktopPagedGallery);

    if (shouldUseMobilePagedGallery) {
        applyMobileParticipantPaging(cards);
    } else {
        resetMobileParticipantPaging(cards);
    }

    if (shouldUseTabletPagedGallery) {
        applyDesktopParticipantPaging(cards, tabletPageColumns, tabletPageRows);
    } else if (shouldUseDesktopPagedGallery) {
        applyDesktopParticipantPaging(cards, desktopPageColumns, desktopPageRows);
    } else {
        resetDesktopParticipantPaging(cards);
    }
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
    syncParticipantGridLayout();

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

function updateParticipantCardBadges(identity) {
    const state = participantStates.get(identity);
    if (!state) {
        return;
    }

    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((card) => {
        const media = card.querySelector('.participant-media');
        const meta = card.querySelector('.participant-footer-meta');

        if (!meta) {
            return;
        }

        meta.querySelectorAll('[data-participant-chip]').forEach((element) => element.remove());
    });
}

function updateParticipantReactionDisplay(identity) {
    const state = participantStates.get(identity);

    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((card) => {
        const media = card.querySelector('.participant-media');
        if (!media) {
            return;
        }

        media.querySelectorAll('[data-reaction-burst]').forEach((element) => element.remove());

        if (!state?.activeReaction) {
            return;
        }

        const reactionBurst = document.createElement('div');
        reactionBurst.className = 'participant-reaction-burst';
        reactionBurst.dataset.reactionBurst = 'true';
        reactionBurst.textContent = state.activeReaction;
        media.appendChild(reactionBurst);
    });
}

function updateParticipantCardPlaceholder(identity) {
    const state = participantStates.get(identity);
    if (!state) {
        return;
    }

    grid.querySelectorAll(`[data-participant="${CSS.escape(identity)}"]`).forEach((card) => {
        if ((card.dataset.source || 'camera') === 'screen') {
            return;
        }

        const media = card.querySelector('.participant-media');
        if (!media) {
            return;
        }

        const avatarUrl = resolveAvatarUrl(state.avatarUrl);
        const displayName = card.dataset.displayName || state.name || identity;
        const videoWrappers = [...media.querySelectorAll('[data-track-kind="video"]')];
        const shouldShowPlaceholder = !state.cameraOn || !videoWrappers.length;
        const shouldShowWaitingLabel = !state.hasCameraTrack && !state.hasMicTrack && !videoWrappers.length;

        videoWrappers.forEach((wrapper) => {
            wrapper.hidden = shouldShowPlaceholder;
        });

        card.dataset.avatarUrl = avatarUrl || '';

        if (shouldShowPlaceholder) {
            media.querySelectorAll('.participant-avatar, .participant-avatar-image, .participant-placeholder').forEach((element) => element.remove());
            media.insertAdjacentHTML(
                'afterbegin',
                buildMediaPlaceholder(
                    displayName,
                    card.dataset.source || 'camera',
                    avatarUrl,
                    shouldShowWaitingLabel ? null : ''
                )
            );
            return;
        }

        media.querySelectorAll('.participant-avatar, .participant-avatar-image, .participant-placeholder').forEach((element) => element.remove());
    });
}

function setParticipantState(identity, payload = {}) {
    const state = getParticipantState(identity, payload.name || identity, payload.isLocal || false);
    Object.assign(state, payload);
    renderParticipantsList();
    updateParticipantCardIndicators(identity);
    updateParticipantCardBadges(identity);
    updateParticipantReactionDisplay(identity);
    updateParticipantCardPlaceholder(identity);
}

function removeParticipantState(identity) {
    const state = participantStates.get(identity);
    if (state?.reactionTimeoutId) {
        clearTimeout(state.reactionTimeoutId);
    }
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
    let hasMicTrack = false;
    let hasCameraTrack = false;
    let screenOn = false;

    participant.trackPublications?.forEach((publication) => {
        const source = getPublicationSource(publication, publication?.track);
        const isMuted = !!publication?.isMuted;

        if (source.includes('microphone')) {
            hasMicTrack = true;
            micOn = micOn || !isMuted;
        }

        if (source.includes('camera')) {
            hasCameraTrack = true;
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
        hasMicTrack,
        hasCameraTrack,
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
    updateParticipantCardBadges(identity);
    updateParticipantReactionDisplay(identity);
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

function showParticipantReaction(identity, emoji) {
    const state = getParticipantState(identity);

    if (state.reactionTimeoutId) {
        clearTimeout(state.reactionTimeoutId);
    }

    state.activeReaction = emoji;
    updateParticipantReactionDisplay(identity);

    state.reactionTimeoutId = setTimeout(() => {
        const currentState = participantStates.get(identity);
        if (!currentState) {
            return;
        }

        currentState.activeReaction = '';
        currentState.reactionTimeoutId = null;
        updateParticipantReactionDisplay(identity);
    }, 4000);
}

async function sendReaction(emoji) {
    if (!room?.localParticipant || !emoji) {
        return;
    }

    showParticipantReaction(room.localParticipant.identity, emoji);

    const payload = {
        type: 'reaction',
        sender: participantName,
        senderIdentity: room.localParticipant.identity,
        sentAt: new Date().toISOString(),
        emoji,
    };

    await room.localParticipant.publishData(textEncoder.encode(JSON.stringify(payload)), {
        reliable: false,
    });
}

function handleIncomingData(payload, participant) {
    let parsed = null;

    try {
        parsed = JSON.parse(textDecoder.decode(payload));
    } catch (error) {
        return;
    }

    const localIdentity = room?.localParticipant?.identity || null;
    const senderIdentity = participant?.identity || parsed?.senderIdentity || null;

    if (parsed?.type === 'chat' && parsed.body) {
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
        return;
    }

    if (parsed?.type === 'reaction' && parsed.emoji && senderIdentity) {
        showParticipantReaction(senderIdentity, parsed.emoji);
    }
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
}

async function startScreenShare() {
    if (!room || isScreenShareEnabled) {
        return;
    }

    if (!navigator.mediaDevices?.getDisplayMedia) {
        setRoomMessage('This browser does not support screen sharing.', 'warning');
        return;
    }

    try {
        setRoomMessage(
            'Choose a browser tab and enable audio sharing in the browser prompt if available.',
            'info'
        );

        const tracks = await room.localParticipant.createScreenTracks({ audio: true });

        if (!tracks?.length) {
            throw new Error('No screen or browser-audio tracks were created.');
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
        updateScreenShareButtons();
        setRoomMessage('Screen sharing with browser audio is active.', 'success');
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
        updateScreenShareButtons();
        setRoomMessage(error?.message || 'Unable to start screen and audio sharing.', 'danger');
    }
}

async function stopScreenShare(fromTrackEnded = false) {
    if (!room || !localScreenTracks.length) {
        isScreenShareEnabled = false;
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
            updateReactionControls();
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
            localScreenTracks = [];
            updateMicButton();
            updateCameraButton();
            setButtonLabel(joinButton, 'Reconnect', 'ti-rotate-2');
            updateScreenShareButtons();
            updateReactionControls();
            setReactionPickerOpen(false);
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

        room.on(RoomEvent.MediaDevicesError, (error) => {
            const message = error?.message || 'A camera or microphone device error occurred. Check permissions and device availability.';
            const normalizedMessage = /microphone|audio/i.test(message)
                ? getMediaPermissionMessage('microphone', error)
                : /camera|video/i.test(message)
                    ? getMediaPermissionMessage('camera', error)
                    : message;

            setRoomMessage(normalizedMessage, 'warning');
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
        setParticipantState(room.localParticipant.identity, {
            name: participantName,
            isLocal: true,
        });
        micButton.disabled = false;
        cameraButton.disabled = false;
        await setLocalMediaEnabled('microphone', true);
        await setLocalMediaEnabled('camera', true);

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
        setRoomMessage(error?.message || 'Unable to connect to the meeting room.', 'danger');
        setButtonLabel(joinButton, 'Reconnect', 'ti-rotate-2');
        joinButton.disabled = false;
        leaveButton.disabled = true;
        micButton.disabled = true;
        cameraButton.disabled = true;
        updateScreenShareButtons();
        updateReactionControls();
        setReactionPickerOpen(false);
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
        setRoomMessage('Meeting room details are incomplete. Check the integration settings and room token.', 'danger');
        return;
    }

    setStatus('Connecting...');
    setRoomMessage('Connecting to the meeting room automatically...', 'info');
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
reactionsButton?.addEventListener('click', () => {
    setReactionPickerOpen(!isReactionPickerOpen);
});
chatTabButton?.addEventListener('click', () => setSidebarTab('chat'));
participantsTabButton?.addEventListener('click', () => setSidebarTab('participants'));
reactionPicker?.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-reaction]');
    const emoji = button?.dataset?.reaction;
    if (!emoji) {
        return;
    }

    setReactionPickerOpen(false);

    try {
        await sendReaction(emoji);
    } catch (error) {
        setRoomMessage(error?.message || 'Unable to send reaction.', 'warning');
    }
});

document.addEventListener('click', (event) => {
    if (!isReactionPickerOpen) {
        return;
    }

    if (event.target.closest('#reaction-picker') || event.target.closest('#toggle-reactions')) {
        return;
    }

    setReactionPickerOpen(false);
});

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

chatInput?.addEventListener('focus', () => {
    scrollChatComposerIntoView();
    syncChatKeyboardInset();
});

chatInput?.addEventListener('blur', () => {
    setTimeout(syncChatKeyboardInset, 120);
});

chatTargetSelect?.addEventListener('focus', () => {
    scrollChatComposerIntoView();
    syncChatKeyboardInset();
});

chatTargetSelect?.addEventListener('blur', () => {
    setTimeout(syncChatKeyboardInset, 120);
});

sidebarToggleButton?.addEventListener('click', () => {
    if (isMeetingLayoutFullscreen()) {
        setFullscreenSidebarOpen(!isFullscreenSidebarOpen, 'participants');
        return;
    }

    setSidebarCollapsed(!isSidebarCollapsed);
});

fullscreenButton?.addEventListener('click', async () => {
    if (!meetingLayout) {
        return;
    }

    try {
        if (document.fullscreenElement) {
            await document.exitFullscreen();
        } else {
            await meetingLayout.requestFullscreen();
        }
    } catch (error) {
        setRoomMessage('Fullscreen mode is not available in this browser.', 'warning');
    }
});

sidebarPopupBackdrop?.addEventListener('click', () => {
    if (!isMeetingLayoutFullscreen()) {
        return;
    }

    setFullscreenSidebarOpen(false);
});

micButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    const nextState = !isMicEnabled;
    await setLocalMediaEnabled('microphone', nextState);
});

cameraButton.addEventListener('click', async () => {
    if (!room) {
        return;
    }

    const nextState = !isCameraEnabled;
    await setLocalMediaEnabled('camera', nextState);
});

screenAudioShareButton?.addEventListener('click', async () => {
    if (isScreenShareEnabled) {
        await stopScreenShare();
        return;
    }

    await startScreenShare();
});

window.addEventListener('beforeunload', () => {
    sendLeaveBeacon();
});

document.addEventListener('fullscreenchange', () => {
    if (!isMeetingLayoutFullscreen()) {
        isFullscreenSidebarOpen = false;
        clearFullscreenUiHideTimer();
        setFullscreenUiVisible(true);
    } else {
        showFullscreenUiTemporarily();
    }

    syncFullscreenSidebarPopup();
    syncSidebarToggleButton();
    syncFullscreenButton();
    syncParticipantGridLayout();
});

['mousemove', 'touchstart', 'pointerdown'].forEach((eventName) => {
    document.addEventListener(eventName, () => {
        showFullscreenUiTemporarily();
    }, { passive: true });
});

document.addEventListener('keydown', () => {
    showFullscreenUiTemporarily();
});

window.addEventListener('resize', () => {
    syncParticipantGridLayout();
    syncChatKeyboardInset();
});

window.visualViewport?.addEventListener('resize', syncChatKeyboardInset);
window.visualViewport?.addEventListener('scroll', syncChatKeyboardInset);

resetGrid();
resetChat();
renderParticipantsList();
updateMicButton();
updateCameraButton();
updateChatComposerState();
renderChatTargetOptions();
setSidebarCollapsed(false);
setSidebarTab('chat');
syncFullscreenSidebarPopup();
attemptAutoJoin();
syncFullscreenButton();
updateScreenShareButtons();
syncParticipantGridLayout();
syncChatKeyboardInset();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(Auth::check() ? 'layouts.main' : 'churchmeet::layouts.public_join', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\OPEN\packages\workdo\ChurchMeet\src\Providers/../Resources/views/integrations/livekit_join.blade.php ENDPATH**/ ?>
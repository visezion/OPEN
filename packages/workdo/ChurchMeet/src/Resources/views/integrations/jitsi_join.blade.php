@extends('layouts.main')

@section('page-title', __('Join Jitsi Meeting'))

@section('page-breadcrumb')
    {{ __('Join Jitsi Meeting') }}
@endsection

@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('churchmeet.events.show', $attendanceEvent->event_id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back to Event') }}
        </a>
        <a href="{{ $jitsiMeetingLink }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
            <i class="ti ti-external-link"></i> {{ $canStartMeeting ? __('Open in New Tab') : __('Fallback Join Link') }}
        </a>
    </div>
@endsection

@push('css')
<style>
    .jitsi-join-page {
        --jitsi-ink: #19304a;
        --jitsi-muted: #6d7f92;
        --jitsi-line: #d9e1e8;
        --jitsi-soft: #f6f8fb;
        --jitsi-panel: #eef4fa;
        --jitsi-primary: #245f86;
        --jitsi-success: #2f7b58;
        --jitsi-warning: #95661c;
        --jitsi-danger: #a24343;
    }

    .jitsi-join-page .card {
        border: 1px solid var(--jitsi-line) !important;
        border-radius: 14px;
        box-shadow: none !important;
        background: #fff;
    }

    .jitsi-shell {
        display: grid;
        grid-template-columns: minmax(0, 340px) minmax(0, 1fr);
        gap: 1.25rem;
    }

    .jitsi-stack {
        display: grid;
        gap: 1rem;
    }

    .jitsi-hero {
        border-top: 3px solid var(--jitsi-primary);
        background: linear-gradient(180deg, rgba(36, 95, 134, 0.08), rgba(36, 95, 134, 0)), #fff;
    }

    .jitsi-eyebrow,
    .jitsi-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .jitsi-eyebrow {
        background: var(--jitsi-panel);
        color: var(--jitsi-primary);
    }

    .jitsi-pill {
        background: var(--jitsi-soft);
        color: var(--jitsi-muted);
        border: 1px solid var(--jitsi-line);
    }

    .jitsi-hero h2,
    .jitsi-section-title {
        color: #102840;
        font-weight: 800;
    }

    .jitsi-hero h2 {
        margin: 0.85rem 0 0.4rem;
        font-size: clamp(1.65rem, 2.4vw, 2.15rem);
        line-height: 1.1;
    }

    .jitsi-copy,
    .jitsi-meta-value-sub,
    .jitsi-check span,
    .jitsi-status-copy {
        color: var(--jitsi-muted);
        line-height: 1.65;
    }

    .jitsi-meta-grid {
        display: grid;
        gap: 0.85rem;
    }

    .jitsi-meta-row {
        display: grid;
        grid-template-columns: minmax(0, 105px) 1fr;
        gap: 0.8rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid rgba(217, 225, 232, 0.9);
    }

    .jitsi-meta-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .jitsi-meta-label {
        color: var(--jitsi-muted);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .jitsi-meta-value {
        color: #102840;
        font-weight: 700;
        word-break: break-word;
    }

    .jitsi-checklist {
        display: grid;
        gap: 0.75rem;
    }

    .jitsi-check {
        display: flex;
        gap: 0.8rem;
        align-items: flex-start;
        padding: 0.85rem 0.95rem;
        border: 1px solid var(--jitsi-line);
        border-radius: 12px;
        background: var(--jitsi-soft);
    }

    .jitsi-check-index {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid var(--jitsi-line);
        background: #fff;
        color: var(--jitsi-primary);
        font-weight: 800;
        font-size: 0.84rem;
    }

    .jitsi-status-panel {
        display: flex;
        gap: 0.8rem;
        align-items: flex-start;
        padding: 0.95rem 1rem;
        border-radius: 12px;
        border: 1px solid var(--jitsi-line);
        background: var(--jitsi-soft);
    }

    .jitsi-status-panel.is-ready {
        background: #edf7f1;
        border-color: rgba(47, 123, 88, 0.2);
    }

    .jitsi-status-panel.is-warning {
        background: #fff7ea;
        border-color: rgba(149, 102, 28, 0.2);
    }

    .jitsi-status-panel.is-danger {
        background: #fceeee;
        border-color: rgba(162, 67, 67, 0.2);
    }

    .jitsi-status-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #fff;
        color: var(--jitsi-primary);
    }

    .jitsi-status-panel.is-ready .jitsi-status-icon {
        color: var(--jitsi-success);
    }

    .jitsi-status-panel.is-warning .jitsi-status-icon {
        color: var(--jitsi-warning);
    }

    .jitsi-status-panel.is-danger .jitsi-status-icon {
        color: var(--jitsi-danger);
    }

    .jitsi-room {
        min-height: 74vh;
    }

    .jitsi-room-frame {
        min-height: 68vh;
        border: 1px solid var(--jitsi-line);
        border-radius: 14px;
        overflow: hidden;
        background: #0f1924;
    }

    .jitsi-room-frame > iframe {
        width: 100% !important;
        min-height: 68vh !important;
    }

    .jitsi-room-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .jitsi-room-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
    }

    .jitsi-actions-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        margin-top: 0.85rem;
    }

    @media (max-width: 991.98px) {
        .jitsi-shell {
            grid-template-columns: 1fr;
        }

        .jitsi-room,
        .jitsi-room-frame,
        .jitsi-room-frame > iframe {
            min-height: 60vh !important;
        }
    }
</style>
@endpush

@section('content')
@php
    $eventTitle = optional($attendanceEvent->event)->title ?: __('Church Meeting');
    $meetingLabel = $attendanceEvent->meeting_id ?: $jitsiRoomName;
@endphp

<div class="container-fluid jitsi-join-page">
    <div class="jitsi-shell">
        <div class="jitsi-stack">
            <div class="card jitsi-hero">
                <div class="card-body">
                    <span class="jitsi-eyebrow">
                        <i class="ti ti-brand-tabler"></i> {{ __('Jitsi Meeting Room') }}
                    </span>
                    <h2>{{ $eventTitle }}</h2>
                    <p class="jitsi-copy mb-0">
                        {{ __('Join this meeting inside OPEN. Your presence will be recorded automatically once you enter the room.') }}
                    </p>
                    <div class="jitsi-actions-inline">
                        <span class="jitsi-pill"><i class="ti ti-hash"></i> {{ $meetingLabel }}</span>
                        <span class="jitsi-pill"><i class="ti ti-world"></i> {{ $jitsiDomain }}</span>
                        <span class="jitsi-pill"><i class="ti ti-user-check"></i> {{ __('Attendance linked') }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="jitsi-section-title mb-3">{{ __('Meeting Details') }}</div>
                    <div class="jitsi-meta-grid">
                        <div class="jitsi-meta-row">
                            <div class="jitsi-meta-label">{{ __('Platform') }}</div>
                            <div>
                                <div class="jitsi-meta-value">{{ __('Jitsi Meet') }}</div>
                                <div class="jitsi-meta-value-sub">{{ __('Free browser-based video meeting') }}</div>
                            </div>
                        </div>
                        <div class="jitsi-meta-row">
                            <div class="jitsi-meta-label">{{ __('Room Name') }}</div>
                            <div class="jitsi-meta-value">{{ $meetingLabel }}</div>
                        </div>
                        <div class="jitsi-meta-row">
                            <div class="jitsi-meta-label">{{ __('Domain') }}</div>
                            <div class="jitsi-meta-value">{{ $jitsiDomain }}</div>
                        </div>
                        <div class="jitsi-meta-row">
                            <div class="jitsi-meta-label">{{ __('Access Link') }}</div>
                            <div>
                                <a href="{{ $jitsiMeetingLink }}" target="_blank" rel="noopener" class="jitsi-meta-value text-decoration-none">
                                    {{ $jitsiMeetingLink }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="jitsi-section-title mb-3">{{ __('Join Checklist') }}</div>
                    <div class="jitsi-checklist">
                        <div class="jitsi-check">
                            <div class="jitsi-check-index">1</div>
                            <div>
                                <strong>{{ __('Allow microphone and camera access') }}</strong>
                                <span>{{ __('Jitsi needs browser media permissions before it can connect you to the room.') }}</span>
                            </div>
                        </div>
                        <div class="jitsi-check">
                            <div class="jitsi-check-index">2</div>
                            <div>
                                <strong>{{ __('Use your OPEN identity') }}</strong>
                                <span>{{ __('Your current user name is passed into the room so attendance and participation stay tied to your account.') }}</span>
                            </div>
                        </div>
                        <div class="jitsi-check">
                            <div class="jitsi-check-index">3</div>
                            <div>
                                <strong>{{ __('Stay in this page for in-app joining') }}</strong>
                                <span>{{ __('If the embedded room fails, the fallback button opens the same meeting in a new tab.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card jitsi-room">
            <div class="card-body">
                <div class="jitsi-room-toolbar">
                    <div>
                        <h5 class="jitsi-section-title mb-1">{{ __('Live Meeting Room') }}</h5>
                        <p class="jitsi-copy mb-0">{{ __('The room loads below using the Jitsi IFrame API.') }}</p>
                    </div>
                    <div class="jitsi-room-badges">
                        <span class="jitsi-pill"><i class="ti ti-device-desktop"></i> {{ __('Embedded') }}</span>
                        @if($canStartMeeting)
                            <span class="jitsi-pill"><i class="ti ti-shield-check"></i> {{ __('Admin / host access') }}</span>
                        @endif
                    </div>
                </div>

                <div id="jitsi-status" class="jitsi-status-panel is-warning" role="status" aria-live="polite">
                    <div class="jitsi-status-icon">
                        <i class="ti ti-loader"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ __('Preparing Jitsi room') }}</div>
                        <div class="jitsi-status-copy">{{ __('Loading the meeting API and connecting your browser to the live room.') }}</div>
                    </div>
                </div>

                <div id="jitsi-room" class="jitsi-room-frame"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://{{ $jitsiDomain }}/external_api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roomTarget = document.getElementById('jitsi-room');
    const statusPanel = document.getElementById('jitsi-status');
    const statusTitle = statusPanel.querySelector('.fw-bold');
    const statusCopy = statusPanel.querySelector('.jitsi-status-copy');
    const statusIcon = statusPanel.querySelector('.jitsi-status-icon i');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const meetingPresenceUrl = @json(route('churchmeet.meetings.presence', $attendanceEvent->id));
    const meetingFallbackUrl = @json($jitsiMeetingLink);
    const domain = @json($jitsiDomain);
    const roomName = @json($jitsiRoomName);
    const displayName = @json(Auth::user()->name ?? 'Guest');
    const email = @json(Auth::user()->email ?? '');
    let joinPresenceSent = false;
    let leavePresenceSent = false;

    function setStatus(type, title, copy, icon) {
        statusPanel.classList.remove('is-ready', 'is-warning', 'is-danger');
        statusPanel.classList.add(type);
        statusTitle.textContent = title;
        statusCopy.textContent = copy;
        statusIcon.className = icon;
    }

    function sendPresence(action = 'join', keepalive = false) {
        if (action === 'join' && joinPresenceSent) {
            return;
        }

        if (action === 'leave' && leavePresenceSent) {
            return;
        }

        fetch(meetingPresenceUrl, {
            method: 'POST',
            credentials: 'same-origin',
            keepalive: keepalive,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ _token: csrfToken, action: action })
        }).then(function () {
            if (action === 'join') {
                joinPresenceSent = true;
            }

            if (action === 'leave') {
                leavePresenceSent = true;
            }
        }).catch(function () {
            setStatus(
                'is-warning',
                @json(__('Joined, but attendance could not be confirmed')),
                @json(__('Your meeting connection is active. Refresh once after the meeting if attendance does not appear immediately.')),
                'ti ti-alert-triangle'
            );
        });
    }

    if (typeof window.JitsiMeetExternalAPI !== 'function') {
        setStatus(
            'is-danger',
            @json(__('Jitsi API failed to load')),
            @json(__('The embedded room could not start in this browser. Use the fallback link to open the meeting in a new tab.')),
            'ti ti-alert-circle'
        );
        return;
    }

    try {
        const api = new window.JitsiMeetExternalAPI(domain, {
            roomName: roomName,
            parentNode: roomTarget,
            width: '100%',
            height: '100%',
            userInfo: {
                displayName: displayName,
                email: email
            },
            configOverwrite: {
                prejoinPageEnabled: true,
                startWithAudioMuted: false,
                startWithVideoMuted: false
            },
            interfaceConfigOverwrite: {
                SHOW_JITSI_WATERMARK: false,
                SHOW_WATERMARK_FOR_GUESTS: false
            }
        });

        api.addListener('videoConferenceJoined', function () {
            setStatus(
                'is-ready',
                @json(__('You are live in the room')),
                @json(__('Your in-app session is active and attendance has been marked for this event.')),
                'ti ti-check'
            );
            sendPresence('join');
        });

        api.addListener('participantJoined', function () {
            setStatus(
                'is-ready',
                @json(__('Meeting room connected')),
                @json(__('The room is active and participants are joining normally.')),
                'ti ti-users'
            );
        });

        api.addListener('readyToClose', function () {
            setStatus(
                'is-warning',
                @json(__('Meeting window closed')),
                @json(__('You can rejoin from this page or continue in a new browser tab.')),
                'ti ti-door-exit'
            );
            sendPresence('leave', true);
        });

        api.addListener('errorOccurred', function (error) {
            const errorMessage = error && error.message
                ? error.message
                : @json(__('The embedded room could not connect to Jitsi. Try the fallback link or reload this page.'));

            setStatus(
                'is-danger',
                @json(__('Jitsi reported an error')),
                errorMessage,
                'ti ti-plug-x'
            );
        });
    } catch (error) {
        setStatus(
            'is-danger',
            @json(__('Unable to initialize Jitsi room')),
            error && error.message ? error.message : @json(__('The embedded room could not be started.')),
            'ti ti-alert-circle'
        );
    }

    window.addEventListener('beforeunload', function () {
        sendPresence('leave', true);
    });
});
</script>
@endpush

@extends('layouts.main')

@section('page-title', __('Join Jitsi Meeting'))

@section('page-breadcrumb')
    {{ __('Join Jitsi Meeting') }}
@endsection

@section('page-action')
    <div class="d-flex gap-2">
        <a href="{{ route('churchmeet.events.show', $attendanceEvent->event_id) }}" class="btn btn-sm btn-outline-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back to Events') }}
        </a>
        <a href="{{ $jitsiMeetingLink }}" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
            <i class="ti ti-external-link"></i> {{ $canStartMeeting ? __('Open in New Tab') : __('Fallback Join Link') }}
        </a>
    </div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/integrations.css') }}">
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

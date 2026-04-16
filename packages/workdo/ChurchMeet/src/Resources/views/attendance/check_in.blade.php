@extends('layouts.guest')

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
@endpush

@section('content')
@php
    $event = $attendanceEvent->event;
    $platform = strtolower((string) $attendanceEvent->online_platform);
    $platformLabel = $platform !== '' ? strtoupper($platform) : __('Online');
@endphp

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-user-check"></i>{{ __('ChurchMeet Check-In') }}</span>
            <h1 class="churchmeet-title">{{ $event->title }}</h1>
            <p class="churchmeet-copy mb-0">{{ __('Confirm your presence and join the live session from one branded check-in page.') }}</p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Platform') }}</span>
                    <strong class="churchmeet-stat-value">{{ $platformLabel }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Attendance will be recorded for this online session.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Mode') }}</span>
                    <strong class="churchmeet-stat-value">{{ ucfirst($attendanceEvent->mode ?: 'online') }}</strong>
                    <span class="churchmeet-stat-note">{{ __('This page is optimized for quick member confirmation.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Meeting Access') }}</span>
                    <strong class="churchmeet-stat-value">{{ $attendanceEvent->meeting_link ? __('Ready') : __('Pending') }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Use the join link below if a room is available.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Event') }}</span>
                    <strong class="churchmeet-stat-value">{{ \Illuminate\Support\Str::limit($event->title, 16) }}</strong>
                    <span class="churchmeet-stat-note">{{ __('ChurchMeet keeps your attendance and room access in sync.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Confirm Presence') }}</h5>
                    <p>{{ __('Use one tap to mark yourself present before joining the session.') }}</p>
                </div>
                <div class="churchmeet-section-body">
                    <form action="{{ route('churchmeet.attendance.onlineCheckIn', $attendanceEvent->id) }}" method="POST" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="ti ti-check me-1"></i>{{ __('I Am Here') }}
                        </button>
                    </form>

                    <div class="churchmeet-stack">
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Session Type') }}</span>
                            <span class="value">{{ ucfirst($attendanceEvent->mode ?: 'online') }}</span>
                        </div>
                        <div class="churchmeet-detail-item">
                            <span class="label">{{ __('Room Platform') }}</span>
                            <span class="value">{{ $platformLabel }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="churchmeet-section h-100">
                <div class="churchmeet-section-head">
                    <h5>{{ __('Join Session') }}</h5>
                    <p>{{ __('Meeting access stays in the same ChurchMeet visual language as the rest of the module.') }}</p>
                </div>
                <div class="churchmeet-section-body">
                    @if($platform === 'zoom' && $attendanceEvent->meeting_link)
                        <a href="{{ $attendanceEvent->meeting_link }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                            <i class="ti ti-brand-zoom me-1"></i>{{ __('Join Zoom Meeting') }}
                        </a>
                    @elseif($platform === 'livekit')
                        <a href="{{ route('churchmeet.meetings.join', $attendanceEvent->id) }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                            <i class="ti ti-brand-webrtc me-1"></i>{{ __('Open LiveKit Room') }}
                        </a>
                    @elseif($platform === 'youtube' && $attendanceEvent->meeting_link)
                        <iframe
                            class="churchmeet-embed"
                            src="{{ $attendanceEvent->meeting_link }}"
                            title="{{ __('Live stream player') }}"
                            allowfullscreen></iframe>
                    @else
                        <div class="churchmeet-empty">
                            <div>
                                <div class="fw-semibold mb-2">{{ __('Meeting link not available') }}</div>
                                <div>{{ __('The organizer has not published a join link for this session yet.') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

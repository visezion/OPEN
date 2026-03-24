@extends('layouts.main')

@section('page-title', __('Join Zoom Meeting'))

@push('css')
    <link rel="stylesheet" href="https://source.zoom.us/3.11.2/css/bootstrap.css">
    <style>
        #meetingSDKElement {
            min-height: 720px;
            background: #0f172a;
            border-radius: 16px;
            overflow: hidden;
        }
    </style>
@endpush

@section('page-action')
    @if($canStartMeeting)
        <a href="{{ $attendanceEvent->host_start_url }}" target="_blank" rel="noopener" class="btn btn-warning btn-sm">
            <i class="ti ti-player-play"></i> {{ __('Start As Host') }}
        </a>
    @endif
    @if($attendanceEvent->meeting_link)
        <a href="{{ $attendanceEvent->meeting_link }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">
            <i class="ti ti-external-link"></i> {{ __('Open Zoom Fallback') }}
        </a>
    @endif
    <a href="{{ route('churchmeet.events.show', $attendanceEvent->event_id) }}" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> {{ __('Back to Event') }}
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="mb-1">{{ $attendanceEvent->event->title ?? __('Zoom Meeting') }}</h5>
                    <p class="text-muted mb-3">{{ __('Join this meeting without leaving OPEN.') }}</p>

                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Meeting ID') }}</dt>
                        <dd class="col-sm-7">{{ $attendanceEvent->meeting_id ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Passcode') }}</dt>
                        <dd class="col-sm-7">{{ $attendanceEvent->meeting_passcode ?: '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Platform') }}</dt>
                        <dd class="col-sm-7">{{ ucfirst($attendanceEvent->online_platform ?: 'zoom') }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-2">{{ __('Connection status') }}</h6>
                    @if($meetingSdkEnabled)
                        <div class="alert alert-success mb-0">
                            {{ __('Meeting SDK is configured. The embedded meeting room will load on this page.') }}
                        </div>
                    @else
                        <div class="alert alert-warning mb-2">
                            {{ __('Meeting SDK credentials are not configured yet. Users can still join through the Zoom fallback link.') }}
                        </div>
                        <a href="{{ route('churchmeet.zoom.index') }}" class="btn btn-outline-secondary btn-sm">
                            {{ __('Configure Zoom SDK') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div id="zoom-status" class="alert alert-info mb-3">
                        {{ __('Preparing Zoom meeting room...') }}
                    </div>
                    <div id="meetingSDKElement"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($meetingSdkEnabled)
        <script src="https://source.zoom.us/3.11.2/zoom-meeting-embedded-3.11.2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', async function () {
                const statusBox = document.getElementById('zoom-status');
                const rootElement = document.getElementById('meetingSDKElement');

                function setStatus(message, type = 'info') {
                    statusBox.className = `alert alert-${type} mb-3`;
                    statusBox.textContent = message;
                }

                try {
                    setStatus('Requesting secure Zoom session...', 'info');

                    const response = await fetch(@json(route('churchmeet.zoom.meetings.signature', $attendanceEvent->id)), {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                        },
                    });

                    const payload = await response.json();

                    if (!response.ok) {
                        throw new Error(payload.message || 'Unable to create Zoom session.');
                    }

                    const client = ZoomMtgEmbedded.createClient();

                    await client.init({
                        zoomAppRoot: rootElement,
                        language: 'en-US',
                        patchJsMedia: true,
                        leaveOnPageUnload: true,
                    });

                    setStatus('Joining meeting...', 'info');

                    await client.join({
                        sdkKey: payload.sdkKey,
                        signature: payload.signature,
                        meetingNumber: payload.meetingNumber,
                        password: payload.password || '',
                        userName: payload.userName,
                        userEmail: payload.userEmail || '',
                    });

                    setStatus('Connected to Zoom meeting.', 'success');
                } catch (error) {
                    setStatus(error.message || 'Zoom meeting failed to load.', 'danger');
                }
            });
        </script>
    @else
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const statusBox = document.getElementById('zoom-status');
                statusBox.className = 'alert alert-warning mb-3';
                statusBox.textContent = 'Embedded Zoom join is unavailable until Meeting SDK credentials are configured.';
            });
        </script>
    @endif
@endpush


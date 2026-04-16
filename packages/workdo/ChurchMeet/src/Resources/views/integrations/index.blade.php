@extends('layouts.main')

@section('page-title', __('Integrations'))

@section('page-breadcrumb')
    {{ __('ChurchMeet') }},{{ __('Integrations') }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/integrations.css') }}">
@endpush

@section('content')
@php
    $preferredPlatform = old('preferred_platform', $setting->preferred_platform ?: 'jitsi');
    $livekitReady = ($setting->livekit_enabled ?? false)
        && !empty($setting->livekit_server_url)
        && !empty($setting->livekit_api_key)
        && !empty($setting->livekit_api_secret);
    $zoomReady = !empty($setting->account_id) && !empty($setting->client_id) && !empty($setting->client_secret);
@endphp
<div class="row churchmeet-integrations">
    <div class="col-12 mb-4">
        <div class="card hero-card">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start">
                    <div>
                        <h4 class="mb-2">{{ __('ChurchMeet Integrations') }}</h4>
                        <p class="section-copy mb-0">{{ __('Configure Zoom, Jitsi, and LiveKit from one place, then choose which platform ChurchMeet should prefer when admins create online events.') }}</p>
                    </div>
                    <span class="badge bg-light text-primary border">{{ __('Workspace Settings') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white p-4">
                <h5 class="mb-1">{{ __('Meeting Platform Settings') }}</h5>
                <p class="section-copy mb-0">{{ __('Jitsi works quickly with a public or self-hosted server. LiveKit adds a richer in-app room experience. Zoom remains available for scheduling and participant sync.') }}</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('churchmeet.integrations.save') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">{{ __('Preferred Platform') }}</label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="platform-card d-block {{ $preferredPlatform === 'jitsi' ? 'is-active' : '' }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_platform" value="jitsi" {{ $preferredPlatform === 'jitsi' ? 'checked' : '' }}>
                                        <span class="fw-semibold ms-1">{{ __('Jitsi Meet') }}</span>
                                    </div>
                                    <div class="text-muted mt-2">{{ __('Simple zero-cost browser meeting rooms with optional self-hosting.') }}</div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="platform-card d-block {{ $preferredPlatform === 'livekit' ? 'is-active' : '' }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_platform" value="livekit" {{ $preferredPlatform === 'livekit' ? 'checked' : '' }}>
                                        <span class="fw-semibold ms-1">{{ __('LiveKit') }}</span>
                                    </div>
                                    <div class="text-muted mt-2">{{ __('Best when you want OPEN-hosted video rooms with camera, mic, and participant presence inside ChurchMeet.') }}</div>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="platform-card d-block {{ $preferredPlatform === 'zoom' ? 'is-active' : '' }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="preferred_platform" value="zoom" {{ $preferredPlatform === 'zoom' ? 'checked' : '' }}>
                                        <span class="fw-semibold ms-1">{{ __('Zoom') }}</span>
                                    </div>
                                    <div class="text-muted mt-2">{{ __('Best when you need Zoom scheduling, participant sync, and Meeting SDK support.') }}</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">{{ __('Jitsi Configuration') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="jitsi_enabled" value="1" {{ old('jitsi_enabled', $setting->jitsi_enabled ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ __('Enable Jitsi in ChurchMeet') }}</label>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __('Jitsi Server Domain') }}</label>
                                <input type="text" name="jitsi_server_domain" value="{{ old('jitsi_server_domain', $setting->jitsi_server_domain ?: 'meet.jit.si') }}" class="form-control" placeholder="meet.jit.si">
                                <small class="text-muted d-block mt-1">{{ __('Use only the host name. ChurchMeet will build the room URL automatically.') }}</small>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">{{ __('Room Prefix') }}</label>
                                <input type="text" name="jitsi_room_prefix" value="{{ old('jitsi_room_prefix', $setting->jitsi_room_prefix) }}" class="form-control" placeholder="churchmeet">
                                <small class="text-muted d-block mt-1">{{ __('Optional prefix added to generated Jitsi room names.') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">{{ __('LiveKit Configuration') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="livekit_enabled" value="1" {{ old('livekit_enabled', $setting->livekit_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ __('Enable LiveKit in ChurchMeet') }}</label>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Server URL') }}</label>
                                    <input type="text" name="livekit_server_url" value="{{ old('livekit_server_url', $setting->livekit_server_url) }}" class="form-control" placeholder="https://your-project.livekit.cloud">
                                    <small class="text-muted d-block mt-1">{{ __('Use your LiveKit project URL or self-hosted server URL. ChurchMeet converts it to the proper WebSocket endpoint automatically.') }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Room Prefix') }}</label>
                                    <input type="text" name="livekit_room_prefix" value="{{ old('livekit_room_prefix', $setting->livekit_room_prefix) }}" class="form-control" placeholder="churchmeet">
                                    <small class="text-muted d-block mt-1">{{ __('Optional prefix added to generated LiveKit room names.') }}</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('API Key') }}</label>
                                    <input type="text" name="livekit_api_key" value="{{ old('livekit_api_key', $setting->livekit_api_key) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('API Secret') }}</label>
                                    <input type="text" name="livekit_api_secret" value="{{ old('livekit_api_secret', $setting->livekit_api_secret) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Participant Token TTL') }}</label>
                                    <select name="livekit_token_ttl_minutes" class="form-select">
                                        @foreach([15,30,60,120,240,480,720,1440] as $minutes)
                                            <option value="{{ $minutes }}" {{ (int) old('livekit_token_ttl_minutes', $setting->livekit_token_ttl_minutes ?? 120) === $minutes ? 'selected' : '' }}>
                                                {{ $minutes < 60 ? $minutes.' min' : ($minutes % 1440 === 0 ? 'Daily' : ($minutes / 60).' hr') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted d-block mt-1">{{ __('How long each browser join token should remain valid.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">{{ __('Zoom Configuration') }}</h6>
                            <div class="d-flex gap-2">
                                <a href="{{ route('churchmeet.integrations.zoom.test') }}" class="btn btn-sm btn-outline-secondary">{{ __('Test Connection') }}</a>
                                <a href="{{ route('churchmeet.integrations.zoom.sync') }}" class="btn btn-sm btn-outline-primary">{{ __('Sync Now') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Account ID') }}</label>
                                    <input type="text" name="account_id" value="{{ old('account_id', $setting->account_id) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Host User ID or Email') }}</label>
                                    <input type="text" name="host_user_id" value="{{ old('host_user_id', $setting->host_user_id) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Client ID') }}</label>
                                    <input type="text" name="client_id" value="{{ old('client_id', $setting->client_id) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Client Secret') }}</label>
                                    <input type="text" name="client_secret" value="{{ old('client_secret', $setting->client_secret) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Meeting SDK Key') }}</label>
                                    <input type="text" name="meeting_sdk_key" value="{{ old('meeting_sdk_key', $setting->meeting_sdk_key) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Meeting SDK Secret') }}</label>
                                    <input type="text" name="meeting_sdk_secret" value="{{ old('meeting_sdk_secret', $setting->meeting_sdk_secret) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Sync Interval') }}</label>
                                    <select name="interval_minutes" class="form-select">
                                        @foreach([5,10,15,30,60,120,360,720,1440] as $minutes)
                                            <option value="{{ $minutes }}" {{ (int) old('interval_minutes', $setting->interval_minutes ?? 15) === $minutes ? 'selected' : '' }}>
                                                {{ $minutes < 60 ? $minutes.' min' : ($minutes % 1440 === 0 ? 'Daily' : ($minutes / 60).' hr') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" name="active" value="1" {{ old('active', $setting->active) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ __('Enable Zoom auto sync') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">{{ __('Save Integration Settings') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header bg-white"><h6 class="mb-0">{{ __('Current Status') }}</h6></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('Preferred Platform') }}</span><strong>{{ strtoupper($setting->preferred_platform ?: 'JITSI') }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('Jitsi Domain') }}</span><strong>{{ $setting->jitsi_server_domain ?: 'meet.jit.si' }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('Jitsi Enabled') }}</span><strong>{{ ($setting->jitsi_enabled ?? true) ? __('Yes') : __('No') }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('LiveKit') }}</span><strong>{{ $livekitReady ? __('Configured') : __('Incomplete') }}</strong></div>
                <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ __('LiveKit Server') }}</span><strong>{{ $setting->livekit_server_url ?: __('Not set') }}</strong></div>
                <div class="d-flex justify-content-between"><span class="text-muted">{{ __('Zoom Credentials') }}</span><strong>{{ $zoomReady ? __('Configured') : __('Incomplete') }}</strong></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white"><h6 class="mb-0">{{ __('Recent Online Events') }}</h6></div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($recentEvents as $event)
                        <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $event->event->title ?? __('Event') }}</div>
                                <small class="text-muted">{{ strtoupper($event->online_platform ?: 'N/A') }} • {{ $event->meeting_id ?: __('No room yet') }}</small>
                            </div>
                            <a href="{{ route('churchmeet.attendance_events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">{{ __('Open') }}</a>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-muted">{{ __('No recent meeting-enabled events found.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white"><h6 class="mb-0">{{ __('Recent Zoom Participants') }}</h6></div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentParticipants as $participant)
                        <div class="list-group-item px-0">
                            <div class="fw-semibold">{{ $participant->user_name }}</div>
                            <small class="text-muted">{{ $participant->user_email }} • {{ __('Duration') }}: {{ $participant->duration }}s</small>
                        </div>
                    @empty
                        <div class="text-muted">{{ __('No Zoom participants have been synced yet.') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

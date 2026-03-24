@extends('layouts.main')

@section('page-title', __('Zoom Integration'))

@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.church') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active">{{ __('Zoom Integration') }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ __('Server-to-Server OAuth') }}</h6>
        <div>
          <a href="{{ route('churchly.zoom.test') }}" class="btn btn-sm btn-outline-secondary">{{ __('Test Connection') }}</a>
          <a href="{{ route('churchly.zoom.sync') }}" class="btn btn-sm btn-outline-primary">{{ __('Sync Now') }}</a>
        </div>
      </div>
      <div class="card-body">
        <div class="alert alert-info">
          <strong>{{ __('Where to get each value') }}:</strong>
          {{ __('Use your Zoom Marketplace app credentials for OAuth and Meeting SDK values.') }}
          <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer" class="alert-link">
            {{ __('Open Zoom Marketplace Apps') }}
          </a>
        </div>
        <form method="POST" action="{{ route('churchly.zoom.save') }}">@csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Account ID') }}</label>
            <input type="text" name="account_id" value="{{ old('account_id',$setting->account_id) }}" class="form-control" placeholder="zoom account id">
            <small class="text-muted d-block mt-1">
              {{ __('From your Zoom Server-to-Server OAuth app credentials page.') }}
              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer">{{ __('Where to find Account ID') }}</a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Client ID') }}</label>
            <input type="text" name="client_id" value="{{ old('client_id',$setting->client_id) }}" class="form-control" placeholder="client id">
            <small class="text-muted d-block mt-1">
              {{ __('Use the Client ID from the same Server-to-Server OAuth app.') }}
              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer">{{ __('Where to find Client ID') }}</a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Client Secret') }}</label>
            <input type="text" name="client_secret" value="{{ old('client_secret',$setting->client_secret) }}" class="form-control" placeholder="client secret">
            <small class="text-muted d-block mt-1">
              {{ __('Use the Client Secret from your Server-to-Server OAuth app.') }}
              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer">{{ __('Where to find Client Secret') }}</a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Host User ID or Email') }}</label>
            <input type="text" name="host_user_id" value="{{ old('host_user_id',$setting->host_user_id) }}" class="form-control" placeholder="me or host user id">
            <small class="text-muted d-block mt-1">{{ __('Used when Churchly creates scheduled meetings through Zoom.') }}</small>
            <small class="text-muted d-block">
              {{ __('Use a Zoom host email (recommended) or user ID from Zoom user management.') }}
              <a href="https://zoom.us/account/user" target="_blank" rel="noopener noreferrer">{{ __('Open Zoom User Management') }}</a>
            </small>
          </div>
          <hr>
          <h6 class="mb-3">{{ __('Meeting SDK (for in-app join)') }}</h6>
          <div class="mb-3">
            <label class="form-label">{{ __('Meeting SDK Key') }}</label>
            <input type="text" name="meeting_sdk_key" value="{{ old('meeting_sdk_key',$setting->meeting_sdk_key) }}" class="form-control" placeholder="sdk key">
            <small class="text-muted d-block mt-1">
              {{ __('From your Zoom Meeting SDK app credentials.') }}
              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer">{{ __('Where to find SDK Key') }}</a>
            </small>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Meeting SDK Secret') }}</label>
            <input type="text" name="meeting_sdk_secret" value="{{ old('meeting_sdk_secret',$setting->meeting_sdk_secret) }}" class="form-control" placeholder="sdk secret">
            <small class="text-muted d-block mt-1">{{ __('Required for users to join Zoom meetings inside OPEN instead of leaving the app.') }}</small>
            <small class="text-muted d-block">
              {{ __('Use the secret from the same Zoom Meeting SDK app.') }}
              <a href="https://marketplace.zoom.us/user/build" target="_blank" rel="noopener noreferrer">{{ __('Where to find SDK Secret') }}</a>
            </small>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">{{ __('Sync Interval') }}</label>
              <select name="interval_minutes" class="form-select">
                @foreach([5,10,15,30,60,120,360,720,1440] as $m)
                  <option value="{{ $m }}" {{ ($setting->interval_minutes ?? 15)==$m ? 'selected':'' }}>{{ $m<60?$m.' min':($m%1440==0?'Daily':($m/60).' hr') }}</option>
                @endforeach
              </select>
              <small class="text-muted d-block mt-1">{{ __('How often Churchly pulls participant attendance from Zoom.') }}</small>
            </div>
            <div class="col-md-6 align-self-end">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="active" value="1" {{ $setting->active?'checked':'' }}>
                <label class="form-check-label">{{ __('Enable Auto Sync') }}</label>
              </div>
              <small class="text-muted d-block mt-1">{{ __('Turn on automatic background sync using the interval above.') }}</small>
            </div>
          </div>
          <div class="text-end mt-3"><button class="btn btn-primary">{{ __('Save Settings') }}</button></div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h6 class="mb-0">{{ __('Recent Events with Meeting ID') }}</h6></div>
      <div class="card-body">
        <ul class="list-group">
          @forelse($recentEvents as $ev)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">#{{ $ev->id }} — {{ $ev->event->title ?? 'Event' }}</div>
                <small class="text-muted">Meeting ID: {{ $ev->meeting_id ?? '-' }}</small>
              </div>
              <a href="{{ route('churchly.attendance_events.edit', $ev->id) }}" class="btn btn-sm btn-outline-secondary">{{ __('Open') }}</a>
            </li>
          @empty
            <li class="list-group-item text-muted">{{ __('No recent events found.') }}</li>
          @endforelse
        </ul>
      </div>
    </div>
    <div class="card shadow-sm">
      <div class="card-header"><h6 class="mb-0">{{ __('Recent Participants') }}</h6></div>
      <div class="card-body">
        <div class="list-group">
          @forelse($recentParticipants as $p)
            <div class="list-group-item">
              <div class="fw-semibold">{{ $p->user_name }} <small class="text-muted">{{ $p->user_email }}</small></div>
              <small class="text-muted">{{ __('Join') }}: {{ optional($p->join_time)->toDateTimeString() }} • {{ __('Duration') }}: {{ $p->duration }}s</small>
            </div>
          @empty
            <div class="text-muted">{{ __('No participants synced yet.') }}</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

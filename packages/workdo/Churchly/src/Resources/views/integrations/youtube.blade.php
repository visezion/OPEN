@extends('layouts.main')

@section('page-title', __('YouTube Sync'))

@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard.church') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active">{{ __('YouTube Sync') }}</li>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header"><h5 class="mb-0">{{ __('Settings') }}</h5></div>
      <div class="card-body">
        <form method="POST" action="{{ route('churchly.youtube.save') }}">@csrf
          <div class="mb-3">
            <label class="form-label">{{ __('Channel ID') }}</label>
            <input type="text" class="form-control" name="channel_id" value="{{ old('channel_id',$setting->channel_id) }}" placeholder="UCxxxxxxxxxxx">
            <small class="text-muted">{{ __('You can also use Playlist ID instead.') }}</small>
          </div>
          <div class="mb-3">
            <label class="form-label">{{ __('Playlist ID (optional)') }}</label>
            <input type="text" class="form-control" name="playlist_id" value="{{ old('playlist_id',$setting->playlist_id) }}" placeholder="PLxxxxxxxxxxx">
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">{{ __('Mode') }}</label>
              <select class="form-select" name="mode">
                <option value="all" {{ ($setting->mode ?? 'all')==='all'?'selected':'' }}>{{ __('All videos') }}</option>
                <option value="live" {{ ($setting->mode ?? 'all')==='live'?'selected':'' }}>{{ __('Live videos only') }}</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">{{ __('Sync Interval') }}</label>
              <select class="form-select" name="interval_minutes">
                @foreach([5,15,30,60,120,360,720,1440] as $m)
                  <option value="{{ $m }}" {{ ($setting->interval_minutes ?? 60)==$m?'selected':'' }}>{{ $m<60 ? $m.' min' : ($m%1440==0 ? 'Daily' : ($m/60).' hr') }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="mb-3 mt-3">
            <label class="form-label">{{ __('YouTube API Key (optional)') }}</label>
            <input type="text" class="form-control" name="api_key" value="{{ old('api_key',$setting->api_key) }}" placeholder="AIza...">
            <small class="text-muted">{{ __('If empty, falls back to services.youtube.key') }}</small>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="active" value="1" {{ $setting->active ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('Enable Auto Sync') }}</label>
          </div>
          <button class="btn btn-primary">{{ __('Save Settings') }}</button>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ __('Recent Videos') }}</h5>
        <a href="{{ url('api/v1/churchly/youtube/videos') }}" target="_blank" class="btn btn-sm btn-outline-secondary">{{ __('Open API') }}</a>
      </div>
      <div class="card-body">
        <div class="list-group">
          @forelse($videos as $v)
            <a href="https://www.youtube.com/watch?v={{ $v->youtube_video_id }}" class="list-group-item list-group-item-action d-flex" target="_blank">
              <img src="{{ $v->thumbnail_url }}" class="me-2" alt="thumb" style="width:72px;height:40px;object-fit:cover;">
              <div>
                <div class="fw-semibold">{{ $v->title }}</div>
                <small class="text-muted">{{ optional($v->published_at)->diffForHumans() }} • {{ $v->live_broadcast_content ?: 'video' }}</small>
              </div>
            </a>
          @empty
            <div class="text-muted">{{ __('No videos synced yet.') }}</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


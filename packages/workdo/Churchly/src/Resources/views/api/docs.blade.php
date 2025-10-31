@extends('layouts.main')

@section('page-title')
    {{ __('Churchly API Docs') }}
@endsection

@section('page-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('API Docs') }}</li>
@endsection

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="mb-3">Overview</h5>
    <p>Churchly exposes simple REST APIs to power your mobile app. Use these endpoints to fetch branding, menus, layouts, and authenticated member data. All responses are JSON.</p>

    <h6 class="mt-4">Base URL</h6>
    <pre class="bg-light p-3 rounded small">{{ url('/') }}/api/v1/churchly</pre>

    <h5 class="mt-4">Authentication</h5>
    <p>Use the login endpoint to obtain a Sanctum token. Pass it as a Bearer token for protected routes.</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>curl -X POST "{{ url('/api/v1/churchly/login') }}" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "secret"
  }'
# => { "status":"success", "token": "&lt;SANCTUM_TOKEN&gt;" }</code></pre>

    <p class="mt-2">Include the token in requests:</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>-H "Authorization: Bearer &lt;SANCTUM_TOKEN&gt;"</code></pre>

    <h5 class="mt-4">Church Directory</h5>
    <p>List active churches/workspaces with IDs and short codes.</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>curl "{{ url('/api/v1/churchly/churches') }}"
# => [ { "id": 1, "name": "City Church", "short_code": "city" }, ... ]</code></pre>

    <h5 class="mt-4">App Config (Public)</h5>
    <p>Fetch complete runtime configuration for a church by numeric ID or short_code. Uses ETag for caching.</p>
    <pre class="bg-dark text-white p-3 rounded small"><code># By short code
curl "{{ url('/api/v1/churchly/church/demo/config') }}"

# With ETag caching
curl "{{ url('/api/v1/churchly/church/demo/config') }}" \
  -H "If-None-Match: W/\"&lt;PREVIOUS_MD5&gt;\""</code></pre>

    <h6 class="mt-2">Sample response (trimmed)</h6>
    <pre class="bg-light p-3 rounded small"><code>{
  "status": "success",
  "data": {
    "workspace_id": 12,
    "app_name": "City Church",
    "primary_color": "#4A6CF7",
    "accent_color": "#F9B200",
    "theme_mode": "system",
    "logo_url": "https://.../logo.png",
    "features": ["sermons","events","giving"],
    "menu": [
      {"title":"Home","feature_key":"home","icon_name":"ti ti-home","target_type":"feature"}
    ],
    "publish": {"release_channel":"multi_tenant","current_version":"1.0.0"},
    "home": {
      "screen_key":"home",
      "title":"Home",
      "widgets":[{"type":"banner_carousel","title":"Featured","settings":{"height":200}}]
    }
  }
}</code></pre>

    <h5 class="mt-4">Theme</h5>
    <div class="row">
      <div class="col-md-6">
        <p>Get current theme (public):</p>
        <pre class="bg-dark text-white p-3 rounded small"><code>curl "{{ url('/api/v1/churchly/theme') }}"</code></pre>
      </div>
      <div class="col-md-6">
        <p>Update theme (requires Bearer token):</p>
        <pre class="bg-dark text-white p-3 rounded small"><code>curl -X PUT "{{ url('/api/v1/churchly/theme') }}" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer &lt;SANCTUM_TOKEN&gt;" \
  -d '{
    "primary_color": "#4A6CF7",
    "secondary_color": "#F9B200",
    "font_family": "Inter",
    "theme_mode": "light"
  }'</code></pre>
      </div>
    </div>

    <h5 class="mt-4">Layouts</h5>
    <p>Fetch active layouts and get a layout by screen key (e.g., home). These reflect what admins configure in App Builder.</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>curl "{{ url('/api/v1/churchly/layouts') }}"
curl "{{ url('/api/v1/churchly/layout/home') }}"</code></pre>

    <h5 class="mt-4">Members</h5>
    <p>All member endpoints require a Bearer token.</p>
    <pre class="bg-dark text-white p-3 rounded small"><code># List members
curl "{{ url('/api/v1/churchly/members') }}" -H "Authorization: Bearer &lt;SANCTUM_TOKEN&gt;"

# Update my profile
curl -X PUT "{{ url('/api/v1/churchly/member/profile') }}" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer &lt;SANCTUM_TOKEN&gt;" \
  -d '{ "first_name":"John", "last_name":"Doe" }'</code></pre>

    <h5 class="mt-4">GPS Self Attendance</h5>
    <p>Members can check-in only within the event radius. Coordinates are rounded for privacy.</p>
    <p class="mb-1"><strong>Endpoint</strong>: <code>POST /api/v1/churchly/attendance/gps-checkin</code></p>
    <p class="mb-1"><strong>Auth</strong>: Sanctum token required</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>curl -X POST \
  -H "Authorization: Bearer &lt;SANCTUM_TOKEN&gt;" \
  -H "Content-Type: application/json" \
  -d '{
    "event_id": 123,
    "latitude": 6.5244,
    "longitude": 3.3792,
    "platform": "mobile"
  }' \
  "{{ url('/api/v1/churchly/attendance/gps-checkin') }}"</code></pre>
    <p class="mb-1"><strong>Success</strong>:</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>{
  "status":"success",
  "message":"Attendance marked successfully",
  "distance": 45.6
}</code></pre>
    <p class="mb-1"><strong>Failure</strong>:</p>
    <pre class="bg-dark text-white p-3 rounded small"><code>{
  "status":"error",
  "message":"You are 230 meters away from the event venue",
  "distance": 230.1
}</code></pre>

    <h5 class="mt-4">Notes</h5>
    <ul>
      <li>All endpoints return standard JSON with a <code>status</code> field and <code>data</code> payload.</li>
      <li>For multi-tenant apps, prefer <code>/church/{short_code}/config</code> for runtime configuration.</li>
      <li>FlutterFlow should cache with ETag and only refresh when changed.</li>
    </ul>
  </div>
</div>
@endsection

@push('css')
<style>
pre { white-space: pre-wrap; }
</style>
@endpush

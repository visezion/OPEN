@extends('layouts.main')

@section('page-title', __('Google Integration'))

@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active">{{ __('Google Integration') }}</li>
@endsection

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h5>{{ __('Workspace Google OAuth Credentials') }}</h5>
    <form method="POST" action="{{ route('churchly.google.credentials.save') }}" class="mb-4">
      @csrf
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Client ID</label>
          <input type="text" name="client_id" class="form-control" value="{{ old('client_id', $cred->client_id ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Client Secret</label>
          <input type="text" name="client_secret" class="form-control" value="{{ old('client_secret', $cred->client_secret ?? '') }}" required>
        </div>
        <div class="col-md-8 mb-3">
          <label class="form-label">Redirect URI</label>
          <input type="url" name="redirect_uri" class="form-control" value="{{ old('redirect_uri', $cred->redirect_uri ?? url('/api/v1/churchly/auth/google/callback')) }}" required>
          <small class="text-muted">{{ __('Set this in Google Cloud console. You can use the API callback above or a custom web callback.') }}</small>
        </div>
        <div class="col-md-4 mb-3 d-flex align-items-end">
          <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" name="active" value="1" {{ ($cred->active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">{{ __('Active') }}</label>
          </div>
        </div>
      </div>
      <div class="text-end">
        <button class="btn btn-primary">{{ __('Save Credentials') }}</button>
      </div>
    </form>

    <h6 class="mt-4">{{ __('Connect Your Google Account') }}</h6>
    <p class="text-muted">{{ __('Connect to capture a refresh token to access Classroom (and later Drive/Calendar).') }}</p>
    <a href="{{ route('churchly.google.connect') }}" class="btn btn-outline-primary">
      <i class="ti ti-brand-google"></i> {{ __('Connect Google') }}
    </a>

    <hr>
    <div class="small text-muted">
      <strong>{{ __('Scopes currently requested') }}:</strong>
      <code>openid profile email classroom.courses.readonly classroom.rosters</code>
      <br>
      {{ __('When Drive/Calendar are enabled later, users will be prompted to re-authorize.') }}
    </div>
  </div>
</div>
@endsection
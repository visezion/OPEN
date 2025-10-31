@extends('layouts.main')

@section('page-title', __('App Publish Settings'))

@section('page-breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('app-builder.index') }}">{{ __('App Builder') }}</a></li>
<li class="breadcrumb-item active">{{ __('Publish') }}</li>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('app-builder.publish.save') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Release Channel') }}</label>
                    <select name="release_channel" class="form-control">
                        <option value="multi_tenant" {{ ($publish->release_channel ?? '') == 'multi_tenant' ? 'selected' : '' }}>Use Multi-Church App</option>
                        <option value="white_label" {{ ($publish->release_channel ?? '') == 'white_label' ? 'selected' : '' }}>Publish Own App</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('Current Version') }}</label>
                    <input type="text" name="current_version" class="form-control" value="{{ $publish->current_version ?? '' }}">
                </div>
            </div>

            <div class="text-end mt-3">
                <button class="btn btn-primary">{{ __('Save Publish Settings') }}</button>
            </div>
        </form>

        <hr>
        <p class="mt-3 text-muted small">
            {{ __('In future updates, this screen will allow you to connect your Google Play and Apple Developer accounts and deploy your white-label app directly from Churchly.') }}
        </p>
    </div>
</div>
@endsection

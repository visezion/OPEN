@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.welcome.title'))
@section('container')
    <p class="update-copy">
        {{ trans('installer_messages.updater.welcome.message') }}
    </p>
    <div class="update-actions">
        <a href="{{ route('LaravelUpdater::overview') }}" class="update-btn primary">{{ trans('installer_messages.next') }}</a>
        <a href="{{ url('/') }}" class="update-btn secondary">{{ __('Back to Home') }}</a>
    </div>
@stop

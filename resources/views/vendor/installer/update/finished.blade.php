@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.final.title'))
@section('container')
    <p class="update-copy">
        {{ isset(session('message')['message']) ? session('message')['message'] : __('Update process completed successfully.') }}
    </p>
    <div class="update-actions">
        <a href="{{ url('/') }}" class="update-btn primary">{{ trans('installer_messages.updater.final.exit') }}</a>
        <a href="{{ route('LaravelUpdater::overview') }}" class="update-btn secondary">{{ __('Review Updates') }}</a>
    </div>
@stop

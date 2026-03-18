@extends('vendor.installer.layouts.master-update')

@section('title', trans('installer_messages.updater.overview.title'))
@section('container')
    <p class="update-copy">
        {{ trans_choice('installer_messages.updater.overview.message', $numberOfUpdatesPending, ['number' => $numberOfUpdatesPending]) }}
    </p>
    <div class="update-stat">
        <span class="update-stat-value">{{ $numberOfUpdatesPending }}</span>
        <span class="update-stat-label">{{ __('Pending updates detected') }}</span>
    </div>
    <div class="update-actions">
        <a href="{{ route('LaravelUpdater::database') }}" class="update-btn primary">{{ trans('installer_messages.updater.overview.install_updates') }}</a>
        <a href="{{ route('LaravelUpdater::welcome') }}" class="update-btn secondary">{{ __('Back') }}</a>
    </div>
@stop

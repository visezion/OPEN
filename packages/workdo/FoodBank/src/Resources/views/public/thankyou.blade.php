@extends('foodbank::public.layout')

@section('title', __('Thank you'))
@section('content')
    <div class="note mb-3">
        <h2>{{ __('Thank you!') }}</h2>
        <p class="text-muted">
            {{ $mode === 'donation' ? __('Your generosity has been recorded and we will coordinate pickup within 24 hours.') : __('Your request is now in the queue and we will reach out soon with the next steps.') }}
        </p>
    </div>
    <div class="grid">
        <div class="field">
            <label>{{ __('Share link') }}</label>
            <input type="text" readonly value="{{ $mode === 'request' ? route('foodbank.public.request', ['token' => $token]) : route('foodbank.public.donate', ['token' => $token]) }}">
        </div>
        <div class="field">
            <label>{{ __('Back to') }}</label>
            <a class="btn-wide" href="{{ $mode === 'request' ? route('foodbank.public.request', ['token' => $token]) : route('foodbank.public.donate', ['token' => $token]) }}">
                {{ $mode === 'request' ? __('Submit another request') : __('Record another donation') }}
            </a>
        </div>
    </div>
@endsection

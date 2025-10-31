@extends('layouts.main')

@push('head')

@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div style="line-height: 2.5 !important;" class="card-body church-timer-guide">

            <div class="text-center mb-4">
                <h1 class="fw-bold" style="font-size: 1.8rem;">📖 {{ __('Church Program Timer') }}</h1>
                <p class="text-muted mb-0">{{ __('User-friendly guide to managing your live church programs efficiently.') }}</p>
            </div>

            <hr class="my-4">

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🚀 {{ __('Overview') }}</h4>
                <p>{{ __('The Church Program Timer helps churches maintain service order with an interactive countdown system ensuring timely transitions between segments. It provides:') }}</p>
                <ul class="list-unstyled ms-3">
                    <li>⏳ <strong>{{ __('Live circular countdown timer') }}</strong></li>
                    <li>⚠️ <strong>{{ __('TIME UP!!! alerts at 45 seconds remaining') }}</strong></li>
                    <li>🛎️ <strong>{{ __('“KINDLY EXIT THE STAGE !!!” reminders (optional)') }}</strong></li>
                    <li>🎥 <strong>{{ __('Monitor View for projection screens') }}</strong></li>
                    <li>💾 <strong>{{ __('Easy schedule save/load functionality') }}</strong></li>
                    <li>⛓️ <strong>{{ __('Auto-transition between program segments') }}</strong></li>
                </ul>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🛠️ {{ __('Using the Timer') }}</h4>
                <ol class="ms-3">
                    <li><strong>{{ __('Load or Add Programs:') }}</strong> {{ __('Use "Load Schedule" for predefined segments or "Add Program" for custom entries.') }}</li>
                    <li><strong>{{ __('Edit Details:') }}</strong> {{ __('Set the name, time, duration, and optionally enable "Exit Stage" reminders for each program.') }}</li>
                    <li><strong>{{ __('Start Countdown:') }}</strong> {{ __('Press ▶️ next to a program to begin its timer.') }}</li>
                    <li><strong>{{ __('Monitor View:') }}</strong> {{ __('Click "Open Monitor View" for projection on stage screens.') }}</li>
                    <li><strong>{{ __('Save/Load:') }}</strong> {{ __('Save frequently used schedules for quick loading.') }}</li>
                    <li><strong>{{ __('Auto-Start:') }}</strong> {{ __('Enable for automatic transitions between programs.') }}</li>
                </ol>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">💡 {{ __('Features') }}</h4>
                <div class="row">
                    <div class="col-md-6 mb-2"><span class="badge bg-success">LIVE</span> {{ __('Circular visual timer ring for presenters and audience.') }}</div>
                    <div class="col-md-6 mb-2"><span class="badge bg-warning text-dark">ALERT</span> {{ __('“TIME UP!!!” alert at 45 seconds remaining.') }}</div>
                    <div class="col-md-6 mb-2"><span class="badge bg-info">OPTIONAL</span> {{ __('“KINDLY EXIT THE STAGE !!!” reminders for smooth transitions.') }}</div>
                    <div class="col-md-6 mb-2"><span class="badge bg-primary">MONITOR</span> {{ __('Projection-friendly display for stage or overflow rooms.') }}</div>
                    <div class="col-md-6 mb-2"><span class="badge bg-secondary">AUTO</span> {{ __('Auto-start next program for seamless flow.') }}</div>
                </div>
            </div>

            <div class="mb-5">
                <h4 class="fw-semibold mb-3">🎯 {{ __('Best Practices') }}</h4>
                <ul class="ms-3">
                    <li>✅ {{ __('Test your schedule before live use to align with your service plan.') }}</li>
                    <li>✅ {{ __('Use Monitor View for clear stage and audience visibility.') }}</li>
                    <li>✅ {{ __('Save frequently used schedules for efficient preparation.') }}</li>
                    <li>✅ {{ __('Enable Auto-Start for stress-free transitions.') }}</li>
                </ul>
            </div>
         
                <a href="{{ route('timer.church') }}" class="btn btn-dark">
                    You have invested your time in leaning how to use the timer NOW LET GET STARTED</b>
                </a>  <br>  <br>
        
            <div class="mb-5">
                <h4 class="fw-semibold mb-3">📞 {{ __('Support & Customization') }}</h4>
                <p>{{ __('Need enhancements like sound alerts, color flash warnings, or remote control features? Contact your system administrator or developer to customize the Church Program Timer for your workflow needs.') }}</p>
            </div>
            
            <div class="text-center text-muted small">
                {{ __('Church Program Timer © 2025 | Helping your services flow with clarity and excellence.') }}
            </div>

        </div>
    </div>
</div>

@endsection

@extends('layouts.main')

@section('page-title', __('Setup Attendance Event'))

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css') }}">
@endpush

@section('page-action')
    <a href="{{ route('churchmeet.events.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-calendar"></i> {{ __('View All Events/Meetings') }}
    </a>
    <a href="{{ route('churchmeet.attendance_events.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> {{ __('View All Attendance Events') }}
    </a>
@endsection

@section('content')
@php
    $selectedOccurrenceValue = old('occurrence_id', $selectedOccurrenceId ?? null);
    $upcomingOccurrences = $occurrences->filter(function ($occurrence) {
        return !$occurrence->is_past;
    });
    $pastOccurrences = $occurrences->filter(function ($occurrence) {
        return $occurrence->is_past;
    });
@endphp
<div class="row attendance-events-create">
    {{-- Left Column: Form --}}
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-clipboard-check text-primary"></i> {{ __('Create Attendance Event') }}
                </h5>
                <small class="text-muted">
                    {{ __('Link attendance tracking to an existing event and configure the attendance process.') }}
                </small>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-info border-start border-4 border-info shadow-sm mb-4">
                    <strong><i class="ti ti-info-circle"></i> {{ __('Attendance Flow') }}:</strong>
                    {{ __('You can attach attendance to both upcoming and past event dates. If an attendance session already exists for the selected occurrence, ChurchMeet will reopen that same session automatically so records stay in one place.') }}
                </div>

                <form method="POST" action="{{ route('churchmeet.attendance_events.store') }}">
                    @csrf

                    {{-- Select Occurrence --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> {{ __('Select Event Date') }}
                        </label>
                        <select name="occurrence_id" class="form-select" required>
                            <option value="" disabled {{ empty($selectedOccurrenceValue) ? 'selected' : '' }}>{{ __('-- Choose an Event Date --') }}</option>
                            @if($upcomingOccurrences->isNotEmpty())
                                <optgroup label="{{ __('Upcoming Dates') }}">
                                    @foreach($upcomingOccurrences as $occurrence)
                                        <option value="{{ $occurrence->id }}" {{ (string) $selectedOccurrenceValue === (string) $occurrence->id ? 'selected' : '' }}>
                                            {{ $occurrence->title }} ({{ $occurrence->date_label }})
                                            {{ $occurrence->has_session ? ' - ' . __('Attendance already linked') : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if($pastOccurrences->isNotEmpty())
                                <optgroup label="{{ __('Past Dates') }}">
                                    @foreach($pastOccurrences as $occurrence)
                                        <option value="{{ $occurrence->id }}" {{ (string) $selectedOccurrenceValue === (string) $occurrence->id ? 'selected' : '' }}>
                                            {{ $occurrence->title }} ({{ $occurrence->date_label }})
                                            {{ $occurrence->has_session ? ' - ' . __('Attendance already linked') : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                        <small class="text-muted d-block mt-1">
                            {{ __('The attendance session will be linked to one dated occurrence of the event. Past dates are allowed, and existing attendance sessions are reused automatically.') }}
                        </small>
                    </div>

                    {{-- Mode & Auto Log Toggle --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-building-church text-success"></i> {{ __('Mode of Attendance') }}
                            </label>
                            <select name="mode" id="mode-selector" class="form-select" required>
                                <option value="onsite">{{ __('Onsite') }}</option>
                                <option value="online">{{ __('Online') }}</option>
                                <option value="hybrid">{{ __('Hybrid') }}</option>
                            </select>
                            <small class="text-muted d-block mt-1">
                                {{ __('Define how participants will attend this event.') }}
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold d-block">
                                <i class="ti ti-activity text-warning"></i> {{ __('Auto Attendance Logging') }}
                            </label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance">
                                <label for="auto_log_attendance" class="form-check-label">{{ __('Enable Auto Logging') }}</label>
                            </div>
                            <small class="text-muted d-block mt-1">
                                {{ __('Automatically record attendance for Zoom/YouTube integrations.') }}
                            </small>
                        </div>
                    </div>

                    {{-- Attendance Methods --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-checks text-info"></i> {{ __('Enabled Attendance Methods') }}
                        </label>
                       
                        <div class="row g-3">
                            @php
                                $methods = [
                                    ['manual', 'Manual Check-in', 'ti-user-check'],
                                    ['qr', 'QR Code Scanning', 'ti-qrcode'],
                                    ['kiosk', 'Kiosk Self Check-in', 'ti-device-ipad'],
                                    ['face_ai', 'Face AI Detection', 'ti-camera'],
                                    ['zoom', 'Zoom Attendance Sync', 'ti-video'],
                                    ['youtube', 'YouTube Live Tracking', 'ti-brand-youtube']
                                ];
                            @endphp

                            @foreach($methods as [$value, $label, $icon])
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="{{ $value }}" id="method-{{ $value }}" class="form-check-input">
                                        <label for="method-{{ $value }}" class="form-check-label d-flex align-items-center">
                                            <i class="ti {{ $icon }} text-primary me-2"></i> {{ __($label) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-2">
                            {{ __('Multiple methods can be enabled simultaneously for flexibility.') }}
                        </small>
                    </div>

                    {{-- Online Config --}}
                    <div id="online-config" class="mb-4 churchmeet-hidden">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> {{ __('Online Configuration (Optional)') }}
                        </label>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="online_platform" placeholder="{{ __('Platform (e.g., Zoom, YouTube)') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_link" placeholder="{{ __('Meeting/Stream Link') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_id" placeholder="{{ __('Meeting ID (Zoom)') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_passcode" placeholder="{{ __('Passcode (Zoom)') }}" class="form-control">
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">
                            {{ __('Only required for Online or Hybrid modes.') }}
                        </small>
                    </div>

                    {{-- Check-in Window (optional) --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-4 text-secondary"></i> {{ __('Check-in Opens At') }}
                            </label>
                            <input type="datetime-local" name="checkin_start_at" class="form-control" value="{{ old('checkin_start_at') }}">
                            <small class="text-muted">{{ __('Optional time window start for check-in') }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-12 text-secondary"></i> {{ __('Check-in Closes At') }}
                            </label>
                            <input type="datetime-local" name="checkin_end_at" class="form-control" value="{{ old('checkin_end_at') }}">
                            <small class="text-muted">{{ __('Optional time window end for check-in') }}</small>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="ti ti-device-floppy"></i> {{ __('Save Attendance Event') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Setup Tips --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white py-2">
                <h5 class="mb-0">
                    <i class="ti ti-bulb"></i> {{ __('Setup Tips & Guidance') }}
                </h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2">{{ __('How to Configure:') }}</p>
                <ul class="ps-3 mb-3">
                    <li><strong>{{ __('Select Event Date:') }}</strong> Choose the exact recurring date you want attendance to track.</li>
                    <li><strong>{{ __('Mode:') }}</strong> Choose onsite, online, or hybrid attendance type.</li>
                    <li><strong>{{ __('Methods:') }}</strong> Decide how members will check in (QR, Face AI, etc.).</li>
                    <li><strong>{{ __('Online Config:') }}</strong> Add Zoom/YouTube details for live streaming.</li>
                    <li><strong>{{ __('Auto Logging:') }}</strong> Use for automatic presence detection.</li>
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2">{{ __('Best Practices:') }}</p>
                <ul class="ps-3 mb-0">
                    <li>Keep method selection minimal for clarity.</li>
                    <li>Hybrid events offer maximum engagement.</li>
                    <li>Test AI/QR methods before the event starts.</li>
                    <li>Securely share meeting links only with verified members.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Script to toggle online config --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineConfig = document.getElementById('online-config');

    function toggleOnlineSection() {
        const val = modeSelector.value;
        onlineConfig.style.display = (val === 'online' || val === 'hybrid') ? 'block' : 'none';
    }

    modeSelector.addEventListener('change', toggleOnlineSection);
    toggleOnlineSection(); // initialize on load
});
</script>
@endpush
@endsection


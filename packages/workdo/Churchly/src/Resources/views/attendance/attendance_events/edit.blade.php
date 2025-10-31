@extends('layouts.main')

@section('page-title', __('Edit Attendance Event'))

@section('page-action')
    <a href="{{ route('churchly.attendance_events.create') }}" class="btn btn-sm btn-outline-success">
        <i class="ti ti-plus"></i> {{ __('Create New Attendance Event') }}
    </a>
    <a href="{{ route('churchly.attendance_events.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> {{ __('View All Attendance Events') }}
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Left Column: Form --}}
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-edit text-primary"></i> {{ __('Edit Attendance Event') }}
                </h5>
                <small class="text-muted">
                    {{ __('Modify the event linkage, attendance mode, or online configurations. Changes apply immediately after saving.') }}
                </small>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('churchly.attendance_events.update', $attendanceEvent->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Select Event --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> {{ __('Linked Event') }}
                        </label>
                        <select disabled name="event_id" class="form-select" required>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}"
                                    {{ $attendanceEvent->event_id == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} ({{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }})
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">
                            {{ __('The event to which attendance tracking is linked.') }}
                        </small>
                    </div>

                    {{-- Mode Selection --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-building-church text-success"></i> {{ __('Mode') }}
                            </label>
                            <select name="mode" class="form-select" id="mode-selector">
                                <option value="onsite" {{ $attendanceEvent->mode == 'onsite' ? 'selected' : '' }}>Onsite</option>
                                <option value="online" {{ $attendanceEvent->mode == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="hybrid" {{ $attendanceEvent->mode == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            <small class="text-muted d-block mt-1">
                                {{ __('Switch between onsite, online, or hybrid formats.') }}
                            </small>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-world text-info"></i> {{ __('Online Platform (Optional)') }}
                            </label>
                            <input type="text" name="online_platform" value="{{ old('online_platform', $attendanceEvent->online_platform) }}"
                                   class="form-control" placeholder="{{ __('e.g., Zoom, YouTube, or Church App') }}">
                            <small class="text-muted">{{ __('Only relevant for online or hybrid modes.') }}</small>
                        </div>
                    </div>

                    {{-- Enabled Methods --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-checks text-info"></i> {{ __('Enabled Attendance Methods') }}
                        </label>
                        @php
                            $enabled = is_array($attendanceEvent->enabled_methods)
                                ? $attendanceEvent->enabled_methods
                                : json_decode($attendanceEvent->enabled_methods, true);
                        @endphp

                        <div class="row">
                            <div class="col-md-6">
                                @foreach(['manual' => 'Manual', 'qr' => 'QR Code', 'kiosk' => 'Kiosk (Self Check-in)'] as $value => $label)
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="{{ $value }}"
                                               id="method-{{ $value }}" class="form-check-input"
                                               {{ in_array($value, $enabled ?? []) ? 'checked' : '' }}>
                                        <label for="method-{{ $value }}" class="form-check-label">{{ __($label) }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="col-md-6">
                                @foreach(['face_ai' => 'Face AI Detection', 'zoom' => 'Zoom Integration', 'youtube' => 'YouTube Live Tracking'] as $value => $label)
                                    <div class="form-check">
                                        <input type="checkbox" name="enabled_methods[]" value="{{ $value }}"
                                               id="method-{{ $value }}" class="form-check-input"
                                               {{ in_array($value, $enabled ?? []) ? 'checked' : '' }}>
                                        <label for="method-{{ $value }}" class="form-check-label">{{ __($label) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">
                            {{ __('Select multiple methods if needed. Members can use any of the enabled methods to check in.') }}
                        </small>
                    </div>

                    {{-- Online Config --}}
                    <div id="online-config" class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> {{ __('Online Configuration') }}
                        </label>
                        <input type="text" name="meeting_link" placeholder="{{ __('Meeting/Stream Link') }}"
                               class="form-control mb-2" value="{{ old('meeting_link', $attendanceEvent->meeting_link) }}">
                        <input type="text" name="meeting_id" placeholder="{{ __('Meeting ID (Zoom)') }}"
                               class="form-control mb-2" value="{{ old('meeting_id', $attendanceEvent->meeting_id) }}">
                        <input type="text" name="meeting_passcode" placeholder="{{ __('Passcode (Zoom)') }}"
                               class="form-control" value="{{ old('meeting_passcode', $attendanceEvent->meeting_passcode) }}">
                        <small class="text-muted d-block mt-1">
                            {{ __('Only required if you’re using Online or Hybrid mode.') }}
                        </small>
                    </div>

                    {{-- Check-in Window (optional) --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-4 text-secondary"></i> {{ __('Check-in Opens At') }}
                            </label>
                            <input type="datetime-local" name="checkin_start_at" class="form-control"
                                   value="{{ old('checkin_start_at', $attendanceEvent->checkin_start_at ? date('Y-m-d\TH:i', strtotime($attendanceEvent->checkin_start_at)) : '') }}">
                            <small class="text-muted">{{ __('Optional time window start for check-in') }}</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-clock-hour-12 text-secondary"></i> {{ __('Check-in Closes At') }}
                            </label>
                            <input type="datetime-local" name="checkin_end_at" class="form-control"
                                   value="{{ old('checkin_end_at', $attendanceEvent->checkin_end_at ? date('Y-m-d\TH:i', strtotime($attendanceEvent->checkin_end_at)) : '') }}">
                            <small class="text-muted">{{ __('Optional time window end for check-in') }}</small>
                        </div>
                    </div>

                    {{-- Auto Log Attendance --}}
                    <div class="form-check form-switch mb-4">
                        <input type="checkbox" class="form-check-input" name="auto_log_attendance" id="auto_log_attendance"
                               {{ $attendanceEvent->auto_log_attendance ? 'checked' : '' }}>
                        <label for="auto_log_attendance" class="form-check-label fw-semibold">
                            <i class="ti ti-activity text-warning"></i> {{ __('Enable Auto Attendance Logging') }}
                        </label>
                        <small class="text-muted d-block mt-1">
                            {{ __('Automatically record check-ins for connected digital platforms (Zoom, YouTube, etc.).') }}
                        </small>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy"></i> {{ __('Update Attendance Event') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Guidance --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white py-2">
                <h5 class="mb-0">
                    <i class="ti ti-bulb"></i> {{ __('Edit Tips & Guidance') }}
                </h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2">{{ __('What You Can Update:') }}</p>
                <ul class="ps-3 mb-3">
                    <li><strong>{{ __('Linked Event:') }}</strong> Reassign to another event if needed.</li>
                    <li><strong>{{ __('Mode:') }}</strong> Change between onsite, online, or hybrid.</li>
                    <li><strong>{{ __('Methods:') }}</strong> Enable or disable different check-in methods.</li>
                    <li><strong>{{ __('Auto Logging:') }}</strong> Toggle automatic attendance tracking.</li>
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2">{{ __('Helpful Notes:') }}</p>
                <ul class="ps-3 mb-0">
                    <li>Hybrid mode requires both onsite and online configurations.</li>
                    <li>Zoom/YouTube fields are ignored if mode is onsite only.</li>
                    <li>Keep meeting links private for security reasons.</li>
                    <li>Use auto logging only if event integrations are stable.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Optional JS to toggle online section --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineSection = document.getElementById('online-config');

    function toggleOnlineSection() {
        const value = modeSelector.value;
        onlineSection.style.display = (value === 'online' || value === 'hybrid') ? 'block' : 'none';
    }

    modeSelector.addEventListener('change', toggleOnlineSection);
    toggleOnlineSection(); // Initialize on load
});
</script>
@endpush
@endsection

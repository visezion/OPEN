@extends('layouts.main')

@section('page-title', __('Edit Event'))

@section('page-action')
    <a href="{{ route('churchmeet.events.create') }}" class="btn btn-sm btn-outline-success">
        <i class="ti ti-plus"></i> {{ __('Create New Event') }}
    </a>
    <a href="{{ route('churchmeet.events.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="ti ti-list-details"></i> {{ __('View All Events') }}
    </a>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
@php
    $currentPlatform = old('online_platform', optional($attendanceEvent)->online_platform ?: ($zoomSetting->preferred_platform ?: 'jitsi'));
    $currentMeetingLink = old('meeting_link', optional($attendanceEvent)->meeting_link);
    $currentJitsiDomain = old('jitsi_domain');

    if (!$currentJitsiDomain && $currentPlatform === 'jitsi' && !empty($currentMeetingLink)) {
        $currentJitsiDomain = parse_url($currentMeetingLink, PHP_URL_HOST) ?: preg_replace('#^https?://#i', '', (string) $currentMeetingLink);
        $currentJitsiDomain = strtok((string) $currentJitsiDomain, '/');
    }

    if (!$currentJitsiDomain) {
        $currentJitsiDomain = $zoomSetting->jitsi_server_domain ?: 'meet.jit.si';
    }
@endphp
<div class="row">
    {{-- Left Column: Form --}}
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="fw-bold mb-0">
                    <i class="ti ti-edit text-primary"></i> {{ __('Edit Event Details') }}
                </h5>
                <small class="text-muted">
                    {{ __('Modify the event information, timing, or program schedule. Changes apply immediately after saving.') }}
                </small>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('churchmeet.events.update', $event->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-calendar-event text-primary"></i> {{ __('Event Title') }}
                        </label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="form-control" required>
                    </div>

                    {{-- Event Type & Mode --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-category text-success"></i> {{ __('Event Type') }}
                            </label>
                            <input type="text" name="event_type" value="{{ old('event_type', $event->event_type) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="ti ti-switch-horizontal text-info"></i> {{ __('Mode') }}
                            </label>
                            <select name="mode" class="form-select" required>
                                <option value="onsite" {{ optional($attendanceEvent)->mode == 'onsite' ? 'selected' : '' }}>Onsite</option>
                                <option value="online" {{ optional($attendanceEvent)->mode == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="hybrid" {{ optional($attendanceEvent)->mode == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                    </div>

                    {{-- Date & Venue --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-clock-hour-8 text-warning"></i> {{ __('Start Time') }}</label>
                            <input type="datetime-local" name="start_time" value="{{ old('start_time', $event->start_time ? date('Y-m-d\TH:i', strtotime($event->start_time)) : '') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-clock-hour-12 text-danger"></i> {{ __('End Time') }}</label>
                            <input type="datetime-local" name="end_time" value="{{ old('end_time', $event->end_time ? date('Y-m-d\TH:i', strtotime($event->end_time)) : '') }}" class="form-control">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label fw-semibold"><i class="ti ti-map-pin text-secondary"></i> {{ __('Venue / Location') }}</label>
                            <input type="text" name="venue" class="form-control" value="{{ old('venue', $event->venue) }}" placeholder="{{ __('Enter venue or meeting link') }}">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">{{ __('Branch') }}</label>
                            <select class="form-select" name="branch_id" id="branch_id">
                                <option value="">{{ __('Select Branch') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id', optional($attendanceEvent)->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">{{ __('Department') }}</label>
                            <select class="form-select" name="department_id" id="department_id">
                                <option value="">{{ __('Select Department') }}</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"
                                            data-branch-id="{{ $department->branch_id }}"
                                            {{ old('department_id', optional($attendanceEvent)->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- GPS Location for Self Attendance (optional) --}}
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0001" class="form-control" name="latitude" value="{{ old('latitude', $event->latitude) }}" placeholder="e.g., 6.5244">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0001" class="form-control" name="longitude" value="{{ old('longitude', $event->longitude) }}" placeholder="e.g., 3.3792">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label class="form-label">Radius (meters)</label>
                            <input type="number" min="1" class="form-control" name="radius_meters" value="{{ old('radius_meters', $event->radius_meters ?? 100) }}">
                        </div>
                    </div>

                    {{-- Recurrence --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-repeat text-primary"></i> {{ __('Recurrence') }}</label>
                        <select name="recurrence" class="form-select">
                            <option value="none" {{ $event->recurrence == 'none' ? 'selected' : '' }}>None</option>
                            <option value="daily" {{ $event->recurrence == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $event->recurrence == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $event->recurrence == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                    </div>

                    {{-- Leaders --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-user-star text-info"></i> {{ __('Lead Minister') }}</label>
                            <select name="lead_id" class="form-select member-select">
                                <option value="">-- Select Lead Minister --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ $event->lead_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="ti ti-user-plus text-success"></i> {{ __('Assistant / Co-Leader') }}</label>
                            <select name="assistant_id" class="form-select member-select">
                                <option value="">-- Select Assistant --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ $event->assistant_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-align-left text-secondary"></i> {{ __('Description') }}</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="{{ __('Write a brief description of the event...') }}">{{ old('description', $event->description) }}</textarea>
                    </div>

                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-1">{{ __('Online Meeting') }}</h6>
                                    <small class="text-muted">{{ __('Create or update Zoom, Jitsi, or LiveKit meeting details members will join from OPEN.') }}</small>
                                </div>
                                @if($currentPlatform === 'livekit' ? !empty(optional($attendanceEvent)->meeting_id) : (optional($attendanceEvent)->meeting_id || optional($attendanceEvent)->meeting_link))
                                    <a href="{{ route('churchmeet.meetings.join', $attendanceEvent->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-video"></i> {{ __('Open Join Room') }}
                                    </a>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Online Platform') }}</label>
                                    <select name="online_platform" id="online_platform" class="form-select">
                                        <option value="">{{ __('Select Online Platform') }}</option>
                                        <option value="zoom" {{ old('online_platform', optional($attendanceEvent)->online_platform) === 'zoom' ? 'selected' : '' }}>{{ __('Zoom') }}</option>
                                        <option value="jitsi" {{ old('online_platform', optional($attendanceEvent)->online_platform) === 'jitsi' ? 'selected' : '' }}>{{ __('Jitsi Meet') }}</option>
                                        <option value="livekit" {{ old('online_platform', optional($attendanceEvent)->online_platform) === 'livekit' ? 'selected' : '' }}>{{ __('LiveKit') }}</option>
                                        <option value="youtube" {{ old('online_platform', optional($attendanceEvent)->online_platform) === 'youtube' ? 'selected' : '' }}>{{ __('YouTube') }}</option>
                                        <option value="custom" {{ old('online_platform', optional($attendanceEvent)->online_platform) === 'custom' ? 'selected' : '' }}>{{ __('Custom Link') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Meeting Link') }}</label>
                                    <input type="text" name="meeting_link" class="form-control" value="{{ old('meeting_link', optional($attendanceEvent)->meeting_link) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Meeting ID / Jitsi Room') }}</label>
                                    <input type="text" name="meeting_id" class="form-control" value="{{ old('meeting_id', optional($attendanceEvent)->meeting_id) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{ __('Passcode (Zoom only)') }}</label>
                                    <input type="text" name="meeting_passcode" class="form-control" value="{{ old('meeting_passcode', optional($attendanceEvent)->meeting_passcode) }}">
                                </div>
                                <div class="col-md-6" id="jitsi-domain-wrap">
                                    <label class="form-label">{{ __('Jitsi Domain') }}</label>
                                    <input type="text" id="jitsi_domain" name="jitsi_domain" class="form-control" value="{{ $currentJitsiDomain }}" placeholder="meet.jit.si">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance" value="1" {{ old('auto_log_attendance', optional($attendanceEvent)->auto_log_attendance) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auto_log_attendance">{{ __('Auto attendance logging') }}</label>
                                </div>
                                @if(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret) && empty(optional($attendanceEvent)->meeting_id))
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="create_zoom_meeting" name="create_zoom_meeting" value="1">
                                        <label class="form-check-label" for="create_zoom_meeting">{{ __('Create Zoom meeting now') }}</label>
                                    </div>
                                @endif
                                @if(!empty($zoomSetting->livekit_enabled) && !empty($zoomSetting->livekit_server_url) && !empty($zoomSetting->livekit_api_key) && !empty($zoomSetting->livekit_api_secret) && empty(optional($attendanceEvent)->meeting_id))
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="create_livekit_meeting" name="create_livekit_meeting" value="1">
                                        <label class="form-check-label" for="create_livekit_meeting">{{ __('Create LiveKit room now') }}</label>
                                    </div>
                                @endif
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="create_jitsi_meeting" name="create_jitsi_meeting" value="1">
                                    <label class="form-check-label" for="create_jitsi_meeting">{{ __('Create / refresh Jitsi room') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Program Schedule --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"><i class="ti ti-clipboard-list text-primary"></i> {{ __('Program Schedule') }}</label>
                        <div id="program-wrapper">
                            @forelse($event->programs as $index => $program)
                                <div class="row mb-3 program-item">
                                    <div class="col-md-4">
                                        <input type="text" name="program_item[]" class="form-control" value="{{ $program->program_item }}" placeholder="{{ __('Program Item') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="duration[]" class="form-control" value="{{ $program->duration }}" placeholder="{{ __('Min') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <select name="leader[]" class="form-select member-select">
                                            <option value="">-- Leader --</option>
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ $program->leader_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="note[]" class="form-control" value="{{ $program->note }}" placeholder="{{ __('Notes (optional)') }}">
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted">{{ __('No program items yet. Add some below.') }}</p>
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-program">
                            <i class="ti ti-plus"></i> {{ __('Add Program Item') }}
                        </button>
                    </div>

                    {{-- Submit --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="ti ti-device-floppy"></i> {{ __('Update Event') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Tips --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> {{ __('Edit Tips & Guidance') }}</h5>
            </div>
            <div class="card-body small text-muted">
                <p class="fw-semibold text-dark mb-2">{{ __('What You Can Update:') }}</p>
                <ul class="ps-3 mb-3">
                    <li>Change the title, venue, and description.</li>
                    <li>Adjust timing and recurrence.</li>
                    <li>Assign or update leaders.</li>
                    <li>Modify program schedule details.</li>
                </ul>
                
                <hr>
                <p class="fw-semibold text-dark mb-2">{{ __('Additional Guidance:') }}</p>
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>Ã¢â‚¬Å“Add Program ItemÃ¢â‚¬Â</strong> button to define each part of the service (e.g., Worship, Sermon, etc.).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>After reviewing all details, click <strong>Ã¢â‚¬Å“Submit Event for ReviewÃ¢â‚¬Â</strong> to move it to the next stage.</li>
                    <li>Saved events stay in <strong>Draft</strong> until approved or published by authorized personnel.</li>
                </ul>
                 <hr>
                <p class="fw-semibold text-dark mb-2">{{ __('To edit or modify an Attendance Menthod:') }}</p>
                <ul class="ps-3 mb-0">
                    @if($attendanceEvent)
                        <a href="{{ route('churchmeet.attendance_events.edit', $attendanceEvent->id) }}"
                           class="btn btn-sm btn-outline-warning"
                           title="{{ __('Edit Attendance Event') }}">
                            <i class="ti ti-pencil">Clink to edit or modify an Attendance Menthod</i>
                        </a>
                    @else
                        <span class="text-muted">{{ __('Attendance settings will appear after the event is saved.') }}</span>
                    @endif
                </ul>
                <hr>
                <p class="fw-semibold text-dark mb-2">{{ __('Review Comments / Descussions') }}</p><br>
                <ul class="ps-0 mb-0"> 
                @if ($event->reviewerComments->count() > 0)
                <div class="chat-container bg-light rounded shadow-sm p-3" style="max-height: 350px; overflow-y: auto;">
                    @forelse ($event->reviewerComments as $comment)
                        <div class="mb-3 d-flex {{ $comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-3 rounded {{ $comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 80%;">
                                <div class="small fw-bold mb-1">
                                    {{ $comment->user?->name ?? 'System' }}
                                    <span class="text-muted small">
                                        Ã¢â‚¬Â¢ {{ $comment->commented_at ? \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <div>{!! nl2br(e($comment->comment)) !!}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small text-center">No reviewer comments yet. Be the first to add feedback below.</p>
                    @endforelse
           
                     @endif   
         </ul>
           </div>
    </div>
      
    </div>
    
</div>

{{-- JS for adding new program items --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('program-wrapper');
    const addBtn = document.getElementById('add-program');
    const branchSelect = document.getElementById('branch_id');
    const departmentSelect = document.getElementById('department_id');
    const createZoomMeeting = document.getElementById('create_zoom_meeting');
    const createJitsiMeeting = document.getElementById('create_jitsi_meeting');
    const createLivekitMeeting = document.getElementById('create_livekit_meeting');
    const onlinePlatform = document.getElementById('online_platform');
    const modeSelect = document.querySelector('select[name="mode"]');
    const jitsiDomainWrap = document.getElementById('jitsi-domain-wrap');
    const jitsiDomainInput = document.getElementById('jitsi_domain');

    function initializeMemberSelect(scope = document) {
        if (!(window.$ && $.fn && $.fn.select2)) {
            return;
        }

        $(scope).find('.member-select').each(function () {
            const $select = $(this);
            if ($select.hasClass('select2-hidden-accessible')) {
                return;
            }

            $select.select2({
                placeholder: 'Search member...',
                allowClear: true,
                width: '100%'
            });
        });
    }

    addBtn.addEventListener('click', () => {
        const row = document.createElement('div');
        row.classList.add('row', 'mb-3', 'program-item');
        row.innerHTML = `
            <div class="col-md-4"><input type="text" name="program_item[]" class="form-control" placeholder="Program Item"></div>
            <div class="col-md-2"><input type="number" name="duration[]" class="form-control" placeholder="Min"></div>
            <div class="col-md-3">
                <select name="leader[]" class="form-select member-select">
                    <option value="">-- Leader --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3"><input type="text" name="note[]" class="form-control" placeholder="Notes (optional)"></div>
        `;
        wrapper.appendChild(row);
        initializeMemberSelect(row);
    });

    function filterDepartments() {
        if (!branchSelect || !departmentSelect) {
            return;
        }

        const branchId = branchSelect.value;

        Array.from(departmentSelect.options).forEach((option, index) => {
            if (index === 0) {
                option.hidden = false;
                return;
            }

            option.hidden = branchId !== '' && option.dataset.branchId !== branchId;
        });

        if (departmentSelect.selectedOptions[0]?.hidden) {
            departmentSelect.value = '';
        }
    }

    function syncZoomDefaults() {
        if (createZoomMeeting?.checked) {
            onlinePlatform.value = 'zoom';
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = false;
            }
            if (createLivekitMeeting) {
                createLivekitMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function syncJitsiDefaults() {
        if (createJitsiMeeting?.checked) {
            onlinePlatform.value = 'jitsi';
            if (createZoomMeeting) {
                createZoomMeeting.checked = false;
            }
            if (createLivekitMeeting) {
                createLivekitMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function syncLivekitDefaults() {
        if (createLivekitMeeting?.checked) {
            onlinePlatform.value = 'livekit';
            if (createZoomMeeting) {
                createZoomMeeting.checked = false;
            }
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = false;
            }
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    function toggleJitsiDomain() {
        if (jitsiDomainWrap) {
            jitsiDomainWrap.style.display = onlinePlatform.value === 'jitsi' ? '' : 'none';
        }
    }

    function syncPlatformToggles() {
        if (!onlinePlatform) {
            return;
        }

        if (onlinePlatform.value === 'zoom') {
            createZoomMeeting && (createZoomMeeting.checked = createZoomMeeting.checked || false);
            createJitsiMeeting && (createJitsiMeeting.checked = false);
            createLivekitMeeting && (createLivekitMeeting.checked = false);
        }

        if (onlinePlatform.value === 'jitsi') {
            createJitsiMeeting && (createJitsiMeeting.checked = true);
            createZoomMeeting && (createZoomMeeting.checked = false);
            createLivekitMeeting && (createLivekitMeeting.checked = false);
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
            if (jitsiDomainInput && !jitsiDomainInput.value.trim()) {
                jitsiDomainInput.value = 'meet.jit.si';
            }
        }

        if (onlinePlatform.value === 'livekit') {
            createLivekitMeeting && (createLivekitMeeting.checked = true);
            createZoomMeeting && (createZoomMeeting.checked = false);
            createJitsiMeeting && (createJitsiMeeting.checked = false);
            if (modeSelect.value === 'onsite') {
                modeSelect.value = 'online';
            }
        }
    }

    branchSelect?.addEventListener('change', filterDepartments);
    createZoomMeeting?.addEventListener('change', syncZoomDefaults);
    createJitsiMeeting?.addEventListener('change', syncJitsiDefaults);
    createLivekitMeeting?.addEventListener('change', syncLivekitDefaults);
    onlinePlatform?.addEventListener('change', function () {
        syncPlatformToggles();
        toggleJitsiDomain();
    });
    filterDepartments();
    syncZoomDefaults();
    syncJitsiDefaults();
    syncLivekitDefaults();
    syncPlatformToggles();
    toggleJitsiDomain();
    initializeMemberSelect();
});
</script>
@endpush
@endsection


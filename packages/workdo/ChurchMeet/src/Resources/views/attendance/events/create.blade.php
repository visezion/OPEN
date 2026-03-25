@extends('layouts.main')

@section('page-title')
    {{ __('Create Event') }}
@endsection

@section('page-breadcrumb')
    {{ __('ChurchMeet') }},{{ __('Create Event') }}
@endsection

@push('css')
<style>
    .church-events-create .card {
        border: 1px solid #d8e2ef !important;
        box-shadow: none !important;
    }

    .church-events-create .create-hero {
        border-top: 3px solid #245f86 !important;
        background: linear-gradient(180deg, rgba(36, 95, 134, 0.06), rgba(36, 95, 134, 0)), #fff;
    }

    .church-events-create .section-copy,
    .church-events-create .text-muted {
        color: #6b7d90 !important;
    }

    .church-events-create .quick-card {
        background: #f7fafc;
        border-radius: 12px;
        border: 1px solid #d8e2ef;
        padding: 1rem;
    }

    .church-events-create .quick-card strong {
        color: #19324a;
    }

    .church-events-create .aside-sticky {
        position: sticky;
        top: 92px;
    }

    @media (max-width: 991.98px) {
        .church-events-create .aside-sticky {
            position: static;
        }
    }
</style>
@endpush

@section('page-action')
    <a href="{{ route('churchmeet.events.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-arrow-left"></i> {{ __('Back to Events') }}
    </a>
@endsection

@section('content')
<div class="row church-events-create">
    <div class="col-md-12 mb-4">
        <div class="card create-hero">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between gap-3 align-items-start">
                    <div>
                        <h4 class="mb-2">{{ __('Create a New Event') }}</h4>
                        <p class="section-copy mb-0">{{ __('Start with the basics first. Meeting settings and advanced options are kept lower down so the page stays easier to use.') }}</p>
                    </div>
                    <span class="badge bg-light text-primary border">{{ __('Draft Stage') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-white p-4">
                <h5 class="mb-1">{{ __('Basic Details') }}</h5>
                <p class="section-copy mb-0">{{ __('Fill the core event information first. Most events can be created with just this section and the attendance mode.') }}</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('churchmeet.events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Basic Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('Event Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('Sunday Worship Service') }}" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Event Type') }}</label>
                            <select class="form-select" name="event_type">
                                <option value="service" {{ old('event_type', 'service') === 'service' ? 'selected' : '' }}>Service</option>
                                <option value="meeting" {{ old('event_type') === 'meeting' ? 'selected' : '' }}>Meeting</option>
                                <option value="training" {{ old('event_type') === 'training' ? 'selected' : '' }}>Training</option>
                                <option value="rehearsal" {{ old('event_type') === 'rehearsal' ? 'selected' : '' }}>Rehearsal</option>
                                <option value="outreach" {{ old('event_type') === 'outreach' ? 'selected' : '' }}>Outreach</option>
                                <option value="other" {{ old('event_type') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Attendance Mode') }}</label>
                            <select name="mode" id="mode-selector" class="form-select" required>
                                <option value="onsite" {{ old('mode', 'onsite') === 'onsite' ? 'selected' : '' }}>{{ __('Onsite') }}</option>
                                <option value="online" {{ old('mode') === 'online' ? 'selected' : '' }}>{{ __('Online') }}</option>
                                <option value="hybrid" {{ old('mode') === 'hybrid' ? 'selected' : '' }}>{{ __('Hybrid') }}</option>
                            </select>
                        </div>

                        <!-- Scheduling -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Start Date & Time') }}</label>
                            <input type="datetime-local" class="form-control" name="start_time" value="{{ old('start_time') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('End Date & Time') }}</label>
                            <input type="datetime-local" class="form-control" name="end_time" value="{{ old('end_time') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Recurrence') }}</label>
                            <select class="form-select" name="recurrence">
                                <option value="none" {{ old('recurrence', 'none') === 'none' ? 'selected' : '' }}>None</option>
                                <option value="daily" {{ old('recurrence') === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ old('recurrence') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ old('recurrence') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                        </div>

                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Lead Minister / Person-in-Charge') }}</label>
                            <select class="form-select member-select" name="lead_id">
                                <option value="">{{ __('Select Lead') }}</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" {{ old('lead_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Assistant / Co-Leader') }}</label>
                            <select class="form-select member-select" name="assistant_id">
                                <option value="">{{ __('Select Assistant') }}</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" {{ old('assistant_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('Venue / Link') }}</label>
                            <input type="text" class="form-control" name="venue" value="{{ old('venue') }}" placeholder="{{ __('Main Hall or meeting address') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Branch') }}</label>
                            <select class="form-select" name="branch_id" id="branch_id">
                                <option value="">{{ __('Select Branch') }}</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('Department') }}</label>
                            <select class="form-select" name="department_id" id="department_id">
                                <option value="">{{ __('Select Department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" data-branch-id="{{ $department->branch_id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">{{ __('Description / Notes') }}</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="{{ __('Briefly describe this event...') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- Ã°Å¸Â§Â© Program Builder -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Program Schedule</h6>
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="addProgramRow">+ Add Item</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="programTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Program Item</th>
                                    <th>Duration (min)</th>
                                    <th>Leader / Person-in-Charge</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" class="form-control" name="program_item[]" placeholder="e.g., Opening Prayer"></td>
                                    <td><input type="number" class="form-control" name="duration[]" value="10"></td>
                                    <td>
                                        <!-- Ã°Å¸â€Â Searchable Dropdown Added -->
                                        <select class="form-select member-select" name="leader[]">
                                            <option value="">Select Member</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="note[]" placeholder="Optional note"></td>
                                    <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h6 class="mb-1">{{ __('Attendance & Meeting Tools') }}</h6>
                            <small class="text-muted">{{ __('Use these only if the event needs attendance automation or an online room.') }}</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" class="form-check-input" id="auto_log_attendance" name="auto_log_attendance" value="1" {{ old('auto_log_attendance') ? 'checked' : '' }}>
                            <label for="auto_log_attendance" class="form-check-label">{{ __('Auto Log') }}</label>
                        </div>
                    </div>

                    @if(!empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret))
                        <div class="alert alert-info d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ __('Zoom is connected.') }}</strong>
                                {{ __('You can create the Zoom meeting automatically when this event is saved.') }}
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input type="checkbox" class="form-check-input" id="create_zoom_meeting" name="create_zoom_meeting" value="1">
                                <label for="create_zoom_meeting" class="form-check-label">{{ __('Auto-create Zoom meeting') }}</label>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            {{ __('Zoom meeting creation is unavailable until ChurchMeet integration settings are configured.') }}
                            <a href="{{ route('churchmeet.integrations.index') }}" class="alert-link">{{ __('Open Integration settings') }}</a>
                        </div>
                    @endif

                    <div class="alert alert-light border d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ __('Jitsi is available.') }}</strong>
                            {{ __('Use Jitsi as a free in-app meeting alternative without Zoom credentials.') }}
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input type="checkbox" class="form-check-input" id="create_jitsi_meeting" name="create_jitsi_meeting" value="1">
                            <label for="create_jitsi_meeting" class="form-check-label">{{ __('Auto-create Jitsi room') }}</label>
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
                                    ['jitsi', 'Jitsi Meeting Room', 'ti-brand-tabler'],
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
                    <div id="online-config" class="mb-4" style="display:none;">
                        <label class="form-label fw-semibold">
                            <i class="ti ti-video text-danger"></i> {{ __('Online Meeting Details') }}
                        </label>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <select name="online_platform" id="online_platform" class="form-select">
                                    <option value="">{{ __('Select Online Platform') }}</option>
                                    <option value="zoom" {{ old('online_platform', $zoomSetting->preferred_platform) === 'zoom' ? 'selected' : '' }}>{{ __('Zoom') }}</option>
                                    <option value="jitsi" {{ old('online_platform', $zoomSetting->preferred_platform ?: 'jitsi') === 'jitsi' ? 'selected' : '' }}>{{ __('Jitsi Meet') }}</option>
                                    <option value="youtube" {{ old('online_platform') === 'youtube' ? 'selected' : '' }}>{{ __('YouTube') }}</option>
                                    <option value="custom" {{ old('online_platform') === 'custom' ? 'selected' : '' }}>{{ __('Custom Link') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_link" value="{{ old('meeting_link') }}" placeholder="{{ __('Meeting/Stream Link') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_id" value="{{ old('meeting_id') }}" placeholder="{{ __('Meeting ID or Jitsi Room Name') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="meeting_passcode" value="{{ old('meeting_passcode') }}" placeholder="{{ __('Passcode (Zoom only)') }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="jitsi_domain" id="jitsi_domain" value="{{ old('jitsi_domain', $zoomSetting->jitsi_server_domain ?: 'meet.jit.si') }}" placeholder="{{ __('Jitsi Domain (optional, defaults to meet.jit.si)') }}" class="form-control">
                            </div>
                        </div>
                        <small class="text-muted d-block mt-1">
                            {{ __('Only required for Online or Hybrid modes. For Jitsi, the room name becomes the meeting ID.') }}
                        </small>
                    </div>

                    <hr>

                    <details class="mb-3">
                        <summary>{{ __('Advanced Options') }}</summary>
                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('Latitude') }}</label>
                                <input type="number" step="0.0001" class="form-control" name="latitude" value="{{ old('latitude') }}" placeholder="6.5244">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('Longitude') }}</label>
                                <input type="number" step="0.0001" class="form-control" name="longitude" value="{{ old('longitude') }}" placeholder="3.3792">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('Radius (meters)') }}</label>
                                <input type="number" min="1" class="form-control" name="radius_meters" value="{{ old('radius_meters', 100) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ __('Upload Files (Optional)') }}</label>
                                <input type="file" class="form-control" name="files[]" multiple>
                            </div>
                        </div>
                    </details>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> {{ __('Submit Event for Review') }}</button>
                        <button type="reset" class="btn btn-light">{{ __('Clear') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Sidebar: Tips and Notifications --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        {{-- Ã°Å¸Â§Â­ Instruction & Tips --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-primary py-3">
                <h5 class="mb-1"><i class="ti ti-bulb me-1"></i> {{ __('Quick Guide') }}</h5>
                <p class="section-copy mb-0">{{ __('Use the shortest path possible for normal events.') }}</p>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li><strong>Fill in all required fields</strong> such as title, date, and lead before submitting.</li>
                    <li>Use <strong>Ã¢â‚¬Å“Add ItemÃ¢â‚¬Â</strong> in the Program Schedule to define each part of the service (e.g., Worship, Sermon).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>Choose appropriate <strong>attendance methods</strong> (QR, Kiosk, App, Face AI) based on the setup.</li>
                    <li>After reviewing all details, click <strong>Ã¢â‚¬Å“Submit Event for ReviewÃ¢â‚¬Â</strong> to move it to the next stage.</li>
                    <li>Saved events stay in <strong>Draft</strong> until approved or published by authorized personnel.</li>
                </ul>
                <hr class="my-3">
                <div class="alert alert-info mb-0">
                    <i class="ti ti-shield-check"></i>
                    <strong>Note:</strong> Event creation and editing are collaborative, but <u>final review and approval rights belong solely to the Lead Minister or Assistant/Co-Leader</u>. They may modify program items, timing, or details before publication.
                </div>
            </div>
        </div>


       {{-- Notifications --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0">{{ __('Current Defaults') }}</h6>
                </div>

                <div class="card-body small">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Workflow') }}</span>
                        <strong>{{ __('Draft -> Review') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Default Method') }}</span>
                        <strong>{{ __('Manual') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('Zoom') }}</span>
                        <strong>{{ !empty($zoomSetting->account_id) && !empty($zoomSetting->client_id) && !empty($zoomSetting->client_secret) ? __('Ready') : __('Needs setup') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">{{ __('Jitsi') }}</span>
                        <strong>{{ __('Ready') }}</strong>
                    </div>
                </div>
            </div>

    </div>
</div>

<!-- Ã¢Å“â€¦ Include Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Activate searchable dropdowns
    $('.member-select').select2({
        placeholder: "Search member...",
        allowClear: true,
        width: '100%'
    });

    // Add program row dynamically
    document.getElementById('addProgramRow').addEventListener('click', function() {
        const table = document.querySelector('#programTable tbody');
        const newRow = document.createElement('tr');
        const count = table.rows.length + 1;
        let memberOptions = `{!! $members->map(fn($m)=>"<option value='{$m->id}'>{$m->name}</option>")->implode('') !!}`;
        newRow.innerHTML = `
            <td>${count}</td>
            <td><input type="text" class="form-control" name="program_item[]" placeholder="Program name"></td>
            <td><input type="number" class="form-control" name="duration[]" value="10"></td>
            <td>
                <select class="form-select member-select" name="leader[]">
                    <option value="">Select Member</option>
                    ${memberOptions}
                </select>
            </td>
            <td><input type="text" class="form-control" name="note[]" placeholder="Notes"></td>
            <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-x"></i></button></td>
        `;
        table.appendChild(newRow);
        $('.member-select').select2({ placeholder: "Search member...", width: '100%' });
    });

    document.addEventListener('click', function(e) {
        if(e.target.closest('.removeRow')) e.target.closest('tr').remove();
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const modeSelector = document.getElementById('mode-selector');
    const onlineConfig = document.getElementById('online-config');
    const createZoomMeeting = document.getElementById('create_zoom_meeting');
    const createJitsiMeeting = document.getElementById('create_jitsi_meeting');
    const onlinePlatform = document.getElementById('online_platform');
    const jitsiDomain = document.getElementById('jitsi_domain');
    const branchSelect = document.getElementById('branch_id');
    const departmentSelect = document.getElementById('department_id');

    function toggleOnlineSection() {
        const val = modeSelector.value;
        onlineConfig.style.display = (val === 'online' || val === 'hybrid') ? 'block' : 'none';
    }

    function syncZoomPlatform() {
        if (createZoomMeeting && createZoomMeeting.checked) {
            onlinePlatform.value = 'zoom';
            if (createJitsiMeeting) {
                createJitsiMeeting.checked = false;
            }
            if (modeSelector.value === 'onsite') {
                modeSelector.value = 'online';
            }
            toggleOnlineSection();
        }
    }

    function syncJitsiPlatform() {
        if (createJitsiMeeting && createJitsiMeeting.checked) {
            onlinePlatform.value = 'jitsi';
            if (createZoomMeeting) {
                createZoomMeeting.checked = false;
            }
            if (modeSelector.value === 'onsite') {
                modeSelector.value = 'online';
            }
            toggleOnlineSection();
        }
    }

    function filterDepartments() {
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

    modeSelector.addEventListener('change', toggleOnlineSection);
    branchSelect.addEventListener('change', filterDepartments);
    function toggleJitsiDomain() {
        if (!jitsiDomain) {
            return;
        }

        jitsiDomain.closest('.col-md-6').style.display = onlinePlatform.value === 'jitsi' ? '' : 'none';
    }

    if (createZoomMeeting) {
        createZoomMeeting.addEventListener('change', syncZoomPlatform);
    }
    if (createJitsiMeeting) {
        createJitsiMeeting.addEventListener('change', syncJitsiPlatform);
    }
    onlinePlatform.addEventListener('change', toggleJitsiDomain);

    filterDepartments();
    toggleOnlineSection(); // initialize on load
    syncZoomPlatform();
    syncJitsiPlatform();
    toggleJitsiDomain();
});
</script>
@endsection


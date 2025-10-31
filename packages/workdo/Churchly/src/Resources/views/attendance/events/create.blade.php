@extends('layouts.main')

@section('page-title')
    Create New Event / Service
@endsection

@section('page-breadcrumb')
    {{ __('Create New Event / Service ') }}
@endsection

@section('page-action')
    <a href="{{ route('churchly.events.index') }}" class="btn btn-secondary btn-sm">
        <i class="ti ti-arrow-left"></i> Back to List
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-muted mb-0">Event Workflow</h6>
                    <span class="small text-secondary">Status: <strong class="text-primary">Draft</strong></span>
                </div>

                <div class="progress-container" style="position: relative;">
                    <div class="progress" style="height: 10px; background: #f1f1f1; border-radius: 10px;">
                        <div id="progressBar" class="progress-bar bg-primary" style="width: 25%; border-radius: 10px;"></div>
                    </div>

                    <ul class="d-flex justify-content-between list-unstyled position-absolute w-100 top-0" style="margin-top: -10px;">
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-primary text-white mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">1</div>
                            <small>Draft</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">2</div>
                            <small>Review</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">3</div>
                            <small>Approver</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-light text-muted border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">4</div>
                            <small>Publish</small>
                        </li>
                    </ul><br>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Event / Service Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.events.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <!-- Basic Info -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Event Type</label>
                            <select class="form-select" name="event_type">
                                <option value="service">Service</option>
                                <option value="meeting">Meeting</option>
                                <option value="training">Training</option>
                                <option value="rehearsal">Rehearsal</option>
                                <option value="outreach">Outreach</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="draft">Draft</option>
                                <option value="upcoming">Upcoming</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <!-- Scheduling -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Start Date & Time</label>
                            <input type="datetime-local" class="form-control" name="start_time">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">End Date & Time</label>
                            <input type="datetime-local" class="form-control" name="end_time">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Recurrence</label>
                            <select class="form-select" name="recurrence">
                                <option value="none">None</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>

                        <!-- 🔍 Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Lead Minister / Person-in-Charge</label>
                            <select class="form-select member-select" name="lead_id">
                                <option value="">Select Lead</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🔍 Searchable Dropdown Added -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Assistant / Co-Leader</label>
                            <select class="form-select member-select" name="assistant_id">
                                <option value="">Select Assistant</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Venue / Link</label>
                            <input type="text" class="form-control" name="venue" placeholder="e.g., Main Hall or Zoom Link">
                        </div>

                        {{-- GPS Location for Self Attendance (optional) --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="number" step="0.0001" class="form-control" name="latitude" value="{{ old('latitude') }}" placeholder="e.g., 6.5244">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="number" step="0.0001" class="form-control" name="longitude" value="{{ old('longitude') }}" placeholder="e.g., 3.3792">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Radius (meters)</label>
                            <input type="number" min="1" class="form-control" name="radius_meters" value="{{ old('radius_meters', 100) }}">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description / Notes</label>
                            <textarea class="form-control" rows="3" name="description" placeholder="Describe this event..."></textarea>
                        </div>
                    </div>

                    <hr>

                    <!-- 🧩 Program Builder -->
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
                                        <!-- 🔍 Searchable Dropdown Added -->
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
                    <div id="online-config" class="mb-4" style="display:none;">
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

                    <hr>

                    <!-- File Upload -->
                    <div class="mb-3">
                        <label class="form-label">Upload Files (Optional)</label>
                        <input type="file" class="form-control" name="files[]" multiple>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-send"></i> Submit Event for Review</button>
                        <button type="reset" class="btn btn-light">Clear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Sidebar: Tips and Notifications --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        {{-- 🧭 Instruction & Tips --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-primary py-3">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> {{ __('Instructions & Tips') }}</h5>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li><strong>Fill in all required fields</strong> such as title, date, and lead before submitting.</li>
                    <li>Use <strong>“Add Item”</strong> in the Program Schedule to define each part of the service (e.g., Worship, Sermon).</li>
                    <li>Assign the right <strong>Leader / Person-in-Charge</strong> for each program segment.</li>
                    <li>You can upload <strong>service notes, slides, or images</strong> in the upload section below.</li>
                    <li>Choose appropriate <strong>attendance methods</strong> (QR, Kiosk, App, Face AI) based on the setup.</li>
                    <li>After reviewing all details, click <strong>“Submit Event for Review”</strong> to move it to the next stage.</li>
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
            @php
                $recentEvents = \Workdo\Churchly\Entities\Event::orderBy('created_at', 'desc')->take(3)->get();
            @endphp

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="ti ti-bell"></i> {{ __('Recent Notifications') }}
                    </h6>
                    <a href="{{ route('churchly.events.index') }}" class="text-muted small">{{ __('View All') }}</a>
                </div>

                <div class="card-body small">
                    @forelse($recentEvents as $event)
                        <div class="alert alert-{{ 
                            $event->event_type == 'worship' ? 'info' : 
                            ($event->event_type == 'meeting' ? 'warning' : 
                            ($event->event_type == 'outreach' ? 'success' : 'secondary')) 
                        }} mb-2 py-2">
                            <i class="ti ti-calendar-event"></i>
                            <strong>{{ $event->title }}</strong>
                            <br>
                            <span class="text-muted">
                                {{ __('Scheduled for') }} {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                @if($event->time)
                                    {{ __('at') }} {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                @endif
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="ti ti-bell-off" style="font-size: 28px;"></i>
                            <p class="mt-2 mb-0">{{ __('No recent event notifications yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

    </div>
</div>

<!-- ✅ Include Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    function toggleOnlineSection() {
        const val = modeSelector.value;
        onlineConfig.style.display = (val === 'online' || val === 'hybrid') ? 'block' : 'none';
    }

    modeSelector.addEventListener('change', toggleOnlineSection);
    toggleOnlineSection(); // initialize on load
});
</script>
@endsection

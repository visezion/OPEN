@extends('layouts.main')

@section('page-title')
    {{ $event->title }}
@endsection

@section('page-breadcrumb')
    {{ __('Event Details') }}
@endsection

@section('page-action')
    <a href="{{ route('churchly.events.export.pdf', $event->id) }}" class="btn btn-danger btn-sm">
        <i class="ti ti-file-type-pdf"></i> Export PDF
    </a>
    <a href="{{ route('churchly.events.index') }}" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> Back to Events
    </a>
@endsection

@section('content')
<div class="card shadow-sm border-0 rounded-3 overflow-hidden">
    <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center"
         style="background: linear-gradient(90deg,#007bff,#6610f2);">
        <h5 class="mb-0"><i class="ti ti-calendar-event"></i> {{ $event->title }}</h5>
        <span class="badge bg-white text-dark px-3 py-2">{{ ucfirst($event->event_type) }}</span>
    </div>

    <div class="card-body">

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                        type="button" role="tab"><i class="ti ti-info-circle"></i> Overview</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance"
                        type="button" role="tab"><i class="ti ti-users"></i> Attendance</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion"
                        type="button" role="tab"><i class="ti ti-message-dots"></i> Discussion</button>
            </li>
        </ul>

        <div class="tab-content" id="eventTabsContent">

            <!-- 🟦 TAB 1: Overview -->
            <div class="tab-pane fade show active" id="overview" role="tabpanel">
                <div class="row">
                    <!-- Overview Info -->
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Status</p>
                                @switch($event->status)
                                    @case('draft') <span class="badge bg-secondary">Draft</span> @break
                                    @case('review') <span class="badge bg-info text-dark">In Review</span> @break
                                    @case('approved') <span class="badge bg-success">Approved</span> @break
                                    @case('published') <span class="badge bg-primary">Published</span> @break
                                    @case('revision_required') <span class="badge bg-warning text-dark">Revision Required</span> @break
                                    @case('resubmitted') <span class="badge bg-secondary ">Resubmitted</span> @break
                                @endswitch
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Recurrence</p>
                                <span class="text-dark">{{ ucfirst($event->recurrence) }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Venue / Link</p>
                                <span>{{ $event->venue ?? '—' }}</span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Start Time</p>
                                <strong>{{ $event->formatted_start }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">End Time</p>
                                <strong>{{ $event->formatted_end }}</strong>
                            </div>
                            <div class="col-md-4 mb-3">
                                <p class="mb-1 text-muted small">Duration</p>
                                @php
                                    $totalDuration = $event->programs->sum('duration');
                                    $hours = floor($totalDuration / 60);
                                    $minutes = $totalDuration % 60;
                                @endphp
                                <strong>{{ $hours ? $hours.'h ' : '' }}{{ $minutes }}m total</strong>
                            </div>
                        </div>

                        <div class="border-top pt-3 mt-2">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1 text-muted small">Lead Minister</p>
                                    <strong>{{ $event->lead->name ?? '—' }}</strong>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1 text-muted small">Assistant / Co-Leader</p>
                                    <strong>{{ $event->assistant->name ?? '—' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p class="mb-1 text-muted small">Description</p>
                            <p class="text-dark">{!! nl2br(e($event->description ?? 'No description provided.')) !!}</p>
                        </div>
                    </div>

                    <!-- Program Schedule -->
                    <div class="col-md-12 mb-4">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="ti ti-clipboard-list"></i> Program Schedule</h6>
                                <span class="small text-muted">Total: {{ $event->programs->count() }} items</span>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Program Item</th>
                                            <th>Duration</th>
                                            <th>Leader</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($event->programs as $program)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><strong>{{ $program->program_item }}</strong></td>
                                                <td>{{ $program->duration }} min</td>
                                                <td>{{ $program->leader->name ?? '—' }}</td>
                                                <td class="text-muted">{{ $program->note ?? '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-3">No program items added.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🟩 TAB 2: Attendance -->
            <div class="tab-pane fade" id="attendance" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="ti ti-users"></i> Attendance Summary</h6>
                            </div>
                            <div class="card-body">
                                @if($attendanceEvent)
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Total Registered: <strong>{{ $attendanceStats['total_registered'] }}</strong></li>
                                        <li class="list-group-item text-success">Present: <strong>{{ $attendanceStats['present'] }}</strong></li>
                                        <li class="list-group-item text-danger">Absent: <strong>{{ $attendanceStats['absent'] }}</strong></li>
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">No attendance record available for this event.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="ti ti-paperclip"></i> Attachments</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $attachments = is_array($event->attachments)
                                        ? $event->attachments
                                        : json_decode($event->attachments ?? '[]', true);
                                @endphp
                                @if(!empty($attachments))
                                    <ul class="list-group list-group-flush">
                                        @foreach($attachments as $file)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <span><i class="ti ti-file"></i> {{ basename($file) }}</span>
                                                <a href="{{ asset('storage/'.$file) }}" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">No files attached.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🟨 TAB 3: Discussion / Review Comments -->
            <div class="tab-pane fade" id="discussion" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="ti ti-message-dots"></i> Reviewer Discussion</h6>
                    </div>
                    <div class="card-body">
                        <div class="chat-container bg-light rounded p-3" style="max-height: 400px; overflow-y: auto;">
                            @forelse ($reviewComments as $comment)
                                <div class="mb-3 d-flex {{ $comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="p-3 rounded {{ $comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border' }}"
                                         style="max-width: 80%;">
                                        <div class="small fw-bold mb-1">
                                            {{ $comment->user?->name ?? 'System' }}
                                            <span class="text-muted small">
                                                • {{ \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        <div>{!! nl2br(e($comment->comment)) !!}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center small mb-0">No discussion yet for this event.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- End Tab Content -->
    </div>
</div>
@endsection

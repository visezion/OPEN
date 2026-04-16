@extends('layouts.main')

@section('page-title')
    {{ $event->title }}
@endsection

@section('page-breadcrumb')
    {{ __('Event Details') }}
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/attendance.css') }}">
@endpush

@section('page-action')
    @if($canJoinOnlineMeeting)
        <a href="{{ route('churchmeet.meetings.join', $attendanceEvent->id) }}" class="btn btn-primary btn-sm">
            <i class="ti ti-video"></i> {{ __('Join Meeting') }}
        </a>
    @endif
    @if($canCreateZoomMeeting && !$canJoinOnlineMeeting)
        <form method="POST" action="{{ route('churchmeet.zoom.meetings.create', $event->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-video-plus"></i> {{ __('Create Zoom Meeting') }}
            </button>
        </form>
    @endif
    @if($canCreateJitsiMeeting && !$canJoinOnlineMeeting)
        <form method="POST" action="{{ route('churchmeet.jitsi.meetings.create', $event->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-brand-tabler"></i> {{ __('Create Jitsi Room') }}
            </button>
        </form>
    @endif
    @if($canCreateLivekitMeeting && !$canJoinOnlineMeeting)
        <form method="POST" action="{{ route('churchmeet.livekit.meetings.create', $event->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-brand-webrtc"></i> {{ __('Create LiveKit Room') }}
            </button>
        </form>
    @endif
    <a href="{{ route('churchmeet.events.export.pdf', $event->id) }}" class="btn btn-danger btn-sm">
        <i class="ti ti-file-type-pdf"></i> {{ __('Export PDF') }}
    </a>
    <a href="{{ route('churchmeet.events.index') }}" class="btn btn-light btn-sm">
        <i class="ti ti-arrow-left"></i> {{ __('Back to Events') }}
    </a>
@endsection

@section('content')
@php
    $totalDuration = (int) $event->programs->sum('duration');
    $hours = intdiv($totalDuration, 60);
    $minutes = $totalDuration % 60;

    $totalRegistered = (int) ($attendanceStats['total_registered'] ?? 0);
    $presentCount = (int) ($attendanceStats['present'] ?? 0);
    $absentCount = (int) ($attendanceStats['absent'] ?? 0);
    $attendanceRate = $totalRegistered > 0 ? (int) round(($presentCount / $totalRegistered) * 100) : 0;

    $statusLabel = ucfirst((string) $event->status);
    $statusClass = 'bg-secondary';
    if ($event->status === 'review') {
        $statusClass = 'bg-info text-dark';
        $statusLabel = __('In Review');
    } elseif ($event->status === 'approved') {
        $statusClass = 'bg-success';
    } elseif ($event->status === 'published') {
        $statusClass = 'bg-primary';
    } elseif ($event->status === 'revision_required') {
        $statusClass = 'bg-warning text-dark';
        $statusLabel = __('Revision Required');
    } elseif ($event->status === 'draft') {
        $statusLabel = __('Draft');
    }
@endphp

<div class="church-event-show">
    <div class="card event-hero mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <h4 class="mb-1">{{ $event->title }}</h4>
                    <p class="hero-copy mb-0">{{ __('Complete event profile, attendance outcome, and online meeting controls in one page.') }}</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    <span class="badge bg-light text-dark border">{{ ucfirst((string) ($event->event_type ?? 'event')) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label">{{ __('Start') }}</span>
                <span class="metric-value">{{ $event->formatted_start }}</span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label">{{ __('Duration') }}</span>
                <span class="metric-value">{{ $hours ? $hours . 'h ' : '' }}{{ $minutes }}m</span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label">{{ __('Program Items') }}</span>
                <span class="metric-value">{{ $event->programs->count() }}</span>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="metric-card">
                <span class="metric-label">{{ __('Attendance Rate') }}</span>
                <span class="metric-value">{{ $attendanceRate }}%</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                        <i class="ti ti-info-circle me-1"></i>{{ __('Overview') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">
                        <i class="ti ti-users me-1"></i>{{ __('Attendance') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion" type="button" role="tab">
                        <i class="ti ti-message-dots me-1"></i>{{ __('Discussion') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="eventTabsContent">
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="detail-grid mb-3">
                                <div class="detail-item">
                                    <label>{{ __('Recurrence') }}</label>
                                    <span>{{ ucfirst((string) ($event->recurrence ?? 'none')) }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>{{ __('Venue / Link') }}</label>
                                    <span>{{ $event->venue ?: '-' }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>{{ __('Start Time') }}</label>
                                    <span>{{ $event->formatted_start }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>{{ __('End Time') }}</label>
                                    <span>{{ $event->formatted_end }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>{{ __('Lead Minister') }}</label>
                                    <span>{{ $event->lead->name ?? '-' }}</span>
                                </div>
                                <div class="detail-item">
                                    <label>{{ __('Assistant / Co-Leader') }}</label>
                                    <span>{{ $event->assistant->name ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0">{{ __('Description') }}</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0 text-dark">{!! nl2br(e($event->description ?? __('No description provided.'))) !!}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card h-100">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0">{{ __('Meeting Control') }}</h6>
                                </div>
                                <div class="card-body">
                                    <p class="muted-copy small mb-2">{{ __('Platform') }}</p>
                                    <h6 class="mb-3">{{ ucfirst($meetingPlatform ?: 'Not configured') }}</h6>

                                    @if($attendanceEvent)
                                        <div class="small mb-3">
                                            @if($attendanceEvent->meeting_id)
                                                <div class="mb-1">{{ __('Meeting ID') }}: <strong>{{ $attendanceEvent->meeting_id }}</strong></div>
                                            @endif
                                            @if($attendanceEvent->meeting_passcode)
                                                <div class="mb-1">{{ __('Passcode') }}: <strong>{{ $attendanceEvent->meeting_passcode }}</strong></div>
                                            @endif
                                            @if($attendanceEvent->meeting_link)
                                                <a href="{{ $attendanceEvent->meeting_link }}" target="_blank" rel="noopener" class="link-primary small">
                                                    {{ __('Open External Link') }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="d-grid gap-2">
                                        @if($canJoinOnlineMeeting)
                                            <a href="{{ route('churchmeet.meetings.join', $attendanceEvent->id) }}" class="btn btn-outline-primary btn-sm">
                                                {{ __('Open Join Room') }}
                                            </a>
                                        @elseif($canCreateZoomMeeting)
                                            <form method="POST" action="{{ route('churchmeet.zoom.meetings.create', $event->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">{{ __('Create Zoom Meeting') }}</button>
                                            </form>
                                        @elseif($canCreateJitsiMeeting)
                                            <form method="POST" action="{{ route('churchmeet.jitsi.meetings.create', $event->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">{{ __('Create Jitsi Room') }}</button>
                                            </form>
                                        @elseif($canCreateLivekitMeeting)
                                            <form method="POST" action="{{ route('churchmeet.livekit.meetings.create', $event->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm w-100">{{ __('Create LiveKit Room') }}</button>
                                            </form>
                                        @else
                                            <span class="text-muted small">{{ __('No online meeting action available for this event.') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ __('Program Schedule') }}</h6>
                                    <small class="text-muted">{{ __('Total') }}: {{ $event->programs->count() }}</small>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="churchmeet-col-60">#</th>
                                                    <th>{{ __('Program Item') }}</th>
                                                    <th class="churchmeet-col-140">{{ __('Duration') }}</th>
                                                    <th class="churchmeet-col-200">{{ __('Leader') }}</th>
                                                    <th>{{ __('Notes') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($event->programs as $program)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><strong>{{ $program->program_item }}</strong></td>
                                                        <td>{{ $program->duration }} {{ __('min') }}</td>
                                                        <td>{{ $program->leader->name ?? '-' }}</td>
                                                        <td class="text-muted">{{ $program->note ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted py-4">{{ __('No program items added.') }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="attendance" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <div class="metric-card">
                                <span class="metric-label">{{ __('Total Registered') }}</span>
                                <span class="metric-value">{{ $totalRegistered }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="metric-card">
                                <span class="metric-label">{{ __('Present') }}</span>
                                <span class="metric-value">{{ $presentCount }}</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="metric-card">
                                <span class="metric-label">{{ __('Absent') }}</span>
                                <span class="metric-value">{{ $absentCount }}</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0">{{ __('Attachments') }}</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $attachments = is_array($event->attachments)
                                            ? $event->attachments
                                            : json_decode($event->attachments ?? '[]', true);
                                    @endphp
                                    @if(!empty($attachments))
                                        <div class="table-responsive">
                                            <table class="table table-sm align-middle mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('File') }}</th>
                                                        <th class="churchmeet-col-140">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attachments as $file)
                                                        <tr>
                                                            <td>{{ basename($file) }}</td>
                                                            <td>
                                                                <a href="{{ asset('storage/'.$file) }}" target="_blank" class="btn btn-outline-primary btn-sm">{{ __('View') }}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">{{ __('No files attached.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="discussion" role="tabpanel">
                    <div class="d-grid gap-2">
                        @forelse ($reviewComments as $comment)
                            <div class="discussion-item">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <strong>{{ $comment->user?->name ?? 'System' }}</strong>
                                    <span class="discussion-meta">{{ \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() }}</span>
                                </div>
                                <div class="discussion-message">{!! nl2br(e($comment->comment)) !!}</div>
                            </div>
                        @empty
                            <div class="discussion-item text-center text-muted">
                                {{ __('No discussion yet for this event.') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

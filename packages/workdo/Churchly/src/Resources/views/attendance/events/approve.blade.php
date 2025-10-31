@extends('layouts.main')

@section('page-title')
    Approve Event: {{ $event->title }}
@endsection

@section('page-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('churchly.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">Approve</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="ti ti-badge-check"></i> Final Event Approval
        </h5>
        <span class="badge bg-light text-primary px-3 py-2">
            Status: {{ strtoupper($event->status) }}
        </span>
    </div>

    <div class="card-body">

        <!-- 🧭 Approver Guidance -->
        <div class="alert alert-info border-start border-4 border-info shadow-sm">
            <strong><i class="ti ti-info-circle"></i> Approver Tip:</strong>
            Please review the event details and prior reviewer comments below before approving or rejecting this event.
        </div>

        <!-- 📘 Event Overview -->
        <div class="mb-4">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-calendar-event"></i> Event Details
            </h6>
            <div class="row mt-2">
                <div class="col-md-6">
                    <p><strong>Title:</strong> {{ $event->title }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
                    <p><strong>Venue:</strong> {{ $event->venue ?? 'To be announced' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Start Time:</strong> {{ $event->formatted_start ?? $event->start_time ?? 'Not specified' }}</p>
                    <p><strong>End Time:</strong> {{ $event->formatted_end ?? $event->end_time ?? 'Not specified' }}</p>
                    <p><strong>Created By:</strong> {{ $event->creator?->name ?? 'System User' }}</p>
                </div>
            </div>

            <div class="mt-3">
                <p><strong>Description:</strong></p>
                <div class="p-3 bg-light rounded shadow-sm border small">
                    {!! nl2br(e($event->description ?? 'No description provided.')) !!}
                </div>
            </div>
        </div>

        <!-- 🗂 Program Schedule -->
        <div class="mb-5">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-list-details"></i> Program Schedule
            </h6>
            @if($event->programs->count() > 0)
                <table class="table table-hover table-bordered align-middle mt-2">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Program Item</th>
                            <th>Leader</th>
                            <th>Duration (min)</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->programs as $index => $program)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $program->program_item }}</td>
                                <td>{{ $program->leader?->name ?? '—' }}</td>
                                <td class="text-center">{{ $program->duration }}</td>
                                <td>{{ $program->note ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle"></i> No program items defined for this event.
                </div>
            @endif
        </div>

        <!-- 💬 Reviewer Discussion -->
        <div class="mb-5">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-message-dots"></i> Reviewer Comments / Discussion
            </h6>

            <div class="chat-container bg-light rounded shadow-sm p-3" style="max-height: 350px; overflow-y: auto;">
                @forelse ($event->reviewerComments as $comment)
                    <div class="mb-3 d-flex {{ $comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded {{ $comment->role === 'Approver' ? 'bg-success text-white' : ($comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border') }}" style="max-width: 80%;">
                            <div class="small fw-bold mb-1">
                                {{ $comment->user?->name ?? 'System' }} 
                                <span class="text-muted small">• {{ \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() }}</span>
                            </div>
                            <div>{!! nl2br(e($comment->comment)) !!}</div>
                            <div class="small text-muted mt-1"><em>Role: {{ $comment->role ?? 'Reviewer' }}</em></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small text-center">No reviewer comments yet. You will be the first to take action.</p>
                @endforelse
            </div>
        </div>
@if ($event->status === 'approved')
        <!-- 🟢 Approval Form -->
        <div class="border-top pt-4">
            <h6 class="text-uppercase fw-bold mb-3">
                <i class="ti ti-checklist"></i> Approver Decision
            </h6>

            <form method="POST" action="{{ route('churchly.events.approveAction', $event->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="comments" class="form-label fw-bold">Approver Comments / Notes</label>
                    <textarea name="comments" id="comments" rows="5" class="form-control"
                        placeholder="Add final remarks or instructions before approval or rejection..."></textarea>
                </div>

                <div class="alert alert-light border-start border-info small">
                    <i class="ti ti-bulb"></i>
                    <strong>Tip:</strong> Choose <em>Approve</em> to mark this event as ready for publishing,  
                    or <em>Reject</em> if it should be sent back for revisions.
                </div>

                <div class="text-end mt-4">
                    <button type="submit" name="action" value="approve" class="btn btn-success px-4 me-2">
                        <i class="ti ti-check"></i> Publish Event
                    </button>

                    <button type="submit" name="action" value="reject" class="btn btn-danger px-4 me-2">
                        <i class="ti ti-x"></i> Reject Event
                    </button>

                    <a href="{{ route('churchly.events.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="ti ti-arrow-left"></i> Back to Events
                    </a>
                </div>
            </form>
        </div>
        @else
            <div class="border-top pt-4">
                <h6 class="text-uppercase fw-bold mb-3">
                    <i class="ti ti-checklist"></i> Approver Decision
                </h6>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i> This event has not yet been approved by the reviewer.
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

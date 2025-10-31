@extends('layouts.main')

@section('page-title')
    Review Event: {{ $event->title }}
@endsection

@section('page-breadcrumb')
   Rview Event
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
                        <div id="progressBar" class="progress-bar bg-primary" style="width: 50%; border-radius: 10px;"></div>
                    </div>

                    <ul class="d-flex justify-content-between list-unstyled position-absolute w-100 top-0" style="margin-top: -10px;">
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-primary text-white border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">1</div>
                            <small>Draft</small>
                        </li>
                        <li class="text-center" style="width:25%;">
                            <div class="rounded-circle bg-primary text-white border mx-auto mb-1" style="width:25px;height:25px;line-height:25px;">2</div>
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
    <div class="card shadow-sm border-0">
   
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="ti ti-clipboard-check"></i> Event Review & Approval
        </h5>
        <span class="badge bg-light text-primary px-3 py-2">
            Status: {{ strtoupper($event->status) }}
        </span>
    </div>

    <div class="card-body">
        <!-- Reviewer Info / Guidance -->
        <div class="alert alert-info border-start border-4 border-info shadow-sm mb-4">
            <strong><i class="ti ti-info-circle"></i> Reviewer Tip:</strong>
            Review all event details carefully before taking action.
            You can either <strong>send back</strong> the event for adjustments or <strong>submit</strong> it for approval.
        </div>

        <!-- Event Overview -->
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
                    <p><strong>Start Time:</strong> {{ $event->start_time ?? 'Not specified' }}</p>
                    <p><strong>End Time:</strong> {{ $event->end_time ?? 'Not specified' }}</p>
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

        <!-- Program Schedule -->
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

        <!-- Reviewer Comment History -->
       
        <div class="mb-5">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-message-dots"></i> Reviewer Comments / Discussion
            </h6>
            @if ($event->reviewerComments->count() > 0)
            <div class="chat-container bg-light rounded shadow-sm p-3" style="max-height: 350px; overflow-y: auto;">
                @forelse ($event->reviewerComments as $comment)
                    <div class="mb-3 d-flex {{ $comment->user_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-3 rounded {{ $comment->user_id === Auth::id() ? 'bg-primary text-white' : 'bg-white border' }}" style="max-width: 80%;">
                            <div class="small fw-bold mb-1">
                                {{ $comment->user?->name ?? 'System' }}
                                <span class="text-muted small">
                                    • {{ $comment->commented_at ? \Carbon\Carbon::parse($comment->commented_at)->diffForHumans() : '' }}
                                </span>
                            </div>
                            <div>{!! nl2br(e($comment->comment)) !!}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted small text-center">No reviewer comments yet. Be the first to add feedback below.</p>
                @endforelse
            </div><br>
            @endif
      

            <form method="POST" action="{{ route('churchly.events.submitReview', $event->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="comments" class="form-label fw-bold">Add New Comment</label>
                    <textarea name="comments" id="comments" rows="4" class="form-control"
                        placeholder="Write your feedback, correction request, or approval note..."></textarea>
                </div>

                <div class="alert alert-light border-start border-info small">
                    <i class="ti ti-bulb"></i>
                    <strong>Tip:</strong> Choose <em>Send Back for Adjustment</em> if the event needs changes,  
                    or <em>Submit for Approval</em> to forward directly to the lead.
                </div>

                <div class="text-end mt-4">
                    <button type="submit" name="action" value="adjust" class="btn btn-warning px-4 me-2">
                        <i class="ti ti-edit"></i> Send Back for Adjustment
                    </button>

                    <button type="submit" name="action" value="approve" class="btn btn-primary px-4">
                        <i class="ti ti-send"></i> Submit for Approval
                    </button>

                    <a href="{{ route('churchly.events.index') }}" class="btn btn-outline-secondary px-4 ms-2">
                        <i class="ti ti-arrow-left"></i> Back to Events
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

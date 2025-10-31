@extends('layouts.main')

@section('page-title')
    Publish Event: {{ $event->title }}
@endsection

@section('page-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('churchly.events.index') }}">Events</a></li>
    <li class="breadcrumb-item active">Publish</li>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="ti ti-megaphone"></i> Finalize & Publish Event</h5>
        <span class="badge bg-light text-success px-3 py-2">Ready to Publish</span>
    </div>

    <div class="card-body">
        <div class="alert alert-info border-start border-4 border-info shadow-sm">
            <strong><i class="ti ti-info-circle"></i> Publishing Tip:</strong>
            When published, all program leaders, lead, co-lead, and creator will be notified.
            You can also add <strong>extra members</strong> and <strong>WhatsApp groups</strong> to receive the same message.
        </div>

        <!-- Event Summary -->
        <div class="mb-4">
            <h6 class="text-uppercase fw-bold border-bottom pb-2">
                <i class="ti ti-calendar-event"></i> Event Summary
            </h6>
            <p><strong>Title:</strong> {{ $event->title }}</p>
            <p><strong>Type:</strong> {{ ucfirst($event->event_type) }}</p>
            <p><strong>Venue:</strong> {{ $event->venue ?? 'TBA' }}</p>
            <p><strong>Start:</strong> {{ $event->start_time ? date('d M Y h:i A', strtotime($event->start_time)) : 'Not set' }}</p>
        </div>

        <form method="POST" action="{{ route('churchly.events.publishAction', $event->id) }}">
            @csrf

            <div class="row">
                <!-- ✅ Searchable Members -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="ti ti-user"></i> Notify Additional Members
                    </label>
                    <select name="additional_members[]" class="form-control searchable-select" multiple>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Type a name to search quickly. Hold Ctrl/Cmd to select multiple.</small>
                </div>

                <!-- ✅ Searchable WhatsApp Groups -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        <i class="ti ti-brand-whatsapp"></i> Notify WhatsApp Groups
                    </label>
                    <select name="groups[]" class="form-control searchable-select" multiple>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">
                                {{ $group->name }}
                                @if($group->branches->count())
                                    ({{ $group->branches->pluck('name')->implode(', ') }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Search or select multiple groups to notify.</small>
                </div>
            </div>

            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="notify_all" value="1" id="notify_all">
                <label class="form-check-label" for="notify_all">
                    Notify all church members.
                </label>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success px-4">
                    <i class="ti ti-send"></i> Publish & Send Notifications
                </button>
                <a href="{{ route('churchly.events.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<!-- ✅ Select2 (CDN version, no extra setup needed) -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    $('.searchable-select').select2({
        placeholder: 'Search and select...',
        width: '100%',
        allowClear: true,
        closeOnSelect: false
    });
});
</script>
@endsection

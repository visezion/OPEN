@php
    $payload = $feedback->report_payload ?? [];
    $sections = [
        __('Activities & Achievements') => [$payload['activities'] ?? null, $payload['achievements'] ?? null],
        __('Service Report') => [$payload['service_tasks'] ?? null, $payload['service_observations'] ?? null],
        __('Challenges & Support') => [$payload['challenges'] ?? null, $payload['support_needed'] ?? null],
        __('Plans & Suggestions') => [$payload['plans'] ?? null, $payload['recommendations'] ?? null],
    ];
@endphp

<div class="d-grid gap-3">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Report Overview') }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small">{{ __('Week Ending') }}</div>
                        <div class="fw-semibold">{{ $feedback->week_ending_formatted }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small">{{ __('Department') }}</div>
                        <div class="fw-semibold">{{ optional($feedback->department)->name ?? __('General') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 bg-light">
                        <div class="text-muted small">{{ __('Submitted By') }}</div>
                        <div class="fw-semibold">{{ $feedback->is_anonymous ? __('Anonymous') : ($feedback->name ?? __('Unknown')) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Attendance Snapshot') }}</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small">{{ __('Source') }}</div>
                        <div class="fw-semibold">{{ $attendanceSummary['source_label'] ?? __('Not linked') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small">{{ __('Attendance Rate') }}</div>
                        <div class="fw-semibold">{{ $attendanceSummary['attendance_rate'] ?? 0 }}%</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small">{{ __('Total') }}</div>
                        <div class="fw-semibold">{{ $attendanceSummary['total_members'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small">{{ __('Present') }}</div>
                        <div class="fw-semibold text-success">{{ $attendanceSummary['present_count'] ?? 0 }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="border rounded-3 p-3 bg-light h-100">
                        <div class="text-muted small">{{ __('Absent') }}</div>
                        <div class="fw-semibold text-danger">{{ $attendanceSummary['absent_count'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($sections as $title => $parts)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                @php $content = collect($parts)->filter()->implode(''); @endphp
                @if($content)
                    {!! $content !!}
                @else
                    <p class="text-muted mb-0">{{ __('No details provided.') }}</p>
                @endif
            </div>
        </div>
    @endforeach

    @if($feedback->attachment)
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Attachment') }}</h5>
            </div>
            <div class="card-body">
                @php
                    $fileName = basename($feedback->attachment);
                @endphp
                <a href="{{ route('feedback.download', $fileName) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                    <i class="ti ti-download me-1"></i>{{ __('Open Attachment') }}
                </a>
            </div>
        </div>
    @endif
</div>

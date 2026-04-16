<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $event->title }} - Event Report</title>
    <link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/event-report.css') }}">
</head>
<body>
@php
    $eventStart = $event->start_time ? \Carbon\Carbon::parse($event->start_time) : null;
    $eventEnd = $event->end_time ? \Carbon\Carbon::parse($event->end_time) : null;
    $cursor = $eventStart ? $eventStart->copy() : null;
@endphp

<h1>{{ $event->title }}</h1>

<div class="meta">
    <p><strong>Type:</strong> {{ ucfirst((string) $event->event_type) }}</p>
    <p><strong>Status:</strong> {{ ucfirst((string) $event->status) }}</p>
    <p><strong>Venue:</strong> {{ $event->venue ?: '-' }}</p>
    <p><strong>Date:</strong> {{ $eventStart ? $eventStart->format('d M Y') : '-' }}</p>
    <p><strong>Start Time:</strong> {{ $eventStart ? $eventStart->format('g:i A') : '-' }}</p>
    <p><strong>End Time:</strong> {{ $eventEnd ? $eventEnd->format('g:i A') : '-' }}</p>
    <p><strong>Recurrence:</strong> {{ ucfirst((string) ($event->recurrence ?: 'none')) }}</p>
    @if(!empty($event->description))
        <p><strong>Description:</strong> {{ $event->description }}</p>
    @endif
</div>

<h2>Program Schedule</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Program Item</th>
            <th>Duration</th>
            <th>Time Range</th>
            <th>Leader</th>
        </tr>
    </thead>
    <tbody>
        @forelse($event->programs as $i => $p)
            @php
                $durationMinutes = max(0, (int) ($p->duration ?? 0));
                $timeRange = '-';

                if ($cursor) {
                    $slotStart = $cursor->copy();
                    $slotEnd = $slotStart->copy()->addMinutes($durationMinutes);

                    if ($eventEnd && $slotEnd->gt($eventEnd)) {
                        $slotEnd = $eventEnd->copy();
                    }

                    $timeRange = $slotStart->format('g:i A') . ' - ' . $slotEnd->format('g:i A');
                    $cursor = $slotEnd->copy();
                }
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->program_item }}</td>
                <td>{{ $durationMinutes }} min</td>
                <td>{{ $timeRange }}</td>
                <td>{{ $p->leader->name ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="event-report-empty-cell">No program items added.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<footer>
    Generated on {{ now()->format('d M Y, g:i A') }}
</footer>

<div class="brand">
    Copyright {{ now()->format('Y') }} ChurchMeet Event System - Automated Report
</div>

</body>
</html>

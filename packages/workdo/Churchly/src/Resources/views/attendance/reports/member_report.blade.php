@extends('layouts.main')

@section('page-title', __('Member Attendance Report'))

@section('content')
<div class="card p-4 shadow-sm">
    <h5>{{ $member->name }} - {{ __('Attendance Report') }}</h5>
    <p><strong>Total Events Attended:</strong> {{ $member->attendanceRecords->count() }}</p>
    <p><strong>Attendance %:</strong> 
        {{ round(($member->attendanceRecords->where('status','present')->count() / max(1,$member->attendanceRecords->count())) * 100, 1) }}%
    </p>
    <p><strong>Longest Streak:</strong> {{ $member->attendanceRecords->max('streak_count') ?? 0 }}</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>{{ __('Event') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Device') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($member->attendanceRecords as $record)
            <tr>
                <td>{{ $record->attendanceEvent->event->title }}</td>
                <td>{{ $record->attendanceEvent->event->date }}</td>
                <td>{{ ucfirst($record->status) }}</td>
                <td>{{ strtoupper($record->device_used) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


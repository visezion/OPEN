@extends('layouts.main')

@section('page-title', __('Event Attendance Report'))

@section('content')
<div class="card p-4 shadow-sm">
    <h5>{{ $attendanceEvent->event->title }} - {{ $attendanceEvent->event->date }}</h5>

    <p><strong>Total Attendance:</strong> {{ $attendanceEvent->records->count() }}</p>
    <p><strong>Onsite:</strong> {{ $attendanceEvent->records->whereIn('device_used',['manual','qr','kiosk','face_ai'])->count() }}</p>
    <p><strong>Online:</strong> {{ $attendanceEvent->records->whereIn('device_used',['online','zoom','youtube'])->count() }}</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>{{ __('Member') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Check-In') }}</th>
                <th>{{ __('Device') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendanceEvent->records as $record)
            <tr>
                <td>{{ $record->member->name ?? 'Visitor' }}</td>
                <td>{{ ucfirst($record->status) }}</td>
                <td>{{ $record->check_in_time }}</td>
                <td>{{ strtoupper($record->device_used) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

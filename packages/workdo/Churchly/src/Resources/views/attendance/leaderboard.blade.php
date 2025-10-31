@extends('layouts.main')

@section('page-title', __('Attendance Leaderboard'))

@section('content')
<div class="card shadow-sm p-4">
    <h5>{{ __('Leaderboard for') }} {{ date('F Y') }}</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('Rank') }}</th>
                <th>{{ __('Member') }}</th>
                <th>{{ __('XP Points') }}</th>
                <th>{{ __('Attendance Count') }}</th>
                <th>{{ __('Longest Streak') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaderboard as $rank => $entry)
            <tr>
                <td>{{ $rank+1 }}</td>
                <td>{{ $entry->member->name ?? 'Unknown' }}</td>
                <td>{{ $entry->member->attendanceRecords->sum('xp_points') }}</td>
                <td>{{ $entry->attendance_count }}</td>
                <td>{{ $entry->streak_longest }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

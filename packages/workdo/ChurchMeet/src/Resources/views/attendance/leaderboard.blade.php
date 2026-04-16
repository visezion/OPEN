@extends('layouts.main')

@section('page-title', __('Attendance Leaderboard'))
@section('page-breadcrumb', __('ChurchMeet,Attendance Leaderboard'))

@push('css')
<link rel="stylesheet" href="{{ asset('packages/workdo/ChurchMeet/src/Resources/assets/css/churchmeet-shared.css') }}">
@endpush

@section('content')
@php
    $topEntry = $leaderboard->first();
    $topPoints = $topEntry?->member?->attendanceRecords->sum('xp_points') ?? 0;
    $bestStreak = $leaderboard->max('streak_longest') ?? 0;
@endphp

<div class="churchmeet-shell">
    <div class="card churchmeet-hero mb-4">
        <div class="churchmeet-hero-body">
            <span class="churchmeet-kicker"><i class="ti ti-trophy"></i>{{ __('ChurchMeet Leaderboard') }}</span>
            <h2 class="churchmeet-title">{{ __('Attendance Champions for :month', ['month' => date('F Y')]) }}</h2>
            <p class="churchmeet-copy mb-0">{{ __('Celebrate consistency, surface top engagement, and keep the attendance experience visually aligned with the rest of ChurchMeet.') }}</p>

            <div class="churchmeet-stat-grid">
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Ranked Members') }}</span>
                    <strong class="churchmeet-stat-value">{{ $leaderboard->count() }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Members currently visible in this leaderboard.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Top XP') }}</span>
                    <strong class="churchmeet-stat-value">{{ $topPoints }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Highest total experience points earned so far.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Best Streak') }}</span>
                    <strong class="churchmeet-stat-value">{{ $bestStreak }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Longest attendance streak recorded on the board.') }}</span>
                </div>
                <div class="churchmeet-stat-card">
                    <span class="churchmeet-stat-label">{{ __('Current Leader') }}</span>
                    <strong class="churchmeet-stat-value">{{ \Illuminate\Support\Str::limit(optional(optional($topEntry)->member)->name ?? __('N/A'), 14) }}</strong>
                    <span class="churchmeet-stat-note">{{ __('Member currently sitting at the top of the rankings.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="churchmeet-section">
        <div class="churchmeet-section-head">
            <h5>{{ __('Leaderboard Table') }}</h5>
            <p>{{ __('A consistent branded view of attendance performance, points, and streaks across the month.') }}</p>
        </div>
        <div class="table-responsive">
            <table class="table churchmeet-table align-middle mb-0">
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
                    @forelse($leaderboard as $rank => $entry)
                        @php
                            $xpPoints = $entry->member->attendanceRecords->sum('xp_points');
                        @endphp
                        <tr>
                            <td><span class="churchmeet-badge {{ $rank === 0 ? 'success' : ($rank < 3 ? 'warning' : '') }}">#{{ $rank + 1 }}</span></td>
                            <td class="fw-semibold">{{ $entry->member->name ?? __('Unknown') }}</td>
                            <td>{{ $xpPoints }}</td>
                            <td>{{ $entry->attendance_count }}</td>
                            <td>{{ $entry->streak_longest }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">{{ __('No leaderboard data is available yet.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

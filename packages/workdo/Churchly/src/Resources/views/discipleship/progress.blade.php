@extends('layouts.main')

@section('page-title', __('Discipleship Progress Tracking'))

@section('content')
<div class="row">
    {{-- Left Sidebar --}}
    

    {{-- Main Table --}}
    <div class="col-sm-9">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-users text-primary"></i> {{ __('Member Progress') }}</h5>
                <p class="text-muted small mb-3">
                    {{ __('Track each member’s discipleship journey by stage and requirement.') }}
                </p>

                {{-- Filters --}}
                <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                        <select name="stage_id" class="form-control">
                            <option value="">{{ __('-- Stage --') }}</option>
                            @foreach($stages as $stage)
                                <option value="{{ $stage->id }}" {{ request('stage_id')==$stage->id?'selected':'' }}>
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="member_id" class="form-control">
                            <option value="">{{ __('-- Member --') }}</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}" {{ request('member_id')==$member->id?'selected':'' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">{{ __('-- Status --') }}</option>
                            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                            <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option>
                            <option value="completed" {{ request('status')=='completed'?'selected':'' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <button class="btn btn-sm btn-primary"><i class="ti ti-filter"></i> {{ __('Filter') }}</button>
                        <a href="{{ route('discipleship.progress') }}" class="btn btn-sm btn-secondary">{{ __('Reset') }}</a>
                    </div>
                </form>

                {{-- Progress Table --}}
                @if($progress->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Member') }}</th>
                                    <th>{{ __('Stage') }}</th>
                                    <th>{{ __('Requirement') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Completed At') }}</th>
                                    <th>{{ __('Reviewed By') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($progress as $p)
                                    <tr>
                                        <td>{{ $p->member->name ?? '-' }}</td>
                                        <td>{{ $p->stage->name ?? '-' }}</td>
                                        <td>{{ $p->requirement->title ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $p->status=='completed'?'bg-success':($p->status=='in_progress'?'bg-warning text-dark':'bg-secondary') }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $p->completed_at ? $p->completed_at->format('d M Y') : '-' }}</td>
                                        <td>{{ $p->reviewedBy->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">{{ __('No progress records found.') }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Help --}}
    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('Progress Tracking Help') }}</h6>
                <p class="small text-muted">
                    {{ __('Use this page to monitor member discipleship progress. You can filter by stage, member, or status.') }}
                </p>
                <ul class="small text-muted ps-3">
                    <li>👥 See which stage each member is in</li>
                    <li>✅ Track requirement completion</li>
                    <li>📝 Check approvals by mentors</li>
                </ul>
                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> Export progress for quarterly discipleship reports.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

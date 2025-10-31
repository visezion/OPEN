@extends('layouts.main')

@section('page-title', __('Discipleship Approvals'))

@section('content')
<div class="container-fluid py-4">
    <div class="p-4 bg-white shadow rounded-3">
        <h5 class="fw-bold mb-3">
            <i class="ti ti-checks text-success"></i> {{ __('Requested Approvals') }}
        </h5>

        <p class="small text-muted">
            {{ __('Below are the discipleship requirements submitted by members that need review. Pastors or admins can approve or reject each request.') }}
        </p>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>{{ __('Member') }}</th>
                    <th>{{ __('Stage') }}</th>
                    <th>{{ __('Requirement') }}</th>
                    <th>{{ __('Evidence') }}</th>
                    <th>{{ __('Submitted At') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th class="text-center">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingProgress as $progress)
                    <tr>
                        <td>{{ $progress->member->name }}</td>
                        <td>{{ $progress->stage->name }}</td>
                        <td>{{ $progress->requirement->title }}</td>
                        <td>
                            @if($progress->evidence)
                                @if(Str::startsWith($progress->evidence, 'discipleship/evidence'))
                                    <a href="{{ asset('storage/'.$progress->evidence) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="ti ti-file"></i> {{ __('View File') }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ $progress->evidence }}</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $progress->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">{{ ucfirst($progress->status) }}</span>
                        </td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('discipleship.requirement.review', $progress->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button class="btn btn-success btn-sm">
                                    <i class="ti ti-check"></i> {{ __('Approve') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('discipleship.requirement.review', $progress->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button class="btn btn-danger btn-sm">
                                    <i class="ti ti-x"></i> {{ __('Reject') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            <i class="ti ti-inbox"></i> {{ __('No pending approval requests at the moment.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

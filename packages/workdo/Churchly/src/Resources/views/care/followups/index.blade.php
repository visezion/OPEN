@extends('layouts.main')

@section('page-title', __('Follow-up Workflow'))

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0">{{ __('Quick Create Follow-up') }}</h6></div>
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.care.followups.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Member') }}</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">{{ __('Select member') }}</option>
                            @foreach($members as $id => $name)
                                <option value="{{ $id }}" {{ old('member_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Subject') }}</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Notes / Instructions') }}</label>
                        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Due date') }}</label>
                        <input type="date" name="due_at" value="{{ old('due_at') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Assign to') }}</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">{{ __('Unassigned') }}</option>
                            @foreach($careTeamUsers as $id => $name)
                                <option value="{{ $id }}" {{ old('assigned_to') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select" required>
                            @foreach(['open','in_progress','completed','cancelled'] as $status)
                                <option value="{{ $status }}" {{ old('status', 'open') == $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ', $status)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary">{{ __('Create Follow-up') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Member') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Due') }}</th>
                            <th>{{ __('Assignee') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($followups as $followup)
                            <tr>
                                <td>{{ optional($followup->member)->name ?? '-' }}</td>
                                <td>{{ $followup->subject }}</td>
                                <td><span class="badge bg-info text-uppercase">{{ $followup->status }}</span></td>
                                <td class="small text-muted">{{ optional($followup->due_at)->format('Y-m-d') ?? '—' }}</td>
                                <td>{{ optional($followup->assignee)->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('No follow-ups found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $followups->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.main')

@section('page-title', __('Reports Management'))
@section('page-breadcrumb', __('Reports Dashboard'))

@section('page-action')
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="{{ __('Reports Dashboard') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="{{ route('feedback.create') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus me-1"></i>{{ __('New Report') }}
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            <form method="GET" action="{{ route('feedback.index') }}" class="row mb-3 g-2 align-items-end">
                <div class="col-md-2 d-flex align-items-center">
                    <label class="form-label me-2 mb-0" for="per_page">{{ __('Pages:') }}</label>
                    <select name="per_page" id="per_page" class="form-control form-control-sm w-auto me-2">
                        @foreach ([10, 15, 25, 50, 100] as $size)
                            <option value="{{ $size }}" {{ request('per_page', 15) == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    <span class="form-label mb-0">{{ __('entries') }}</span>
                </div>

                <div class="col-md-2">
                    <select name="type" class="form-control form-control-sm">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="internal" {{ request('type') == 'internal' ? 'selected' : '' }}>{{ __('Internal') }}</option>
                        <option value="public" {{ request('type') == 'public' ? 'selected' : '' }}>{{ __('Public') }}</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-control form-control-sm">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>{{ __('Reviewed') }}</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search title or summary') }}" value="{{ request('search') }}">
                </div>

                <div class="col-md-1">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="ti ti-filter"></i>
                    </button>
                </div>
            </form>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>{{ __('Department') }}</th>
                        <th>{{ __('Week Ending') }}</th>
                        <th>{{ __('Report') }}</th>
                        <th>{{ __('Attendance') }}</th>
                        <th>{{ __('Submitted By') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $item)
                        <tr>
                            <td>{{ $item->department->name ?? __('No Department') }}</td>
                            <td>{{ $item->week_ending_formatted }}</td>
                            <td>
                                <div class="fw-semibold">{{ $item->title ?? __('Untitled Report') }}</div>
                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($item->message ?? ''), 80) }}</div>
                            </td>
                            <td>
                                @if($item->attendance_rate !== null)
                                    <span class="badge bg-light text-dark">{{ $item->attendance_rate }}%</span>
                                @else
                                    <span class="text-muted">{{ __('Not linked') }}</span>
                                @endif
                            </td>
                            <td>{{ $item->is_anonymous ? __('Anonymous') : ($item->name ?? 'N/A') }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'reviewed' ? 'primary' : 'success') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                @permission('feedback review')
                                    <a href="{{ route('feedback.review', Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-outline-primary" title="{{ __('Review') }}"><i class="ti ti-file"></i></a>
                                @endpermission
                                <a href="{{ route('feedback.show', Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-outline-info" title="{{ __('View') }}"><i class="ti ti-eye"></i></a>
                                @permission('feedback edit')
                                    <a href="{{ route('feedback.edit', Crypt::encrypt($item->id)) }}" class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
                                @endpermission
                                @permission('feedback delete')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['feedback.destroy', Crypt::encrypt($item->id)], 'class' => 'd-inline']) !!}
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete') }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
                                @endpermission
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">{{ __('No reports found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($feedbacks->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap small text-muted">
                    <div class="mb-2 mb-md-0">
                        {{ __('Showing') }} <strong>{{ $feedbacks->firstItem() }}</strong> {{ __('to') }} <strong>{{ $feedbacks->lastItem() }}</strong> {{ __('of') }} <strong>{{ $feedbacks->total() }}</strong> {{ __('results') }}
                    </div>
                    <div>{{ $feedbacks->links('pagination::bootstrap-5') }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection

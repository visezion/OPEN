@extends('layouts.main')

@section('page-title')
    {{ __('Volunteer Skills') }}
@endsection

@section('page-breadcrumb')
    <a href="{{ route('churchly.volunteers.index') }}">{{ __('Volunteers') }}</a> /
    {{ __('Skills Library') }}
@endsection

@section('page-action')
    @permission('church_volunteer create')
        <a href="{{ route('churchly.volunteer-skills.create') }}"
           class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Skill') }}
        </a>
    @endpermission
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Skill Directory') }}</h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Volunteers Tagged') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($skills as $skill)
                            <tr>
                                <td class="fw-semibold">{{ $skill->name }}</td>
                                <td>{{ $skill->category ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $skill->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $skill->is_active ? __('Active') : __('Archived') }}
                                    </span>
                                </td>
                                <td>{{ $skill->volunteers_count }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <!-- Edit Button -->
                                        <a href="{{ route('churchly.volunteer-skills.edit', $skill) }}"
                                           class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="{{ __('Edit Skill') }}">
                                            <i class="ti ti-pencil"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        {!! Form::open([
                                            'route' => ['churchly.volunteer-skills.destroy', $skill],
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".__('Are you sure you want to delete this skill?')."');"
                                        ]) !!}
                                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{ __('Delete Skill') }}">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    @include('layouts.nodatafound')  <!-- Ensure this view exists -->
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $skills->links() }}
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('page-title')
    {{ __('Manage Church Members') }}
@endsection

@section('page-breadcrumb')
    {{ __('Church Members') }}
@endsection

@section('page-action')
    <div class="d-flex">
        <a href="{{ route('churchly.members.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Add New Member') }}">
            <i class="ti ti-plus"></i> 
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('DOB') }}</th>
                                <th>{{ __('Address') }}</th>
                                <th class="text-end">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email ?? '-' }}</td>
                                    <td>{{ $member->phone ?? '-' }}</td>
                                    <td>{{ $member->dob ?? '-' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($member->address, 30) ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('members.show', $member->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>
                                        <a href="{{ route('churchly.members.edit', $member->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                            <i class="ti ti-pencil text-white"></i>
                                        </a>

                                        <form action="{{ route('churchly.members.destroy', $member->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger show_confirm" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                <i class="ti ti-trash text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">{{ __('No members found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('page-title', __('Designations'))

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>{{ __('Church Designations') }}</h5>
        <a href="{{ route('churchdesignation.create') }}" class="btn btn-sm btn-primary">{{ __('Add Designation') }}</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Branch') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($designations as $designation)
                    <tr>
                        <td>{{ $designation->name }}</td>
                        <td>{{ $designation->branch->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('churchdesignation.edit', $designation) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
                            <form action="{{ route('churchdesignation.destroy', $designation) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">{{ __('No designations found.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

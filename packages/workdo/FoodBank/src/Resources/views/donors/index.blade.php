@extends('layouts.main')

@section('page-title', __('Donors'))
@section('page-action')
    <a href="{{ route('foodbank.donors.create') }}" class="btn btn-primary">{{ __('Add donor') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Contact') }}</th>
                        <th>{{ __('Preferred') }}</th>
                        <th class="text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donors as $donor)
                        <tr>
                            <td>{{ $donor->name }}</td>
                            <td>{{ $donor->phone }}<br>{{ $donor->email }}</td>
                            <td>
                                {{ $donor->preferred_pickup }} / {{ $donor->preferred_delivery }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('foodbank.donors.edit', $donor) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                <form action="{{ route('foodbank.donors.destroy', $donor) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Delete donor?') }}');">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $donors->links() }}
        </div>
    </div>
@endsection

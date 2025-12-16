@extends('layouts.main')

@section('page-title', __('Food Bank Requests'))
@section('page-action')
    <a href="{{ route('foodbank.requests.create') }}" class="btn btn-primary">{{ __('New request') }}</a>
@endsection

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1">{{ __('Pending') }}</p>
                    <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1">{{ __('Approved') }}</p>
                    <h3 class="mb-0">{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1">{{ __('Rejected') }}</p>
                    <h3 class="mb-0">{{ $stats['rejected'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <p class="text-uppercase small text-muted mb-1">{{ __('Total requests') }}</p>
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form class="row gy-2 gx-3 align-items-end" method="get">
                <div class="col-md-3">
                    <label class="form-label small">{{ __('Status') }}</label>
                    <select name="status" class="form-select">
                        <option value="">{{ __('Any status') }}</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['status'] ?? '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">{{ __('Delivery') }}</label>
                    <select name="delivery_preference" class="form-select">
                        <option value="">{{ __('Any option') }}</option>
                        @foreach($deliveryOptions as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['delivery_preference'] ?? '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">{{ __('Search') }}</label>
                    <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="{{ __('Name, phone, email') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">{{ __('Filter') }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Delivery') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Updated') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $entry)
                            <tr>
                                <td>
                                    <strong>{{ $entry->requester_name }}</strong><br>
                                    <small class="text-muted">{{ $entry->phone }} &bull; {{ $entry->email ?? __('Not provided') }}</small>
                                </td>
                                <td>{{ $deliveryOptions[$entry->delivery_preference] ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $entry->status === 'approved' ? 'success' : ($entry->status === 'rejected' ? 'danger' : 'secondary') }}">
                                        {{ $statusOptions[$entry->status] ?? ucfirst($entry->status) }}
                                    </span>
                                </td>
                                <td>{{ $entry->updated_at->diffForHumans() }}</td>
                                <td class="text-end">
                                    <a href="{{ route('foodbank.requests.show', $entry) }}" class="btn btn-sm btn-light">{{ __('View') }}</a>
                                    <a href="{{ route('foodbank.requests.edit', $entry) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
                                    <form action="{{ route('foodbank.requests.destroy', $entry) }}" method="post" class="d-inline-block" onsubmit="return confirm('{{ __('Delete request?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('No requests found yet.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $requests->links() }}
        </div>
    </div>
@endsection

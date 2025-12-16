@extends('layouts.main')

@section('page-title', __('Request details'))
@section('page-action')
    <div class="btn-group">
        <a href="{{ route('foodbank.requests.edit', $requestEntry) }}" class="btn btn-sm btn-outline-secondary">{{ __('Edit') }}</a>
        <a href="{{ route('foodbank.requests.approve', $requestEntry) }}" class="btn btn-sm btn-outline-success">{{ __('Approve') }}</a>
        <a href="{{ route('foodbank.requests.reject', $requestEntry) }}" class="btn btn-sm btn-outline-danger">{{ __('Reject') }}</a>
    </div>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $requestEntry->requester_name }}</h5>
                    <p class="text-muted mb-3">{{ $requestEntry->phone }} &bull; {{ $requestEntry->email ?? __('No email provided') }}</p>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>{{ __('Status') }}</strong>
                            <div>{{ $statusOptions[$requestEntry->status] ?? ucfirst($requestEntry->status) }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>{{ __('Delivery') }}</strong>
                            <div>{{ $deliveryOptions[$requestEntry->delivery_preference] ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <strong>{{ __('Family size') }}</strong>
                            <div>{{ $requestEntry->family_size ?? '-' }}</div>
                        </div>
                    </div>
                    <p><strong>{{ __('Occupation') }}:</strong> {{ $requestEntry->occupation ?? __('Not provided') }}</p>
                    <p><strong>{{ __('Children') }}:</strong> {{ $requestEntry->children_count ?? '0' }}</p>
                    <div class="mb-3">
                        <strong>{{ __('Needs summary') }}</strong>
                        <p>{{ $requestEntry->needs_description ?? __('No details yet.') }}</p>
                    </div>
                    @if($requestEntry->delivery_preference === 'delivery')
                        <div class="mb-3">
                            <strong>{{ __('Delivery address') }}</strong>
                            <p>{{ $requestEntry->delivery_address ?? __('Not provided') }}</p>
                            @if($requestEntry->delivery_map)
                                <a href="{{ $requestEntry->delivery_map }}" target="_blank" class="d-block small text-decoration-none">
                                    {{ __('Open map link') }}
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="mb-3">
                            <strong>{{ __('Pickup location') }}</strong>
                            <p>{{ $requestEntry->pickup_location ?? __('Not provided') }}</p>
                        </div>
                    @endif
                    <div>
                        <strong>{{ __('Notifications') }}</strong>
                        <p class="small text-muted">{{ implode(', ', $requestEntry->notify_channels ?? []) ?: __('None') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body">
                    <p class="small text-muted">{{ __('Last updated') }}</p>
                    <h4>{{ $requestEntry->updated_at->format('d M Y, h:i A') }}</h4>
                    <p class="text-muted mb-0">{{ $requestEntry->updated_at->diffForHumans() }}</p>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="mb-1 text-uppercase small text-muted">{{ __('Statuses') }}</p>
                    <div class="d-flex flex-column gap-2">
                        @foreach($statusOptions as $key => $label)
                            <div class="d-flex justify-content-between">
                                <span>{{ $label }}</span>
                                <small class="text-muted">{{ $requestEntry->status === $key ? __('Current') : '' }}</small>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <p class="text-muted small mb-0">{{ __('Approved by') }}: {{ $requestEntry->approved_by ? $requestEntry->approved_by : __('Pending') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

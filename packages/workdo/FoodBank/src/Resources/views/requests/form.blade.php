@php $isEdit = !empty($requestEntry); @endphp

@extends('layouts.main')

@section('page-title', $isEdit ? __('Edit request') : __('New request'))
@section('page-action')
    <a href="{{ route('foodbank.requests.index') }}" class="btn btn-outline-secondary">{{ __('Back to list') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ $isEdit ? route('foodbank.requests.update', $requestEntry) : route('foodbank.requests.store') }}">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Full name') }}</label>
                        <input type="text" name="requester_name" value="{{ old('requester_name', $requestEntry->requester_name ?? '') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Occupation') }}</label>
                        <input type="text" name="occupation" value="{{ old('occupation', $requestEntry->occupation ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Marital status') }}</label>
                        <select name="marital_status" class="form-select" id="fb-marital">
                            <option value="">{{ __('None') }}</option>
                            <option value="single" {{ old('marital_status', $requestEntry->marital_status ?? '') === 'single' ? 'selected' : '' }}>{{ __('Single') }}</option>
                            <option value="married" {{ old('marital_status', $requestEntry->marital_status ?? '') === 'married' ? 'selected' : '' }}>{{ __('Married') }}</option>
                            <option value="other" {{ old('marital_status', $requestEntry->marital_status ?? '') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Family size') }}</label>
                        <input type="number" name="family_size" min="1" value="{{ old('family_size', $requestEntry->family_size ?? 1) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Children at home') }}</label>
                        <input type="number" name="children_count" min="0" value="{{ old('children_count', $requestEntry->children_count ?? 0) }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('Phone') }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $requestEntry->phone ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" value="{{ old('email', $requestEntry->email ?? '') }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('Delivery option') }}</label>
                        <select name="delivery_preference" class="form-select" id="fb-delivery">
                            <option value="">{{ __('Choose option') }}</option>
                            @foreach($deliveryOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('delivery_preference', $requestEntry->delivery_preference ?? '') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ __('Pickup location') }}</label>
                        <input type="text" name="pickup_location" value="{{ old('pickup_location', $requestEntry->pickup_location ?? '') }}" class="form-control">
                    </div>

                    <div id="delivery-fields" class="row g-3" style="display: none;">
                        <div class="col-md-12">
                            <label class="form-label">{{ __('Delivery address') }}</label>
                            <textarea name="delivery_address" class="form-control" rows="2">{{ old('delivery_address', $requestEntry->delivery_address ?? '') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('Map link') }}</label>
                            <input type="url" name="delivery_map" value="{{ old('delivery_map', $requestEntry->delivery_map ?? '') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Latitude') }}</label>
                            <input type="text" name="delivery_lat" value="{{ old('delivery_lat', $requestEntry->delivery_lat ?? '') }}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Longitude') }}</label>
                            <input type="text" name="delivery_lng" value="{{ old('delivery_lng', $requestEntry->delivery_lng ?? '') }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ __('Describe your needs') }}</label>
                        <textarea name="needs_description" rows="3" class="form-control">{{ old('needs_description', $requestEntry->needs_description ?? '') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ __('Status') }}</label>
                        <select name="status" class="form-select">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $requestEntry->status ?? 'pending') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">{{ __('Notification channels') }}</label>
                        <div class="d-flex gap-3 flex-wrap">
                            @foreach(['email' => 'Email', 'whatsapp' => 'WhatsApp', 'sms' => 'SMS'] as $channel => $label)
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="notify_channels[]" value="{{ $channel }}"
                                           {{ in_array($channel, old('notify_channels', $requestEntry->notify_channels ?? []), true) ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ __($label) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary">{{ $isEdit ? __('Update request') : __('Create request') }}</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const deliverySelect = document.getElementById('fb-delivery');
                const deliveryFields = document.getElementById('delivery-fields');

                function toggleDelivery() {
                    deliveryFields.style.display = deliverySelect.value === 'delivery' ? 'flex' : 'none';
                }

                deliverySelect.addEventListener('change', toggleDelivery);
                toggleDelivery();
            });
        </script>
    @endpush
@endsection

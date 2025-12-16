@extends('foodbank::public.layout')

@section('title', __('Donate to Food Bank'))
@section('content')
    <div class="note mb-3">
        <h2>{{ __('Donate food or essentials') }}</h2>
        <p class="text-muted">{{ __('Tell us what you have available so we can match it with families in need.') }}</p>
    </div>
    <form id="donationForm" action="{{ route('foodbank.public.donate.submit', $token) }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="grid">
            <div class="field">
                <label>{{ __('Item name') }}</label>
                <input type="text" name="item_name" required>
            </div>
            <div class="field">
                <label>{{ __('Category') }}</label>
                <input type="text" name="category">
            </div>
            <div class="field">
                <label>{{ __('Quantity') }}</label>
                <input type="number" name="quantity" min="1" value="1" required>
            </div>
            <div class="field">
                <label>{{ __('Unit') }}</label>
                <input type="text" name="unit" value="pcs">
            </div>
            <div class="field">
                <label>{{ __('Pickup location') }}</label>
                <input type="text" name="pickup_location">
            </div>
            <div class="field">
                <label>{{ __('Delivery details') }}</label>
                <input type="text" name="delivery_details">
            </div>
            <div class="field full">
                <label>{{ __('Tell us more') }}</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div class="field full">
                <label>{{ __('Stay updated via') }}</label>
                <div class="d-flex gap-2">
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="email" checked> {{ __('Email') }}</label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="whatsapp"> {{ __('WhatsApp') }}</label>
                    <label class="radio-label"><input type="checkbox" name="notify_channels[]" value="sms"> {{ __('SMS') }}</label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button class="btn-wide" type="submit">{{ __('Submit donation') }}</button>
        </div>
    </form>

    <div class="summary-grid mt-4">
        <div><span>{{ __('Recent sharing') }}:</span> <span>{{ __('Every donation is logged by admins and matched with requests.') }}</span></div>
    </div>

    @if(!empty($adminStats))
        <div class="admin-panel">
            <h3>{{ __('Workspace snapshot') }}</h3>
            <div class="summary-grid">
                <div><span>{{ __('Donors registered') }}:</span> <strong>{{ $adminStats['donors'] }}</strong></div>
                <div><span>{{ __('Inventory items') }}:</span> <strong>{{ $adminStats['inventory_items'] }}</strong></div>
                <div><span>{{ __('Pending requests') }}:</span> <strong>{{ $adminStats['pending_requests'] }}</strong></div>
            </div>
            <div class="field mt-3">
                <label>{{ __('Share donation link') }}</label>
                <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
                    <input id="admin-donate-link" type="text" readonly value="{{ $adminStats['publicDonateLink'] }}" style="flex:1; min-width:200px;">
                    <button class="btn-wide" id="copy-donate-link" type="button">{{ __('Copy link') }}</button>
                </div>
            </div>
            <div class="field mt-3">
                <label>{{ __('Share request link') }}</label>
                <input type="text" readonly value="{{ $adminStats['publicRequestLink'] }}">
            </div>
            <div class="admin-links">
                <a class="btn-wide" href="{{ route('foodbank.donors.index') }}">{{ __('Manage donors') }}</a>
                <a class="btn-wide" href="{{ route('foodbank.inventory.index') }}">{{ __('View inventory') }}</a>
                <a class="btn-wide" href="{{ route('foodbank.requests.index') }}">{{ __('View requests') }}</a>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const copyButton = document.getElementById('copy-donate-link');
            const copyTarget = document.getElementById('admin-donate-link');
            if (copyButton && copyTarget) {
                copyButton.addEventListener('click', () => {
                    copyTarget.select();
                    document.execCommand('copy');
                    const original = copyButton.textContent;
                    copyButton.textContent = '{{ __('Copied') }}';
                    setTimeout(() => {
                        copyButton.textContent = original;
                    }, 1500);
                });
            }
        });
    </script>
@endpush

@extends('layouts.main')

@section('page-title', __('SMS Gateway Settings'))

@section('content')
<div class="row">
    {{-- Left Sidebar --}}
    <div class="col-sm-3">
        @include('churchly::layouts.churchly_setup')
    </div>

    {{-- Main Settings Form --}}
    <div class="col-sm-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-settings text-primary"></i> {{ __('Zender Credential Settings') }}</h5>
                <p class="text-muted small mb-4">
                    {{ __('Configure your Zender credentials here to enable WhatsApp and SMS messaging inside Churchly. Once saved, these settings will be used automatically whenever messages are sent.') }}
                </p>

                <form method="POST" action="{{ route('sms-gateway.update') }}">
                    @csrf

                    {{-- Zender Site URL --}}
                    <div class="mb-3">
                        <label class="fw-bold">Zender Site URL</label>
                        <small class="form-text text-muted d-block">
                            {{ __('Enter the full Zender domain. Do not add a trailing slash.') }}
                        </small>
                        <input type="text" name="url" value="{{ $config['url'] ?? 'https://zender.vicezion.com' }}" class="form-control" required>
                    </div>

                    {{-- Zender API Key --}}
                    <div class="mb-3">
                        <label class="fw-bold">Zender API Key</label>
                        <small class="form-text text-muted d-block">
                            {{ __('Paste your API key from Zender. Ensure it has permissions:') }} 
                            <code>sms_send</code>, <code>wa_send</code>.
                        </small>
                        <input type="text" name="token" value="{{ $config['token'] ?? '' }}" class="form-control" required>
                    </div>

                    {{-- Service Selector --}}
                    <div class="mb-3">
                        <label class="fw-bold">Service</label>
                        <small class="form-text text-muted d-block">
                            {{ __('Select the default channel to use for sending messages. You may still override per-message.') }}
                        </small>
                        <select name="service" class="form-control" required>
                            <option value="whatsapp" {{ ($config['service'] ?? '') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="sms" {{ ($config['service'] ?? '') == 'sms' ? 'selected' : '' }}>SMS</option>
                        </select>
                    </div>

                    {{-- WhatsApp Account ID --}}
                    <div class="mb-3">
                        <label class="fw-bold">WhatsApp Account ID</label>
                        <small class="form-text text-muted d-block">
                            {{ __('Required for WhatsApp service. Copy the account ID from your Zender dashboard.') }}
                        </small>
                        <input type="text" name="whatsapp" value="{{ $config['whatsapp'] ?? '' }}" class="form-control">
                    </div>

                    {{-- Device Unique ID --}}
                    <div class="mb-3">
                        <label class="fw-bold">Device Unique ID</label>
                        <small class="form-text text-muted d-block">
                            {{ __('Required for SMS service (linked Android device). Leave blank if using WhatsApp only.') }}
                        </small>
                        <input type="text" name="device" value="{{ $config['device'] ?? '' }}" class="form-control">
                    </div>

                    {{-- Gateway Unique ID --}}
                    <div class="mb-3">
                        <label class="fw-bold">Gateway Unique ID</label>
                        <small class="form-text text-muted d-block">
                            {{ __('For SMS service only. Use if sending through a partner device or gateway.') }}
                        </small>
                        <input type="text" name="gateway" value="{{ $config['gateway'] ?? '' }}" class="form-control">
                    </div>

                    {{-- SIM Slot --}}
                    <div class="mb-3">
                        <label class="fw-bold">SIM Slot</label>
                        <small class="form-text text-muted d-block">
                            {{ __('For SMS service only. Select which SIM slot to use on your Android device.') }}
                        </small>
                        <select name="sim" class="form-control">
                            <option value="">-- Select SIM --</option>
                            <option value="SIM 1" {{ ($config['sim'] ?? '') == 'SIM 1' ? 'selected' : '' }}>SIM 1</option>
                            <option value="SIM 2" {{ ($config['sim'] ?? '') == 'SIM 2' ? 'selected' : '' }}>SIM 2</option>
                        </select>
                    </div>

                    <button class="btn btn-primary mt-3">
                        <i class="ti ti-device-floppy"></i> {{ __('Save Settings') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Documentation & Test Column --}}
    <div class="col-sm-3">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-send text-success"></i> {{ __('Test Message') }}</h6>
                <form method="POST" action="{{ route('sms-gateway.test-send') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Test Number</label>
                        <input type="text" name="test_number" class="form-control" placeholder="e.g. 2348012345678" required>
                    </div>

                    <div class="mb-3">
                        <label>Channel</label>
                        <select name="channel" class="form-control" required>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>

                    <button class="btn btn-success w-100">
                        <i class="ti ti-send"></i> {{ __('Send Test Message') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('About Zender Integration') }}</h6>
                <p class="small text-muted">
                    {{ __('Zender is the official messaging engine powering WhatsApp and SMS features in Churchly. It connects directly to your WhatsApp accounts or linked devices, ensuring reliable delivery.') }}
                </p>

                <ul class="small text-muted ps-3">
                    <li>{{ __('WhatsApp: Use for direct member engagement, announcements, and group chats.') }}</li>
                    <li>{{ __('SMS: Use for urgent alerts and members without WhatsApp.') }}</li>
                    <li>{{ __('Both services can be configured and selected per message.') }}</li>
                </ul>

                <hr>

                <p class="small text-muted mb-0">
                    <strong>💡 Free for Churchly users:</strong> {{ __('Zender API is provided at no extra cost because both Churchly and Zender are owned by Vicezion. You can enjoy unlimited API usage without subscription fees.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

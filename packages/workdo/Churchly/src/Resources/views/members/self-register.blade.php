<x-guest-layout :workspace="$workspaceModel">
    <div class="portal-page-head">
        <h2 class="portal-page-title">{{ __('Register as a Church Member') }}</h2>
        <p class="portal-page-subtitle">
            {{ __('Complete your details so the leadership team can review and welcome you properly.') }}
        </p>
    </div>

    @if (session('success'))
        <div class="portal-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="portal-alert error">
            <strong>{{ __('Please correct the following errors:') }}</strong>
            <ul style="margin: 8px 0 0 18px; padding: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('churchly.self.register.store', $workspace) }}" enctype="multipart/form-data" class="portal-form">
        @csrf

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Full Name') }}</label>
                <input type="text" name="name" class="portal-input" value="{{ old('name') }}" required placeholder="{{ __('Enter full name') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Email Address') }}</label>
                <input type="email" name="email" class="portal-input" value="{{ old('email') }}" required placeholder="{{ __('Enter email address') }}">
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Phone Number') }}</label>
                <input type="text" name="phone" class="portal-input" value="{{ old('phone') }}" placeholder="{{ __('Enter phone number') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Date of Birth') }}</label>
                <input type="date" name="dob" class="portal-input" value="{{ old('dob') }}" max="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Gender') }}</label>
                <select name="gender" class="portal-select" required>
                    <option value="">{{ __('Select gender') }}</option>
                    <option value="Male" @selected(old('gender') === 'Male')>{{ __('Male') }}</option>
                    <option value="Female" @selected(old('gender') === 'Female')>{{ __('Female') }}</option>
                    <option value="Other" @selected(old('gender') === 'Other')>{{ __('Other') }}</option>
                </select>
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Church Branch') }}</label>
                <select name="branch_id" class="portal-select" required>
                    <option value="">{{ __('Select branch') }}</option>
                    @foreach ($branches as $id => $name)
                        <option value="{{ $id }}" @selected((string) old('branch_id') === (string) $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Department (optional)') }}</label>
                <select name="department_id" class="portal-select">
                    <option value="">{{ __('Select department') }}</option>
                    @foreach ($departments as $id => $name)
                        <option value="{{ $id }}" @selected((string) old('department_id') === (string) $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Designation (optional)') }}</label>
                <select name="designation_id" class="portal-select">
                    <option value="">{{ __('Select designation') }}</option>
                    @foreach ($designations as $id => $name)
                        <option value="{{ $id }}" @selected((string) old('designation_id') === (string) $id)>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Church Date of Joining') }}</label>
                <input type="date" name="church_doj" class="portal-input" value="{{ old('church_doj') }}" max="{{ date('Y-m-d') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Password') }}</label>
                <input type="password" name="password" class="portal-input" placeholder="{{ __('Create password (min 6)') }}">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label">{{ __('Address') }}</label>
            <textarea name="address" rows="3" class="portal-textarea" placeholder="{{ __('Enter address') }}">{{ old('address') }}</textarea>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Emergency Contact Name') }}</label>
                <input type="text" name="emergency_contact" class="portal-input" value="{{ old('emergency_contact') }}" required placeholder="{{ __('Enter emergency contact name') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Emergency Contact Phone') }}</label>
                <input type="text" name="emergency_phone" class="portal-input" value="{{ old('emergency_phone') }}" required placeholder="{{ __('Enter emergency contact phone') }}">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label">{{ __('Upload Document (optional)') }}</label>
            <input type="file" name="documents" class="portal-file-input">
        </div>

        <input type="hidden" name="is_active" value="0">

        <button type="submit" class="portal-submit">{{ __('Submit Registration') }}</button>
    </form>
</x-guest-layout>

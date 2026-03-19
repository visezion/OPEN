<x-guest-layout :workspace="$workspace">
    <div class="portal-page-head">
        <h2 class="portal-page-title">{{ __('Share Feedback with the Leadership Team') }}</h2>
        <p class="portal-page-subtitle">
            {{ __('Submit suggestions, concerns, and testimonies so your church team can respond with care and accountability.') }}
        </p>
    </div>

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

    @if (session('success'))
        <div class="portal-alert success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('churchly.feedback.submit', ['workspace' => $workspace->slug ?? request()->route('workspace')]) }}" enctype="multipart/form-data" class="portal-form">
        @csrf
        <input type="hidden" name="type" value="public">

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Title (optional)') }}</label>
                <input type="text" name="title" value="{{ old('title') }}" class="portal-input" placeholder="{{ __('Short summary title') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Category') }}</label>
                <select name="category" class="portal-select" required>
                    <option value="">{{ __('Select category') }}</option>
                    <option value="suggestion" @selected(old('category') === 'suggestion')>{{ __('Suggestion') }}</option>
                    <option value="complaint" @selected(old('category') === 'complaint')>{{ __('Complaint') }}</option>
                    <option value="praise" @selected(old('category') === 'praise')>{{ __('Praise') }}</option>
                    <option value="other" @selected(old('category') === 'other')>{{ __('Other') }}</option>
                </select>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Name (optional)') }}</label>
                <input type="text" name="name" value="{{ old('name') }}" class="portal-input" placeholder="{{ __('Your name') }}">
            </div>
            <div class="portal-field">
                <label class="portal-label">{{ __('Email (optional)') }}</label>
                <input type="email" name="email" value="{{ old('email') }}" class="portal-input" placeholder="{{ __('Your email') }}">
            </div>
        </div>

        <div class="portal-field">
            <label class="portal-label">{{ __('Message') }}</label>
            <textarea name="message" rows="6" required class="portal-textarea" placeholder="{{ __('Type your feedback in detail') }}">{{ old('message') }}</textarea>
        </div>

        <div class="portal-grid">
            <div class="portal-field">
                <label class="portal-label">{{ __('Attachment (optional)') }}</label>
                <input type="file" name="attachment" class="portal-file-input">
            </div>
            <div class="portal-field" style="align-content: end;">
                <label style="display: inline-flex; align-items: center; gap: 8px; font-size: 14px; color: #425779;">
                    <input type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous'))>
                    <span>{{ __('Submit anonymously') }}</span>
                </label>
            </div>
        </div>

        <button type="submit" class="portal-submit">{{ __('Send Feedback') }}</button>
    </form>
</x-guest-layout>

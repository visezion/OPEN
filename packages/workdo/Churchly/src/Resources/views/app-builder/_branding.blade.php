<form method="POST" action="{{ route('app-builder.saveBranding') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('App Name') }}</label>
            <input type="text" class="form-control" name="app_name" value="{{ old('app_name', $profile->app_name ?? '') }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('Theme Mode') }}</label>
            <select class="form-control" name="theme_mode">
                <option value="system" {{ ($profile->theme_mode ?? '') == 'system' ? 'selected' : '' }}>System</option>
                <option value="light" {{ ($profile->theme_mode ?? '') == 'light' ? 'selected' : '' }}>Light</option>
                <option value="dark" {{ ($profile->theme_mode ?? '') == 'dark' ? 'selected' : '' }}>Dark</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('Primary Color') }}</label>
            <input type="color" name="primary_color" value="{{ $profile->primary_color ?? '#4A6CF7' }}" class="form-control form-control-color">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('Accent Color') }}</label>
            <input type="color" name="accent_color" value="{{ $profile->accent_color ?? '#F9B200' }}" class="form-control form-control-color">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('Logo') }}</label>
            <input type="file" name="logo_path" class="form-control">
            @if(!empty($profile->logo_path))
                <img src="{{ asset(Storage::url($profile->logo_path)) }}" class="img-thumbnail mt-2" width="100">
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('Splash Screen') }}</label>
            <input type="file" name="splash_path" class="form-control">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('App Icon') }}</label>
            <input type="file" name="icon_path" class="form-control">
        </div>

        <div class="col-md-12 text-end mt-3">
            <button class="btn btn-primary" type="submit">{{ __('Save Branding') }}</button>
        </div>
    </div>
</form>

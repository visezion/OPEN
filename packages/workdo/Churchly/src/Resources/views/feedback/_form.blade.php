@csrf

<div class="row">

    {{-- Title --}}
    <div class="col-md-12 mb-3">
        <label for="title" class="form-label">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" class="form-control"
               value="{{ old('title', $feedback->title ?? '') }}" placeholder="{{ __('Enter feedback title') }}">
    </div>

    {{-- Type --}}
    <div class="col-md-6 mb-3">
        <label for="type" class="form-label">{{ __('Type') }}</label>
        <select name="type" id="type" class="form-select" required>
            <option value="internal" {{ old('type', $feedback->type ?? '') === 'internal' ? 'selected' : '' }}>{{ __('Internal') }}</option>
            <option value="public" {{ old('type', $feedback->type ?? '') === 'public' ? 'selected' : '' }}>{{ __('Public') }}</option>
        </select>
    </div>

    {{-- Category --}}
    <div class="col-md-6 mb-3">
        <label for="category" class="form-label">{{ __('Category') }}</label>
        <select name="category" id="category" class="form-select">
            @foreach(['suggestion', 'complaint', 'praise', 'other'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $feedback->category ?? '') === $cat ? 'selected' : '' }}>
                    {{ ucfirst($cat) }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Message --}}
    <div class="col-md-12 mb-3">
        <label for="message" class="form-label">{{ __('Message') }}</label>
        <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message', $feedback->message ?? '') }}</textarea>
    </div>

    {{-- Is Anonymous --}}
    <div class="col-md-6 mb-3">
        <label for="is_anonymous" class="form-label">{{ __('Is Anonymous?') }}</label>
        <select name="is_anonymous" id="is_anonymous" class="form-select">
            <option value="0" {{ old('is_anonymous', $feedback->is_anonymous ?? 0) == 0 ? 'selected' : '' }}>{{ __('No') }}</option>
            <option value="1" {{ old('is_anonymous', $feedback->is_anonymous ?? 0) == 1 ? 'selected' : '' }}>{{ __('Yes') }}</option>
        </select>
    </div>

    {{-- Name --}}
    <div class="col-md-6 mb-3">
        <label for="name" class="form-label">{{ __('Your Name') }}</label>
        <input type="text" name="name" id="name" class="form-control"
               value="{{ old('name', $feedback->name ?? '') }}" placeholder="{{ __('Full Name') }}">
    </div>

    {{-- Email --}}
    <div class="col-md-6 mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email', $feedback->email ?? '') }}" placeholder="example@email.com">
    </div>

    {{-- Branch --}}
    <div class="col-md-6 mb-3">
        <label for="branch_id" class="form-label">{{ __('Branch') }}</label>
        <select name="branch_id" id="branch_id" class="form-select">
            <option value="">{{ __('Select Branch') }}</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id', $feedback->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Department --}}
    <div class="col-md-6 mb-3">
        <label for="department_id" class="form-label">{{ __('Department') }}</label>
        <select name="department_id" id="department_id" class="form-select">
            <option value="">{{ __('Select Department') }}</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->id }}" {{ old('department_id', $feedback->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                    {{ $dept->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Attachment --}}
    <div class="col-md-12 mb-3">
        <label for="attachment" class="form-label">{{ __('Attachment (Optional)') }}</label>
        <input type="file" name="attachment" id="attachment" class="form-control">
        @if (!empty($feedback->attachment))
            <small class="text-muted">{{ __('Current File:') }}
                <a href="{{ asset('storage/' . $feedback->attachment) }}" target="_blank">{{ __('View') }}</a>
            </small>
        @endif
    </div>

</div>

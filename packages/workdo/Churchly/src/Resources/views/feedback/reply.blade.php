@extends('layouts.main')

@section('page-title', __('Reply to Feedback'))
@section('page-breadcrumb', __('Feedback'))

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Feedback Details') }}</h5>
            </div>

            <div class="card-body">
                <p><strong>{{ __('Title') }}:</strong> {{ $feedback->title ?? '-' }}</p>
                <p><strong>{{ __('Type') }}:</strong> {{ ucfirst($feedback->type) }}</p>
                <p><strong>{{ __('Category') }}:</strong> {{ ucfirst($feedback->category) }}</p>
                <p><strong>{{ __('Submitted By') }}:</strong> {{ $feedback->is_anonymous ? 'Anonymous' : $feedback->name }}</p>
                <p><strong>{{ __('Email') }}:</strong> {{ $feedback->is_anonymous ? '-' : $feedback->email }}</p>
                <p><strong>{{ __('Message') }}:</strong></p>
                <p>{!! nl2br(e($feedback->message)) !!}</p>

                @if ($feedback->attachment)
                    <p><strong>{{ __('Attachment') }}:</strong>
                        <a href="{{ asset('storage/' . $feedback->attachment) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            {{ __('View File') }}
                        </a>
                    </p>
                @endif

                <hr>

                <form method="POST" action="{{ route('churchly.feedback.reply.update', $feedback->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="admin_response" class="form-label">{{ __('Your Response') }}</label>
                        <textarea name="admin_response" id="admin_response" class="form-control" rows="6" required>{{ old('admin_response', $feedback->admin_response) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('Update Status') }}</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="pending" {{ $feedback->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="reviewed" {{ $feedback->status === 'reviewed' ? 'selected' : '' }}>{{ __('Reviewed') }}</option>
                            <option value="resolved" {{ $feedback->status === 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">{{ __('Submit Response') }}</button>
                        <a href="{{ route('churchly.feedback.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection

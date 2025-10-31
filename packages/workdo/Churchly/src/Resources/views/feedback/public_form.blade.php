@extends('layouts.guest')

@section('title', __('Public Feedback Form'))

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">{{ __('We value your feedback!') }}</h2>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.feedback.public.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">{{ __('Title (optional)') }}</label>
                        <input type="text" name="title" class="form-control" placeholder="Optional title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="Optional name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="Optional email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Category') }}</label>
                        <select name="category" class="form-select" required>
                            <option value="suggestion">{{ __('Suggestion') }}</option>
                            <option value="complaint">{{ __('Complaint') }}</option>
                            <option value="praise">{{ __('Praise') }}</option>
                            <option value="other">{{ __('Other') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Message') }}</label>
                        <textarea name="message" rows="5" class="form-control" required placeholder="Type your feedback..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Attach File (optional)') }}</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>

                    <div class="text-end">
                        <button class="btn btn-success">{{ __('Send Feedback') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')

@section('page-title', __('Review Report'))
@section('page-breadcrumb', __('Reports'))

@push('css')
    <link href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@section('page-action')
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="{{ __('Reports Dashboard') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="{{ __('Go Back') }}">
        <i class="ti ti-arrow-back-up"></i>
    </a>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            @if ($feedback->isReport())
                @include('churchly::feedback._report_sections', ['feedback' => $feedback, 'attendanceSummary' => $attendanceSummary])
            @else
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $feedback->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded-3 p-3 bg-light">{!! $feedback->message !!}</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Response to Report') }}</h5>
                </div>
                <div class="card-body">
                    @if($feedback->admin_response)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ __('Previous Response') }}</label>
                            <div class="border rounded-3 p-3 bg-light">{!! nl2br($feedback->admin_response) !!}</div>
                        </div>
                    @endif

                    <form action="{{ route('feedback.updateResponse', $feedback->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="admin_response" class="form-label fw-semibold">{{ __('Your Response') }}</label>
                            <textarea name="admin_response" class="form-control summernote" rows="6" required>{{ old('admin_response', $feedback->admin_response) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">{{ __('Update Status') }}</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>{{ __('Reviewed') }}</option>
                                <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ __('Save Review') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });
        });
    </script>
@endpush

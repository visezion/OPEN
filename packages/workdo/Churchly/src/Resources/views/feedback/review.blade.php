@extends('layouts.main')

@section('page-title')
    {{ __('Review Feedback') }}
@endsection

@section('page-breadcrumb')
    {{ __('Feedbacks') }}
@endsection

@section('page-action')
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Feedback Main Info --}}
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>{{ $feedback->title }}</h5>
                <span class="badge bg-info text-white">{{ ucfirst($feedback->type) }}</span>
                <span class="badge bg-secondary">{{ ucfirst($feedback->category) }}</span>
                <span class="badge bg-warning text-dark">{{ ucfirst($feedback->status) }}</span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Submitted By:</strong></label>
                    <p>
                        @if($feedback->is_anonymous)
                            Anonymous
                        @else
                            {{ $feedback->name }} <br>
                            <small>{{ $feedback->email }}</small>
                        @endif
                    </p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Message:</strong></label>
                    <div class="border p-3 bg-light rounded">
                        <pre class="form-control" style="min-height: 160px; background-color: #fff; border-left: 5px solid #ccc;">
                            {!! $feedback->message !!}
                        </pre>
                    </div>
                </div>

                <div class="mb-3">
                 @if($feedback->attachment)
                    <p><strong>{{ __('Attachment') }}:</strong></p>
                    @php
                        $fileUrl = asset('storage/' . $feedback->attachment);
                        $fileName = basename($feedback->attachment);
                        $filePath = storage_path('app/public/' . $feedback->attachment);
                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                    @endphp

                    <div class="mb-2 d-flex gap-2 flex-wrap">
                        <a href="{{ route('feedback.download', $fileName) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-eye"></i> View File
                        </a>
                        <a href="{{ route('feedback.download', $fileName) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                            <i class="ti ti-download"></i> Download Attachment
                        </a>
                    </div><br>

                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{$fileUrl}}" alt="Attachment Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                    @elseif($extension === 'pdf')
                        <iframe src="{{ route('feedback.download', $fileName) }}" width="100%" height="400px" class="border rounded mt-2"></iframe>
                    @elseif(in_array($extension, ['doc', 'docx']))
                        <iframe 
                            src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode( route('feedback.download', $fileName)) }}"
                            width="100%" height="400px" class="border rounded mt-2" frameborder="0">
                        </iframe>
                    @else
                        <p class="text-muted">Preview not available for this file type.</p>
                    @endif
                @endif
        </div>
    </div>  
</div>  
</div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Response to Feedback') }}</h6>
            </div>
            <div class="card-body">
            @if($feedback->admin_response)
            <div class="mb-3">
                <label class="form-label"><strong>Previous Response:</strong></label>
               <pre class="form-control" style="min-height: 60px; background-color: #fff; border-left: 5px solid #ccc;">
                      {!! nl2br($feedback->admin_response) !!}
                    </pre>
                    <p class="text-muted">
                        <small>{{ __('Responded At') }}: {{ $feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A' }}</small>
                    </p>
            </div>
            @endif

            <form action="{{ route('feedback.updateResponse', $feedback->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="admin_response" class="form-label"><strong>Your Response:</strong></label>
                    <textarea name="admin_response" class="form-control summernote" rows="6" required>{{ old('admin_response', $feedback->admin_response) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label"><strong>Update Status:</strong></label>
                    <select name="status" class="form-select" required>
                        <option value="pending" {{ $feedback->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="resolved" {{ $feedback->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('Submit Response') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [ ['style', ['bold', 'italic', 'underline']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link']], ['view', ['fullscreen', 'codeview']] ]
        });
    });
</script>
@endpush

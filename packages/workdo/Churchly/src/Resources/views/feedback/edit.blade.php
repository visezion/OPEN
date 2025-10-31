@extends('layouts.main')

@section('page-title')
    {{ __('Edit Feedback') }}
@endsection

@section('page-breadcrumb')
    {{ __('Feedbacks') }}
@endsection

@push('css')
    <link href="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css') }}" rel="stylesheet">
@endpush

@section('page-action')
 <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Edit Feedback') }}</h5>
            </div>

            <div class="card-body">
                {!! Form::model($feedback, [
                    'route' => ['feedback.update', Crypt::encrypt($feedback->id)],
                    'method' => 'PUT',
                    'enctype' => 'multipart/form-data'
                ]) !!}

                {{-- Title --}}
                <div class="mb-3">
                    {{ Form::label('title', __('Title')) }} <x-required />
                    {{ Form::text('title', null, ['class' => 'form-control', 'required']) }}
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    {{ Form::label('category', __('Category')) }}
                    {{ Form::select('category', [
                        'suggestion' => 'Suggestion',
                        'complaint' => 'Complaint',
                        'praise' => 'Praise',
                        'other' => 'Other'
                    ], null, ['class' => 'form-control']) }}
                </div>

                {{-- Message --}}
                <pre class="mb-3">
                    {{ Form::label('message', __('Message')) }} <x-required />
                    {{ Form::textarea('message', null, [
                        'class' => 'form-control summernote',
                        'rows' => 8,
                        'style' => 'background-color: #f9f9f9; border-left: 5px solid #ccc;',
                        'placeholder' => __('Write your feedback...')
                    ]) }}
                </pre>
                 {{-- Anonymous --}}
                <div class="form-check form-switch mb-3">
                    {{ Form::checkbox('is_anonymous', 1, $feedback->is_anonymous, ['class' => 'form-check-input', 'id' => 'is_anonymous']) }}
                    {{ Form::label('is_anonymous', __('Submit as Anonymous'), ['class' => 'form-check-label']) }}
                </div>
            </div>    
        </div> 
        </div>
        <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Attachment Information') }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    {{ Form::label('attachment', __('Replace Attachment (Optional)')) }}
                    {{ Form::file('attachment', ['class' => 'form-control']) }}

                    @if ($feedback->attachment)
                        <div class="mt-3">
                            <strong>{{ __('Current Attachment') }}:</strong><br>

                            @php
                                $fileUrl = asset('storage/' . $feedback->attachment);
                                $fileName = basename($feedback->attachment);
                                $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                            @endphp

                              @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                               
                            <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="{{$fileUrl}}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="{{$fileUrl}}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                            <img src="{{$fileUrl}}" alt="Attachment Image" class="img-fluid rounded shadow" style="max-height: 300px;">
                            @elseif($extension === 'pdf')
                             <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="{{ route('feedback.download', $fileName) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="{{ route('feedback.download', $fileName) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                                <iframe src="{{ route('feedback.download', $fileName) }}" width="100%" height="400px" class="border rounded mt-2"></iframe>
                            @elseif(in_array($extension, ['doc', 'docx']))
                             <div class="d-flex gap-2 flex-wrap my-2">
                                <a href="{{ route('feedback.download', $fileName) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye"></i> View
                                </a>
                                <a href="{{ route('feedback.download', $fileName) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            </div><br>
                                <iframe 
                                    src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(route('feedback.download', $fileName)) }}" 
                                    width="100%" height="400px" class="border rounded mt-2" frameborder="0">
                                </iframe>
                            @else
                                <p class="text-muted">Preview not available for this file type.</p>
                            @endif

                        </div>
                    @endif
                </div>

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> {{ __('Update Feedback') }}
                    </button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{-- Admin Response --}}
    @if($feedback->admin_response)
        <div class="col-md-8 mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Admin Response') }}</h6>
                </div>
                <div class="card-body">
                    <p>{!! nl2br(e($feedback->admin_response)) !!}</p>
                    <p class="text-muted">
                        <small>{{ __('Responded At') }}: {{ $feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A' }}</small>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <script>
        $(function () {
            $('.summernote').summernote({
                height: 200,
                placeholder: 'Write your feedback...'
            });
        });
    </script>
@endpush

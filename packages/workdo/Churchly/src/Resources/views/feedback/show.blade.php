@extends('layouts.main')

@section('page-title')
    {{ __('Feedback Details') }}
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
    <a href="{{ route('feedback.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Create Feedback">
        <i class="ti ti-plus"></i>
    </a>
    @permission('feedback edit')
    <a href="{{ route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt( $feedback->id)) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit Feedback">
        <i class="ti ti-pencil"></i>
    </a>
   @endpermission
@endsection

@section('content')
<div class="row">
    {{-- Feedback Main Info --}}
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>{{ $feedback->title ?? __('No Title') }}</h5><br>
                <span class="badge bg-info text-white">{{ ucfirst($feedback->type) }}</span>
                <span class="badge bg-secondary">{{ ucfirst($feedback->category) }}</span>
                <span class="badge bg-{{ $feedback->status === 'resolved' ? 'success' : ($feedback->status === 'reviewed' ? 'warning' : 'danger') }}">
                    {{ ucfirst($feedback->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1"><strong>{{ __('Submitted By') }}:</strong>
                    @if ($feedback->is_anonymous)
                        <em>{{ __('Anonymous') }}</em>
                    @else
                        {{ $feedback->name ?? 'N/A' }} ({{ $feedback->email ?? 'No Email' }})
                    @endif
                </p>

                <p class="mb-1"><strong>{{ __('Branch') }}:</strong> {{ optional($feedback->branch)->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>{{ __('Department') }}:</strong> {{ optional($feedback->department)->name ?? 'N/A' }}</p>
                <p class="mb-1"><strong>{{ __('Submitted At') }}:</strong> {{ $feedback->created_at->format('d M Y h:i A') }}</p>
                 <hr>
                    {{ Form::label('message', __('Message :')) }}
                    <pre class="form-control" style="min-height: 160px; background-color: #fff; border-left: 5px solid #ccc;">
                        {!! $feedback->message !!}
                    </pre>
                </div>

                <hr>

                 </div>
       

      
      
    </div>   </div>

    {{-- Sidebar: Meta + Attachment --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Meta Information') }}</h6>
            </div>
            <div class="card-body">
                <p><strong>{{ __('Workspace') }}:</strong> {{ optional($feedback->workspace)->name ?? 'N/A' }}</p>
                <p><strong>{{ __('Status') }}:</strong> {{ ucfirst($feedback->status) }}</p>
                <p><strong>{{ __('Reviewed By') }}:</strong> {{ $feedback->reviewed_at ?? 'Not yet reviewed' }}</p>
                  {{-- Admin Response --}}
                <div class="card-header bg-light">
                    <h6 class="mb-0">{{ __('Admin Response :') }}</h6>
                </div>
                <pre class="form-control" style="min-height: 60px; background-color: #fff; border-left: 5px solid #ccc;">
                    {!! nl2br($feedback->admin_response ?? 'Not Response yet') !!}
                </pre>
                <p class="text-muted">
                    <small>{{ __('Responded At') }}: {{ $feedback->reviewed_at?->format('d M Y h:i A') ?? 'N/A' }}</small>
                </p>
              <hr>
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
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <script>
        $(document).on('click', '#file', function() {
            $('#blah').removeClass('d-none');
        });

        $(document).on('change', '.select_person_email', function () {
            let userId = $(this).val();
            $.post('{{ route('helpdesk-tickets.getuser') }}', {
                user_id: userId,
                _token: '{{ csrf_token() }}'
            }, function (data) {
                if (data.email) {
                    $('.emailAddressField').val(data.email).prop('readonly', true).css('background-color', '#e9ecef');
                } else {
                    $('.emailAddressField').val('').prop('readonly', false).css('background-color', '');
                }
            });
        });
    </script>
@endpush

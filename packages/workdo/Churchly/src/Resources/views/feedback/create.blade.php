@extends('layouts.main')

@section('page-title', __('Submit Feedback'))
@section('page-breadcrumb', __('Feedback'))
@push('css')
    <link href="{{  asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.css')  }}" rel="stylesheet">
@endpush
@section('page-action')
              
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="" data-bs-original-title="Feedback Dashboard">
            <i class="ti ti-layout-grid text-white"></i>
        </a>
    <a href="{{route('feedback.index')}}" class="btn btn-sm btn-danger btn-icon me-1" data-bs-toggle="tooltip" title="" data-bs-original-title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i> 
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{ Form::open([
                    'route' => ['feedback.store'],
                    'method' => 'post',
                    'class' => 'needs-validation',
                    'novalidate',
                    'id' => 'feedback-form',
                    'enctype' => 'multipart/form-data'
                ]) }}

                <div class="row">
                    {{-- 📝 Feedback Info --}}
                    <div class="col-md-12">
                        <h5>{{ __('Feedback Details') }}</h5>
                        <hr>

                        <div class="form-group mb-3">
                            {{ Form::label('title', __('Title')) }}<x-required />
                            {{ Form::text('title', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter Feedback Title')]) }}
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('message', __('Message')) }}<x-required />
                            {{ Form::textarea('message', null, ['class' => 'form-control summernote', 'required', 'rows' => 4, 'placeholder' => __('Write your feedback...')]) }}
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('category', __('Category (optional)')) }}
                             {{ Form::select('category', ['suggestion' => 'Suggestion', 'complaint' => 'Complaint', 'appreciation' => 'Appreciation', 'other' => 'Other'], null, ['class' => 'form-control', 'required', 'placeholder' => __('Select Feedback Category')]) }}
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('attachment', __('Attachment (optional)')) }}
                            {{ Form::file('attachment', ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('feedback.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Submit Feedback') }}</button>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>
@endpush


@push('scripts')
    <script src="{{ asset('assets/js/plugins/summernote-0.8.18-dist/summernote-lite.min.js') }}"></script>
    <script>
        $(document).on('click', '#file', function() {
            $('#blah').removeClass('d-none');
        });

        $(document).on('change', '.select_person_email', function() {
            var userId = $(this).val();
            $.ajax({
                url: '{{ route('helpdesk-tickets.getuser') }}',
                type: 'POST',
                data: {
                    "user_id": userId,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if(data.email)
                    {
                        $('.emailAddressField').val(data.email);
                        $('.emailAddressField').prop('readonly', true);
                        $('.emailAddressField').css('background-color', '#e9ecef');
                    }else{
                        $('.emailAddressField').val('');
                        $('.emailAddressField').prop('readonly', false);
                        $('.emailAddressField').css('background-color', '');
                    }
                }
            });
        });
    </script>
@endpush

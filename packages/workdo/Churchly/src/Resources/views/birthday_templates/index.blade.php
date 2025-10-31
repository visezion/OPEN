@extends('layouts.main')

@section('page-title', __('Birthday Templates'))

@section('page-action')
    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#uploadTemplateModal">
        <i class="ti ti-upload"></i> {{ __('Upload New Template') }}
    </a>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="mb-3">{{ __('Available Templates') }}</h5>

        @if($templates->count())
            <div class="row">
                @foreach($templates as $template)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <img src="{{ asset('storage/'.$template->file_path) }}" 
                                 class="card-img-top" 
                                 style="height:250px;object-fit:cover;">

                            <div class="card-body text-center">
                                <p class="mb-2"><strong>{{ $template->name }}</strong></p>

                                @if($template->is_active)
                                    <span class="badge bg-success mb-2">{{ __('Active') }}</span>
                                @else
                                    <form action="{{ route('birthday_templates.activate', $template->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary mb-2">
                                            <i class="ti ti-check"></i> {{ __('Activate') }}
                                        </button>
                                    </form>
                                @endif

                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('birthday_templates.edit', $template->id) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="ti ti-pencil"></i> {{ __('Edit') }}
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('birthday_templates.destroy', $template->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('{{ __('Are you sure you want to delete this template?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">{{ __('No templates uploaded yet.') }}</p>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadTemplateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('birthday_templates.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Upload Birthday Template') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Template Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">{{ __('Template File (PNG/JPG)') }}</label>
                    <input type="file" name="file" id="file" class="form-control" accept="image/*" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

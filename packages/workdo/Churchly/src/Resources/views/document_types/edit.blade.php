@extends('layouts.main')

@section('page-title', __('Edit Church Document Type'))
@section('page-breadcrumb', __('Edit Church Document Type'))

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                {!! Form::model($documentType, ['route' => ['church.document_types.update', $documentType->id], 'method' => 'PUT', 'class' => 'needs-validation']) !!}
                    <div class="form-group mb-3">
                        {!! Form::label('name', __('Document Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => __('Enter document type name')]) !!}
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('is_required', __('Is Required'), ['class' => 'form-label']) !!}
                        {!! Form::select('is_required', ['1' => __('Yes'), '0' => __('No')], $documentType->is_required, ['class' => 'form-control select']) !!}
                    </div>

                    <div class="text-end">
                        <a href="{{ route('church.document_types.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

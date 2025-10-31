@extends('layouts.main')

@section('page-title', __('Add Church Document Type'))
@section('page-breadcrumb', __('Add Church Document Type'))

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['route' => 'church.document_types.store', 'method' => 'POST', 'class' => 'needs-validation']) !!}
                    <div class="form-group mb-3">
                        {!! Form::label('name', __('Document Name'), ['class' => 'form-label']) !!}
                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true, 'placeholder' => __('Enter document type name')]) !!}
                    </div>

                    <div class="form-group mb-3">
                        {!! Form::label('is_required', __('Is Required'), ['class' => 'form-label']) !!}
                        {!! Form::select('is_required', ['1' => __('Yes'), '0' => __('No')], old('is_required', '0'), ['class' => 'form-control select']) !!}
                    </div>

                    <div class="text-end">
                        <a href="{{ route('church.document_types.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

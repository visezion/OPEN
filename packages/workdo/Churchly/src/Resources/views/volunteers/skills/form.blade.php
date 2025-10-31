@extends('layouts.main')

@php
    $isEdit = $skill->exists;
    $route = $isEdit
        ? ['churchly.volunteer-skills.update', $skill->id]
        : ['churchly.volunteer-skills.store'];
    $method = $isEdit ? 'PUT' : 'POST';
@endphp

@section('page-title')
    {{ $isEdit ? __('Edit Skill') : __('Add Skill') }}
@endsection

@section('page-breadcrumb')
    <a href="{{ route('churchly.volunteer-skills.index') }}">{{ __('Skills') }}</a> /
    {{ $isEdit ? __('Edit') : __('Create') }}
@endsection

@section('page-action')
    <a href="{{ route('churchly.volunteer-skills.index') }}"
       class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> {{ __('Back to list') }}
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        {{ $isEdit ? __('Update Skill') : __('Create Skill') }}
                    </h5>
                </div>
                <div class="card-body">
                    {!! Form::model($skill, ['route' => $route, 'method' => $method]) !!}
                        <div class="mb-3">
                            {!! Form::label('name', __('Skill name'), ['class' => 'form-label']) !!}
                            {!! Form::text('name', old('name', $skill->name), ['class' => 'form-control', 'required' => true]) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('category', __('Category'), ['class' => 'form-label']) !!}
                            {!! Form::text('category', old('category', $skill->category), ['class' => 'form-control', 'placeholder' => __('Vocals, Media, Children...')]) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!}
                            {!! Form::textarea('description', old('description', $skill->description), ['class' => 'form-control', 'rows' => 3]) !!}
                        </div>
                        <div class="form-check form-switch mb-4">
                            {!! Form::checkbox('is_active', 1, old('is_active', $skill->is_active ?? true), ['class' => 'form-check-input', 'id' => 'is_active']) !!}
                            {!! Form::label('is_active', __('Skill is active'), ['class' => 'form-check-label']) !!}
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('churchly.volunteer-skills.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? __('Save changes') : __('Create skill') }}
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

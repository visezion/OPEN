@extends('layouts.main')

@section('page-title')
    Edit Custom Field
@endsection

@section('page-breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('formsetup.index') }}">Custom Fields</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-3">
        @include('churchly::layouts.churchly_setup')
    </div>

    <div class="col-sm-9">
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('formsetup.update', $field->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Field Key</label>
                <input type="text" name="field_key" class="form-control" value="{{ $field->field_key }}" required>
            </div>

            <div class="mb-3">
                <label>Field Label</label>
                <input type="text" name="field_label" class="form-control" value="{{ $field->field_label }}" required>
            </div>

            <div class="mb-3">
                <label>Field Type</label>
                <select name="field_type" class="form-control" required>
                    <option value="text" @if($field->field_type=='text') selected @endif>Text</option>
                    <option value="textarea" @if($field->field_type=='textarea') selected @endif>Textarea</option>
                    <option value="date" @if($field->field_type=='date') selected @endif>Date</option>
                    <option value="drupdown" @if($field->field_type=='drupdown') selected @endif>Drupdown</option>
                    <option value="file" @if($field->field_type=='file') selected @endif>File Upload</option>
                    <option value="checkbox" @if($field->field_type=='checkbox') selected @endif>Checkbox</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Default Value (Optional)</label>
                <input type="text" name="field_value" class="form-control" value="{{ $field->field_value }}">
                <small class="form-text text-muted">For select/checkbox, use comma-separated options (e.g., Male,Female)</small>
            </div>

            <div class="mb-3">
                <label>Display Order</label>
                <input type="number" name="order" class="form-control" value="{{ $field->order ?? 0 }}">
            </div>

            <button type="submit" class="btn btn-success">Update Field</button>
            <a href="{{ route('formsetup.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

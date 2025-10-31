@extends('layouts.main')

@php
    $isEdit = $volunteer->exists;
    $formRoute = $isEdit
        ? ['churchly.volunteers.update', $volunteer->id]
        : ['churchly.volunteers.store'];
    $formMethod = $isEdit ? 'PUT' : 'POST';
    $statusOptions = [
        'active' => __('Active'),
        'inactive' => __('Inactive'),
        'paused' => __('Paused'),
    ];
@endphp

@section('page-title')
    {{ $isEdit ? __('Edit Volunteer') : __('Add Volunteer') }}
@endsection

@section('page-breadcrumb')
    <a href="{{ route('churchly.volunteers.index') }}">{{ __('Volunteers') }}</a> /
    {{ $isEdit ? __('Edit') : __('Create') }}
@endsection

@section('page-action')
    <a href="{{ route('churchly.volunteers.index') }}"
       class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> {{ __('Back to list') }}
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        {{ $isEdit ? __('Update Volunteer Profile') : __('Create Volunteer Profile') }}
                    </h5>
                </div>
                <div class="card-body">
                    {{ Form::model($volunteer, ['route' => $formRoute, 'method' => $formMethod]) }}
                    <div class="row g-3">
                        <div class="col-md-6">
                            {{ Form::label('church_member_id', __('Link to member record'), ['class' => 'form-label']) }}
                            {{ Form::select('church_member_id', $members, old('church_member_id', $volunteer->church_member_id), ['class' => 'form-select', 'placeholder' => __('Select member (optional)')]) }}
                            <div class="form-text">{{ __('Linking a member allows automatic profile sync.') }}</div>
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                            {{ Form::select('status', $statusOptions, old('status', $volunteer->status ?? 'active'), ['class' => 'form-select', 'required' => true]) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('full_name', __('Full name'), ['class' => 'form-label']) }}
                            {{ Form::text('full_name', old('full_name', $volunteer->full_name), ['class' => 'form-control', 'placeholder' => __('John Doe')]) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('preferred_name', __('Preferred name'), ['class' => 'form-label']) }}
                            {{ Form::text('preferred_name', old('preferred_name', $volunteer->preferred_name), ['class' => 'form-control', 'placeholder' => __('Display name used in schedules')]) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
                            {{ Form::email('email', old('email', $volunteer->email), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('phone', __('Phone'), ['class' => 'form-label']) }}
                            {{ Form::text('phone', old('phone', $volunteer->phone), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('joined_at', __('Start serving date'), ['class' => 'form-label']) }}
                            {{ Form::date('joined_at', old('joined_at', optional($volunteer->joined_at)->format('Y-m-d')), ['class' => 'form-control']) }}
                        </div>
                        <div class="col-12">
                            {{ Form::label('departments', __('Departments / Teams'), ['class' => 'form-label']) }}
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                @foreach($departments as $id => $name)
                                    <div class="col">
                                        <div class="border rounded px-3 py-2">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                       class="form-check-input"
                                                       id="dept-{{ $id }}"
                                                       name="departments[]"
                                                       value="{{ $id }}"
                                                       @checked(in_array($id, $selectedDepartments))>
                                                <label class="form-check-label" for="dept-{{ $id }}">
                                                    {{ $name }}
                                                </label>
                                            </div>
                                            <div class="mt-2 ms-4">
                                                <input type="radio"
                                                       name="primary_department"
                                                       value="{{ $id }}"
                                                       id="dept-primary-{{ $id }}"
                                                       class="form-check-input"
                                                       @checked($primaryDepartment === $id)>
                                                <label for="dept-primary-{{ $id }}" class="small form-check-label text-muted">
                                                    {{ __('Set as primary team') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-text">{{ __('Select one or more teams this volunteer belongs to.') }}</div>
                        </div>
                        <div class="col-12">
                            {{ Form::label('skills', __('Skills'), ['class' => 'form-label']) }}
                            <div class="row row-cols-1 row-cols-md-2 g-2">
                                @foreach($skills as $skill)
                                    @php
                                        $level = $selectedSkills[$skill->id] ?? 'intermediate';
                                    @endphp
                                    <div class="col">
                                        <div class="border rounded px-3 py-2 h-100">
                                            <div class="form-check d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input type="checkbox"
                                                           class="form-check-input"
                                                           id="skill-{{ $skill->id }}"
                                                           name="skills[]"
                                                           value="{{ $skill->id }}"
                                                           @checked(array_key_exists($skill->id, $selectedSkills))>
                                                    <label class="form-check-label" for="skill-{{ $skill->id }}">
                                                        {{ $skill->name }}
                                                    </label>
                                                </div>
                                                <select name="skill_levels[{{ $skill->id }}]"
                                                        class="form-select form-select-sm ms-2"
                                                        aria-label="{{ __('Proficiency level') }}">
                                                    <option value="beginner" @selected($level === 'beginner')>{{ __('Beginner') }}</option>
                                                    <option value="intermediate" @selected($level === 'intermediate')>{{ __('Intermediate') }}</option>
                                                    <option value="advanced" @selected($level === 'advanced')>{{ __('Advanced') }}</option>
                                                    <option value="expert" @selected($level === 'expert')>{{ __('Expert') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-text">{{ __('Tick the skills that apply and set proficiency level if needed.') }}</div>
                        </div>
                        <div class="col-12">
                            {{ Form::label('new_skills_text', __('Add new skills'), ['class' => 'form-label']) }}
                            {{ Form::textarea('new_skills_text', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter new skills separated by commas')]) }}
                        </div>
                        <div class="col-12">
                            {{ Form::label('notes', __('Internal notes'), ['class' => 'form-label']) }}
                            {{ Form::textarea('notes', old('notes', $volunteer->notes), ['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('churchly.volunteers.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            {{ $isEdit ? __('Save changes') : __('Create volunteer') }}
                        </button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

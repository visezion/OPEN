@extends('layouts.main')

@section('page-title', __('Edit Church Member'))
@section('page-breadcrumb', __('Church Member'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                {{ Form::model($member, [
                    'route' => ['churchly.members.update', $member->id],
                    'method' => 'PUT',
                    'class' => 'needs-validation',
                    'novalidate',
                    'id' => 'member-details-form',
                    'enctype' => 'multipart/form-data'
                ]) }}

                <div class="row">
                    {{-- 🧍 Personal Details --}}
                    <div class="col-md-3">
                        <h5>{{ __('Personal Details') }}</h5>
                        <hr>
                        <div class="form-group mb-3 text-center">
                            <label class="form-label d-block">{{ __('Profile Photo') }}</label>
                            <div class="mb-3">
                                <img id="preview-image" 
                                    src="{{ $member->profile_photo ? asset('storage/'.$member->profile_photo) : 'https://cdn2.iconfinder.com/data/icons/circle-icons-1/64/profle-512.png' }}" 
                                    alt="Profile Preview" 
                                    class="rounded-circle border" 
                                    style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                            <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" hidden>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('profile-photo-input').click()">
                                <i class="ti ti-upload"></i> {{ __('Change Photo') }}
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="resetProfilePhoto()">
                                <i class="ti ti-trash"></i> {{ __('Remove') }}
                            </button>
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('name', __('Full Name')) }}<x-required />
                            {{ Form::text('name', $member->name, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('email', __('Email')) }}<x-required />
                            {{ Form::email('email', $member->email, ['class' => 'form-control', 'required']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('phone', __('Phone')) }}
                            {{ Form::text('phone', $member->phone, ['class' => 'form-control']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('dob', __('Date of Birth')) }}
                            {{ Form::date('dob', $member->dob, ['class' => 'form-control', 'max' => date('Y-m-d')]) }}
                        </div>
                    </div>

                    {{-- 🏠 Personal Info & Emergency --}}
                    <div class="col-md-4">
                        <h5>{{ __('Personal Information & Emergency') }}</h5>
                        <hr>
                        <div class="form-group mb-3">
                            {{ Form::label('gender', __('Gender')) }}<x-required />
                            {{ Form::select('gender', ['Male'=>'Male','Female'=>'Female','Other'=>'Other'], $member->gender, ['class'=>'form-control','required']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('address', __('Address')) }}
                            {{ Form::textarea('address', $member->address, ['class'=>'form-control','rows'=>2]) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('emergency_contact', __('Emergency Contact Name')) }}<x-required />
                            {{ Form::text('emergency_contact', $member->emergency_contact, ['class'=>'form-control','required']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('emergency_phone', __('Emergency Contact Phone')) }}<x-required />
                            {{ Form::text('emergency_phone', $member->emergency_phone, ['class'=>'form-control','required']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('family_id', __('Family Group')) }}
                            {{ Form::select('family_id', $members, $member->family_id, ['class'=>'form-control','placeholder'=>'Select Family Head']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('spouse_id', __('Spouse')) }}
                            {{ Form::select('spouse_id', $members, $member->spouse_id, ['class'=>'form-control','placeholder'=>'Select Spouse']) }}
                        </div>
                    </div>

                    {{-- ⛪ Church Info --}}
                    <div class="col-md-5">
                        <h5>{{ __('Church Details') }}</h5>
                        <hr>
                        <div class="form-group mb-3">
                            {{ Form::label('membership_status', __('Membership Status')) }}
                            {{ Form::select('membership_status', ['Active'=>'Active','Inactive'=>'Inactive','Visitor'=>'Visitor','New Convert'=>'New Convert'], $member->membership_status, ['class'=>'form-control']) }}
                        </div>

                        {{-- Branch (always required) --}}
                        <div class="form-group mb-3">
                            {{ Form::label('branch_id', __('Branch')) }}<x-required />
                            {{ Form::select('branch_id', $branches, $member->branch_id, ['class'=>'form-control','id'=>'branch-select','required','placeholder'=>'Select Branch']) }}
                        </div>

                        {{-- Departments & Designations --}}
                        <div class="form-group mb-3">
                            <label>{{ __('Departments & Designations') }}</label>
                            <div id="departments-wrapper">
                                @php $i = 0; @endphp
                                @forelse($member->departments as $dept)
                                    <div class="row mb-2 department-row">
                                        <div class="col-md-5">
                                            <select name="departments[{{ $i }}][department_id]" class="form-control department-select" data-index="{{ $i }}">
                                                <option value="">{{ __('Select Department (optional)') }}</option>
                                                @foreach($departments as $id => $name)
                                                    <option value="{{ $id }}" {{ $dept->id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="departments[{{ $i }}][designation_id]" class="form-control designation-select" data-index="{{ $i }}">
                                                <option value="">{{ __('Select Designation (optional)') }}</option>
                                                @foreach($designations as $id => $name)
                                                    <option value="{{ $id }}" {{ $dept->pivot->designation_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-row">&times;</button>
                                        </div>
                                    </div>
                                    @php $i++; @endphp
                                @empty
                                    <div class="row mb-2 department-row">
                                        <div class="col-md-6">
                                            <select name="departments[0][department_id]" class="form-control department-select" data-index="0">
                                                <option value="">{{ __('Select Department (optional)') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="departments[0][designation_id]" class="form-control designation-select" data-index="0">
                                                <option value="">{{ __('Select Designation (optional)') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger remove-row">&times;</button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" id="add-department" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="ti ti-plus"></i> {{ __('Add Another Department') }}
                            </button>
                        </div>

                        <div class="form-group mb-3">
                            {{ Form::label('role', __('Role')) }}<x-required />
                            {{ Form::select('role', $role, optional($member->user->roles->first())->id, ['class'=>'form-control','required','placeholder'=>'Select Role']) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('church_doj', __('Date of Joining')) }}
                            {{ Form::date('church_doj', $member->church_doj, ['class'=>'form-control','max'=>date('Y-m-d')]) }}
                        </div>
                        <div class="form-group mb-3">
                            {{ Form::label('is_active', __('Account Status')) }}
                            {{ Form::select('is_active', ['1'=>'Active','0'=>'Inactive'], $member->is_active, ['class'=>'form-control']) }}
                        </div>
                    </div>

                    {{-- 📝 Custom Fields --}}
                    <div class="col-12 mt-4">
                        <h5>{{ __('Additional Information') }}</h5>
                        <hr>
                        <div class="row">
                            @foreach($customFields as $field)
                                @php
                                    $value = $member->customValues->where('field_key', $field->field_key)->first()->field_value ?? null;
                                @endphp
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ $field->field_label }}</label>
                                    @if($field->field_type == 'text')
                                        {{ Form::text("custom[{$field->field_key}]", $value, ['class'=>'form-control']) }}
                                    @elseif($field->field_type == 'textarea')
                                        {{ Form::textarea("custom[{$field->field_key}]", $value, ['class'=>'form-control','rows'=>2]) }}
                                    @elseif($field->field_type == 'date')
                                        {{ Form::date("custom[{$field->field_key}]", $value, ['class'=>'form-control']) }}
                                    @elseif($field->field_type == 'file')
                                        {{ Form::file("custom[{$field->field_key}]", ['class'=>'form-control']) }}
                                        @if($value)
                                            <a href="{{ asset('storage/'.$value) }}" target="_blank">{{ __('View File') }}</a>
                                        @endif
                                    @elseif($field->field_type == 'dropdown')
                                        <select name="custom[{{ $field->field_key }}]" class="form-control">
                                            <option value="">{{ __('-- Select --') }}</option>
                                            @foreach(explode(',', $field->field_value) as $opt)
                                                <option value="{{ trim($opt) }}" {{ $value == trim($opt) ? 'selected' : '' }}>{{ trim($opt) }}</option>
                                            @endforeach
                                        </select>
                                    @elseif($field->field_type == 'checkbox')
                                        <div class="form-check">
                                            <input type="checkbox" name="custom[{{ $field->field_key }}]" value="1" class="form-check-input" {{ $value ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $field->field_label }}</label>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('churchly.members.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Update Member') }}</button>
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const getDepartmentsUrl = "{{ route('departments.byBranch') }}";
    const getDesignationsUrl = "{{ route('designations.byDepartment') }}";

    document.addEventListener('DOMContentLoaded', function () {
        let index = {{ $member->departments->count() ?: 1 }};
        const branchSelect = document.getElementById('branch-select');

        // Add department row
        document.getElementById('add-department').addEventListener('click', function () {
            let wrapper = document.getElementById('departments-wrapper');
            let newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2', 'department-row');

            newRow.innerHTML = `
                <div class="col-md-5">
                    <select name="departments[${index}][department_id]" class="form-control department-select" data-index="${index}">
                        <option value="">{{ __('Select Department (optional)') }}</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="departments[${index}][designation_id]" class="form-control designation-select" data-index="${index}">
                        <option value="">{{ __('Select Designation (optional)') }}</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-row">&times;</button>
                </div>
            `;
            wrapper.appendChild(newRow);

            if (branchSelect.value) {
                fetchDepartments(branchSelect.value, index);
            }
            index++;
        });

        // Remove row
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('.department-row').remove();
            }
        });

        // Branch change → reload departments
        branchSelect.addEventListener('change', function () {
            let branchId = this.value;
            document.querySelectorAll('.department-select').forEach(deptSelect => {
                let idx = deptSelect.dataset.index;
                fetchDepartments(branchId, idx);
            });
        });

        // Department change → load designations
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('department-select')) {
                let deptId = e.target.value;
                let idx = e.target.dataset.index;
                fetchDesignations(deptId, idx);
            }
        });

        function fetchDepartments(branchId, idx) {
            let deptSelect = document.querySelector(`select[name="departments[${idx}][department_id]"]`);
            let desigSelect = document.querySelector(`select[name="departments[${idx}][designation_id]"]`);
            deptSelect.innerHTML = '<option value="">{{ __("Select Department (optional)") }}</option>';
            desigSelect.innerHTML = '<option value="">{{ __("Select Designation (optional)") }}</option>';

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        deptSelect.appendChild(option);
                    });
                });
        }

        function fetchDesignations(deptId, idx) {
            let desigSelect = document.querySelector(`select[name="departments[${idx}][designation_id]"]`);
            desigSelect.innerHTML = '<option value="">{{ __("Select Designation (optional)") }}</option>';

            if (!deptId) return;

            fetch(`${getDesignationsUrl}?department=${deptId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        desigSelect.appendChild(option);
                    });
                });
        }
    });

    // Profile photo preview/reset
    const input = document.getElementById('profile-photo-input');
    const preview = document.getElementById('preview-image');
    const defaultImage = "{{ asset('images/default-avatar.png') }}";

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function resetProfilePhoto() {
        input.value = '';
        preview.src = defaultImage;
    }
</script>
@endpush

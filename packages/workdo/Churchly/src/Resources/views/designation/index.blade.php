@extends('layouts.main')

@php
    $company_settings = getCompanyAllSetting();
    $designation_name = $company_settings['churchly_designation_name'] ?? __('Designation');
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
    $department_name = $company_settings['churchly_department_name'] ?? __('Department');
@endphp

@section('page-title')
    {{ $designation_name }}
@endsection

@section('page-breadcrumb')
    {{ __('Church Designation') }}
@endsection

@section('page-action')
    @permission('church_designation create')
        <a href="javascript:void(0)"
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="{{ __('Create ' . $designation_name) }}"
           data-url="{{ route('churchdesignation.create') }}"
           data-toggle="tooltip"
           title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endpermission
<a href="{{ route('churchdesignation.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Go Back">
    <i class="ti ti-arrow-back-up me-2"></i>
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-3">
        @include('churchly::layouts.churchly_setup')
    </div>

    <div class="col-sm-6">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ $designation_name }}</th>
                                <th>{{ $department_name }}</th>
                                <th>{{ $branch_name }}</th>
                                <th width="120px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($designations as $designation)
                                <tr>
                                    <td>{{ $designation->name ?? '-' }}</td>
                                    <td>{{ $designation->department->name ?? '-' }}</td>
                                    <td>{{ $designation->branch->name ?? '-' }}</td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            @permission('church_designation edit')
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="{{ route('churchdesignation.edit', $designation->id) }}"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="{{ __('Edit ' . $designation_name) }}"
                                                   data-bs-toggle="tooltip"
                                                   title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            @endpermission

                                            @permission('church_designation delete')
                                                {!! Form::open([
                                                    'route' => ['churchdesignation.destroy', $designation->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $designation->id
                                                ]) !!}
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="{{ __('Delete') }}"
                                                       data-confirm="{{ __('Are You Sure?') }}"
                                                       data-text="{{ __('This action cannot be undone. Do you want to continue?') }}"
                                                       data-confirm-yes="delete-form-{{ $designation->id }}">
                                                        <i class="ti ti-trash"></i>
                                                    </a>
                                                {!! Form::close() !!}
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @include('layouts.nodatafound')
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
    <div class="card">
      <div class="container"><br>
        <h4>Create New Designation</h4>

        {!! Form::open(['route' => 'churchdesignation.store', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-12">

                    {{-- Designation Name --}}
                    <div class="form-group mb-3">
                        {!! Form::label('name', __('Designation Name')) !!}
                        {!! Form::text('name', old('name'), [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Enter designation name')
                        ]) !!}
                    </div>

                    {{-- Branch --}}
                    <div class="form-group mb-3">
                        {!! Form::label('branch_id', __('Branch')) !!}
                        {!! Form::select('branch_id', $branches, null, [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Select Branch'),
                            'id' => 'branch-select'
                        ]) !!}
                    </div>

                    {{-- Department --}}
                    <div class="form-group mb-3">
                        {!! Form::label('department_id', __('Department')) !!}
                        {!! Form::select('department_id', [], null, [
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => __('Select Department'),
                            'id' => 'department-select',
                            'disabled' => true
                        ]) !!}
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('churchdesignation.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        {!! Form::close() !!}
    </div> <br>
    </div>
    </div>
    <br>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const getDepartmentsUrl = "{{ route('departments.byBranch') }}";
        const branchSelect = document.getElementById('branch-select');
        const departmentSelect = document.getElementById('department-select');

        branchSelect.addEventListener('change', function () {
            const branchId = this.value;

            // Reset
            departmentSelect.innerHTML = '<option value="">Select Department</option>';
            departmentSelect.disabled = true;

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    console.log("Departments response:", data);

                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        departmentSelect.appendChild(option);
                    });

                    if (Object.keys(data).length > 0) {
                        departmentSelect.disabled = false;
                    }
                })
                .catch(err => console.error("Error loading departments:", err));
        });
    });
</script>
@endpush

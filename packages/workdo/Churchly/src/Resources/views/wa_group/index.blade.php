@extends('layouts.main')

@php
    $company_settings = getCompanyAllSetting();
    $branch_name      = $company_settings['churchly_branch_name'] ?? __('Branch');
    $department_name  = $company_settings['churchly_department_name'] ?? __('Department');
    $designation_name = $company_settings['churchly_designation_name'] ?? __('Designation');
@endphp

@section('page-title')
    {{ __('WhatsApp Groups') }}
@endsection

@section('page-breadcrumb')
    {{ __('WA Groups') }}
@endsection

@section('page-action')
   

    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" title="Go Back">
        <i class="ti ti-arrow-back-up me-2"></i>
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Left Sidebar --}}
    <div class="col-sm-2">
        @include('churchly::layouts.churchly_setup')
    </div>

    {{-- Main Table --}}
    <div class="col-sm-7">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('Group Name') }}</th>
                                <!--<th>{{ __('Group ID') }}</th>-->
                                <th>{{ $branch_name }}</th>
                                <th>{{ $department_name }}</th>
                                <th>{{ $designation_name }}</th>
                                <th width="120px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groups as $group)
                                <tr>
                                    <td>{{ $group->name ?? '-' }}</td>
                                    <!--<td>{{ $group->group_id ?? '-' }}</td>-->
                                    <td>{{ $group->branches->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td>{{ $group->departments->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td>{{ $group->designations->pluck('name')->join(', ') ?: '-' }}</td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            @permission('connect_whatsApp view')
                                                <a href="{{ route('wa_group.show', $group->id) }}"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-bs-toggle="tooltip"
                                                   title="{{ __('View') }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                            @endpermission

                                            @permission('connect_whatsApp delete')
                                                {!! Form::open([
                                                    'route' => ['wa_group.destroy', $group->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $group->id
                                                ]) !!}
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="{{ __('Delete') }}"
                                                       data-confirm="{{ __('Are You Sure?') }}"
                                                       data-text="{{ __('This action cannot be undone. Do you want to continue?') }}"
                                                       data-confirm-yes="delete-form-{{ $group->id }}">
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

    {{-- Right Side Column (Optional Form or Info) --}}
    <div class="col-sm-3">
        <div class="card p-3">
            <h6 class="mb-3">{{ __('Assign New WhatsApp Group') }}</h6>
            <p class="text-muted small">
            {{ __('Follow these steps to assign a WhatsApp group:') }}
            </p>
            <ul class="text-muted small ps-3">
                <li>{{ __('First, select the WhatsApp group you want to link from the dropdown. Only groups synced from Zender will appear here.') }}</li>
                <li>{{ __('(Optional) Choose a branch if this group should only apply to one church branch.') }}</li>
                <li>{{ __('(Optional) After selecting a branch, filter down further by department (e.g., Ushering, Choir, Youth).') }}</li>
                <li>{{ __('(Optional) If needed, assign the group to a specific designation within the department (e.g., Head Usher, Lead Vocalist).') }}</li>
                <li>{{ __('Finally, click Assign Group to save. The selected WhatsApp group will now be linked to the chosen branch, department, or designation.') }}</li>
            </ul>
            <p class="text-muted small">
                {{ __('💡 Tip: If you leave Branch, Department, and Designation empty, the WhatsApp group will be assigned globally to all members in the workspace.') }}
            </p>
            <br>

            @permission('connect_whatsApp create')

       
            {!! Form::open(['route' => 'wa_group.store']) !!}

            {{-- WhatsApp Group (single select) --}}
            <div class="mb-3">
                {{ Form::label('group_id', __('WhatsApp Group')) }} <x-required />
                {{ Form::select('group_id', $groupOptions, null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select WhatsApp Group'),
                    'id' => 'group-select',
                    'required' => true,
                ]) }}
            </div>
            {{ Form::hidden('group_name', null, ['id' => 'group-name']) }}

            {{-- Branch (single select) --}}
            <div class="mb-3">
                {{ Form::label('branch_id', __('Select Branch')) }}
                {{ Form::select('branch_id', $branches, null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Branch'),
                    'id' => 'branch-select'
                ]) }}
            </div>

            {{-- Department (single select, filtered by branch) --}}
            <div class="mb-3">
                {{ Form::label('department_id', __('Select Department')) }}
                {{ Form::select('department_id', [], null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Department'),
                    'id' => 'department-select'
                ]) }}
            </div>

            {{-- Designation (single select, filtered by department) --}}
            <div class="mb-3">
                {{ Form::label('designation_id', __('Select Designation')) }}
                {{ Form::select('designation_id', [], null, [
                    'class' => 'form-control select2',
                    'placeholder' => __('Select Designation'),
                    'id' => 'designation-select'
                ]) }}
            </div>

            <button type="submit" class="btn btn-primary">
                {{ __('Assign Group') }}
            </button>

            {!! Form::close() !!}
        
        @endpermission
        </div>
    </div>
</div>
@endsection





@push('scripts')
<script>
    const getDepartmentsUrl = "{{ route('departments.byBranch') }}";
    const getDesignationsUrl = "{{ route('designations.byDepartment') }}";

document.addEventListener('DOMContentLoaded', function () {
    const groupSelect = document.getElementById('group-select');
    const groupNameInput = document.getElementById('group-name');
    const branchSelect = document.getElementById('branch-select');
    const departmentSelect = document.getElementById('department-select');
    const designationSelect = document.getElementById('designation-select');

    const groupOptions = @json($groupOptions);

    // Update hidden group_name on group select
    if (groupSelect) {
        groupSelect.addEventListener('change', function () {
            groupNameInput.value = groupOptions[this.value] || '';
        });
    }

    // Fetch departments when branch changes
    if (branchSelect) {
        branchSelect.addEventListener('change', function () {
            const branchId = this.value;
            // Always reset with placeholder first
                    departmentSelect.innerHTML = '<option value="" disabled selected>{{ __("Select Department") }}</option>';
                    designationSelect.innerHTML = '<option value="" disabled selected>{{ __("Select Designation") }}</option>';

            if (!branchId) return;

            fetch(`${getDepartmentsUrl}?branch=${branchId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        departmentSelect.appendChild(option);
                    });
                });
        });
    }

   // Fetch designations when department changes
    if (departmentSelect) {
        departmentSelect.addEventListener('change', function () {
            const departmentId = this.value;

            // Reset with placeholder
            designationSelect.innerHTML = '<option value="" disabled selected>{{ __("Select Designation") }}</option>';

            if (!departmentId) return;

            fetch(`${getDesignationsUrl}?department=${departmentId}`)
                .then(res => res.json())
                .then(data => {
                    Object.entries(data).forEach(([id, name]) => {
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = name;
                        designationSelect.appendChild(option);
                    });
                });
        });
    }
});
</script>
@endpush

@extends('layouts.main')

@php
    $company_settings = getCompanyAllSetting();
    $department_name = $company_settings['churchly_department_name'] ?? __('Department');
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
@endphp

@section('page-title')
    {{ $department_name }}
@endsection

@section('page-breadcrumb')
    {{ __('Church Department') }}
@endsection

@section('page-action')
    @permission('church_department create')
        <a href="javascript:void(0)"
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="{{ __('Create ' . $department_name) }}"
           data-url="{{ route('churchly.departments.create') }}"
           data-toggle="tooltip"
           title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endpermission
@endsection

@section('content')
<div class="row">
    <div class="col-sm-3">
        @include('churchly::layouts.churchly_setup')
    </div>

    <div class="col-sm-9">
        <div class="card mb-3">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="mb-0">{{ $department_name }}</h4>
                </div>
            </div>
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ $department_name }}</th>
                                <th>{{ $branch_name }}</th>
                                <th width="120px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($departments as $department)
                                <tr>
                                    <td>{{ $department->name ?? '-' }}</td>
                                    <td>{{ $department->branch->name ?? '-' }}</td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            @permission('church_department edit')
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="{{ route('churchly.departments.edit', $department->id) }}"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="{{ __('Edit ' . $department_name) }}"
                                                   data-bs-toggle="tooltip"
                                                   title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            @endpermission

                                            @permission('church_department delete')
                                                {!! Form::open([
                                                    'route' => ['churchly.departments.destroy', $department->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $department->id
                                                ]) !!}
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="{{ __('Delete') }}"
                                                       data-confirm="{{ __('Are You Sure?') }}"
                                                       data-text="{{ __('This action cannot be undone. Do you want to continue?') }}"
                                                       data-confirm-yes="delete-form-{{ $department->id }}">
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
</div>
@endsection

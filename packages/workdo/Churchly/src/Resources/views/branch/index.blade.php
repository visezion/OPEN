@extends('layouts.main')

@php
    $company_settings = getCompanyAllSetting();
    $branch_name = $company_settings['churchly_branch_name'] ?? __('Branch');
@endphp

@section('page-title')
    {{ $branch_name }}
@endsection

@section('page-breadcrumb')
    {{ __('Church Branch') }}
@endsection

@section('page-action')
    @permission('church_branch create')
        <a href="javascript:void(0)" 
           class="btn btn-sm btn-primary"
           data-ajax-popup="true"
           data-size="md"
           data-title="{{ __('Create Branch') }}"
           data-url="{{ route('churchbranch.create') }}"
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
          @permission('church_branch edit')
            <div class="card mb-3">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h4 class="mb-0">{{ $branch_name }}</h4>
                    <a href="javascript:void(0)"
                       class="btn btn-sm bg-info text-white"
                       data-url="{{ route('branchname.edit') }}"
                       data-ajax-popup="true"
                       data-size="md"
                       data-title="{{ __('Edit ' . $branch_name) }}"
                       data-bs-toggle="tooltip"
                       title="{{ __('Edit Name') }}">
                        <i class="ti ti-pencil"></i>
                    </a>
                </div>
            </div>
        @endpermission
          

        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>{{ $branch_name }}</th>
                                <th width="100px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ $branch->name ?? '-' }}</td>
                                    <td class="Action text-center">
                                        <div class="d-flex justify-content-center">
                                            @permission('church_branch edit')
                                                <a href="javascript:void(0)"
                                                   class="btn btn-sm bg-info text-white mx-1"
                                                   data-url="{{ route('churchbranch.edit', $branch->id) }}"
                                                   data-ajax-popup="true"
                                                   data-size="md"
                                                   data-title="{{ __('Edit Branch') }}"
                                                   data-bs-toggle="tooltip"
                                                   title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                            @endpermission

                                            @permission('church_branch delete')
                                                {!! Form::open([
                                                    'route' => ['churchbranch.destroy', $branch->id],
                                                    'method' => 'DELETE',
                                                    'class' => 'd-inline m-0 p-0',
                                                    'id' => 'delete-form-' . $branch->id
                                                ]) !!}
                                                    <a href="javascript:void(0)"
                                                       class="btn btn-sm bg-danger text-white mx-1 show_confirm"
                                                       data-bs-toggle="tooltip"
                                                       title="{{ __('Delete') }}"
                                                       data-confirm="{{ __('Are You Sure?') }}"
                                                       data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                       data-confirm-yes="delete-form-{{ $branch->id }}">
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

@extends('layouts.main')
@section('page-title')
    {{ __('Email Templates') }}
@endsection
@section('page-breadcrumb')
    {{ __('Email Templates') }}
@endsection
@section('page-action')
@endsection
@push('css')
    @include('layouts.includes.datatable-css')
    <style>
        .email-template-index .email-template-card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .email-template-index .email-template-card .card-body {
            padding: 0;
        }

        .email-template-index .table-responsive {
            border: 0 !important;
            border-radius: 14px;
        }

        .email-template-index table.dataTable thead th {
            background: #f8fbff;
            border-bottom: 1px solid #d8e2ef !important;
            color: #5f7696;
            font-size: 12px;
            letter-spacing: .04em;
            text-transform: uppercase;
            font-weight: 700;
        }

        .email-template-index table.dataTable tbody td {
            border-bottom: 1px solid #e7edf6 !important;
            color: #1f3a62;
            vertical-align: middle;
        }

        .email-template-index table.dataTable tbody tr:last-child td {
            border-bottom: 0 !important;
        }
    </style>
@endpush
@section('content')
    <div class="row email-template-index">
        <div class="col-md-12">
            <div class="card email-template-card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        {{ $dataTable->table(['width' => '100%']) }}
                    </div>
                </div>
            </div>
        </div>
        <!-- [ basic-table ] end -->
    </div>
@endsection

@push('scripts')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
@endpush

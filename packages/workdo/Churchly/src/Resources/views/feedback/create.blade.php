@extends('layouts.main')

@section('page-title', __('Submit Weekly Report'))
@section('page-breadcrumb', __('Reports'))

@section('page-action')
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="{{ __('Reports Dashboard') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-danger btn-icon me-1" data-bs-toggle="tooltip" title="{{ __('Go Back') }}">
        <i class="ti ti-arrow-back-up"></i>
    </a>
@endsection

@section('content')
    @include('churchly::feedback._wizard', [
        'formRoute' => ['feedback.store'],
        'formMethod' => 'post',
        'feedback' => null,
    ])
@endsection

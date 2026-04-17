@extends('layouts.main')

@section('page-title', __('Report Details'))
@section('page-breadcrumb', __('Reports'))

@section('page-action')
    <a href="{{ route('feedback.dashboard') }}" class="btn btn-sm btn-primary btn-icon me-2" data-bs-toggle="tooltip" title="{{ __('Reports Dashboard') }}">
        <i class="ti ti-layout-grid text-white"></i>
    </a>
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-danger me-1" data-bs-toggle="tooltip" title="{{ __('Go Back') }}">
        <i class="ti ti-arrow-back-up"></i>
    </a>
    <a href="{{ route('feedback.create') }}" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="{{ __('Create Report') }}">
        <i class="ti ti-plus"></i>
    </a>
    @permission('feedback edit')
        <a href="{{ route('feedback.edit', \Illuminate\Support\Facades\Crypt::encrypt($feedback->id)) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Edit Report') }}">
            <i class="ti ti-pencil"></i>
        </a>
    @endpermission
@endsection

@section('content')
    @if ($feedback->isReport())
        @include('churchly::feedback._report_sections', ['feedback' => $feedback, 'attendanceSummary' => $attendanceSummary])
    @else
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">{{ $feedback->title ?? __('Untitled Feedback') }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3"><strong>{{ __('Submitted By') }}:</strong> {{ $feedback->is_anonymous ? __('Anonymous') : ($feedback->name ?? 'N/A') }}</div>
                <div class="mb-3"><strong>{{ __('Department') }}:</strong> {{ optional($feedback->department)->name ?? 'N/A' }}</div>
                <div class="mb-3"><strong>{{ __('Submitted At') }}:</strong> {{ $feedback->formatted_submitted_at }}</div>
                <div class="border rounded-3 p-3 bg-light">{!! $feedback->message !!}</div>
            </div>
        </div>
    @endif
@endsection

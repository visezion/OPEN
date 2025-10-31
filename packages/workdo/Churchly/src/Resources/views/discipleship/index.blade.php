@extends('layouts.main')
@php
    $company_settings = getCompanyAllSetting();   
@endphp

@section('page-action')
    @permission('discipleship create')
        <a href="{{ route('discipleship.setup') }}" class="btn btn-sm btn-primary" title="{{ __('Create') }}">
            <i class="ti ti-plus"> Create Pathways</i>
        </a>
        <a href="{{ route('discipleship.progress') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-eye"></i> {{ __('See Member Progress') }}
        </a>
    @endpermission
@endsection

@section('page-title', __('Discipleship Pathways Setup'))

@section('content')
<div class="row">
   

    {{-- Main Content --}}
    <div class="col-sm-9">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="mb-3"><i class="ti ti-route text-primary"></i> {{ __('All Discipleship Stages') }}</h5>
                <p class="text-muted small mb-4">
                    {{ __('Stages represent a member’s spiritual growth journey. Each stage contains requirements that must be completed to progress.') }}
                </p>

                @if($stages->count())
                    <div class="list-group">
                        @foreach($stages as $stage)
                            <div class="list-group-item border rounded mb-3 shadow-sm">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold">{{ $stage->order }}. {{ $stage->name }}</h6>
                                        <p class="text-muted small mb-2">{{ $stage->description }}</p>

                                        @if($stage->requirements->count())
                                            <ul class="small ps-3 mb-2">
                                                @foreach($stage->requirements as $req)
                                                    <li>
                                                        <b>{{ $req->title }}</b>
                                                        <span class="badge bg-light text-dark">{{ ucfirst($req->type) }}</span>
                                                        @if($req->is_mandatory) <span class="badge bg-danger">Mandatory</span>@endif
                                                        @if($req->requires_approval) <span class="badge bg-warning text-dark">Approval</span>@endif
                                                        @if($req->points) <span class="badge bg-success">{{ $req->points }} pts</span>@endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted small"><i>{{ __('No requirements added yet.') }}</i></p>
                                        @endif
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('discipleship.edit', $stage->id) }}" class="btn btn-sm btn-outline-primary mb-1" title="Edit">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form action="{{ route('discipleship.destroy', $stage->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger mb-1" onclick="return confirm('Are you sure you want to delete this stage?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                        <a href="{{ route('discipleship.show', $stage->id) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-light text-muted small">
                        <i class="ti ti-info-circle"></i> {{ __('No discipleship pathways have been created yet.') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Help Section + Diagram --}}
    <div class="col-sm-3">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('Managing Pathways') }}</h6>
                <p class="small text-muted mb-2">
                    {{ __('Each pathway represents a stage of discipleship. From this page you can:') }}
                </p>
                <ul class="small text-muted ps-3">
                    <li>👀 View stage requirements</li>
                    <li>✏️ Edit stage details</li>
                    <li>➕ Add new stages</li>
                    <li>🗑️ Delete stages</li>
                </ul>

                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> {{ __('Think of discipleship as a journey. Each stage is a milestone leading to the next.') }}
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="ti ti-map text-success"></i> {{ __('Pathway Diagram') }}
                </h6>
                <p class="small text-muted mb-3">
                    {{ __('This diagram shows your discipleship journey as a flow. Hover over each stage to see requirements.') }}
                </p>

                <div class="mermaid text-center" style="overflow-x:auto;">
                    graph LR
                    @foreach($stages as $stage)
                        stage{{ $stage->id }}["{{ $stage->order }}. {{ $stage->name }}"]:::stage
                        @php $next = $stages->where('order', $stage->order+1)->first(); @endphp
                        @if($next)
                            stage{{ $stage->id }} --> stage{{ $next->id }}
                        @endif
                    @endforeach

                    classDef stage fill:#4e73df,stroke:#2e59d9,color:#fff,font-weight:bold,rx:15,ry:15;
                </div>

                <div class="mt-4">
                    <h6 class="fw-bold"><i class="ti ti-list-details text-primary"></i> {{ __('Stage Requirements') }}</h6>
                    <ul class="list-group small">
                        @foreach($stages as $stage)
                            <li class="list-group-item">
                                <b>{{ $stage->order }}. {{ $stage->name }}</b>
                                <ul class="text-muted small ps-3 mb-1">
                                    @forelse($stage->requirements as $req)
                                        <li>
                                            {{ $req->title }}
                                            <span class="badge bg-light text-dark">{{ ucfirst($req->type) }}</span>
                                            @if($req->is_mandatory) <span class="badge bg-danger">Mandatory</span>@endif
                                            @if($req->requires_approval) <span class="badge bg-warning text-dark">Approval</span>@endif
                                            @if($req->points) <span class="badge bg-success">{{ $req->points }} pts</span>@endif
                                        </li>
                                    @empty
                                        <li><i class="text-muted">No requirements yet.</i></li>
                                    @endforelse
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Mermaid.js --}}
<script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function(){
    mermaid.initialize({
        startOnLoad:true,
        theme: 'base',
        themeVariables: {
            primaryColor: '#4e73df',
            primaryBorderColor: '#2e59d9',
            fontSize: '14px',
            fontFamily: 'Inter, sans-serif'
        }
    });
});
</script>
@endsection

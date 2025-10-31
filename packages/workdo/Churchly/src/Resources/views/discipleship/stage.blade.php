@extends('layouts.main')


@section('page-title', __('Discipleship Stage Details'))

@section('content')
<div class="row">
    {{-- Left Sidebar --}}
    

    {{-- Main Stage Details --}}
    <div class="col-sm-9">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="mb-2"><i class="ti ti-flag text-primary"></i> {{ $stage->name }}</h5>
                <p class="text-muted small">{{ $stage->description }}</p>
                <span class="badge bg-secondary">{{ __('Order:') }} {{ $stage->order }}</span>
            </div>
        </div>

        {{-- Requirements --}}
        @if($stage->requirements->count())
            @foreach($stage->requirements as $req)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1">{{ $req->title }} <span class="text-muted">({{ ucfirst($req->type) }})</span></h6>
                        <p class="text-muted small mb-2">{{ $req->description }}</p>

                        {{-- Badges --}}
                        <div class="mb-2">
                            @if($req->is_mandatory)
                                <span class="badge bg-danger">{{ __('Mandatory') }}</span>
                            @endif
                            @if($req->requires_approval)
                                <span class="badge bg-warning text-dark">{{ __('Requires Approval') }}</span>
                            @endif
                            @if($req->points)
                                <span class="badge bg-success">{{ $req->points }} {{ __('Points') }}</span>
                            @endif
                        </div>

                        {{-- Checklist items --}}
                        @if($req->checklists && $req->checklists->count())
                            <ul class="list-group small">
                                @foreach($req->checklists as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $item->item }}
                                        <span class="badge {{ $item->is_completed ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $item->is_completed ? __('Done') : __('Pending') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted small">{{ __('No checklist items for this requirement.') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-secondary">
                {{ __('No requirements defined for this stage yet.') }}
            </div>
        @endif

        {{-- Back button --}}
        <a href="{{ route('discipleship.index') }}" class="btn btn-outline-secondary mt-2">
            <i class="ti ti-arrow-left"></i> {{ __('Back to Pathways') }}
        </a>
    </div>

    {{-- Right Help Panel --}}
    <div class="col-sm-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><i class="ti ti-info-circle text-primary"></i> {{ __('Stage Overview') }}</h6>
                <p class="small text-muted">
                    {{ __('A discipleship stage represents a key milestone in spiritual growth. Each requirement under the stage must be completed before members can move forward.') }}
                </p>

                <ul class="small text-muted ps-3">
                    <li>✅ Review all requirements & checklists.</li>
                    <li>👥 Track member progress per requirement.</li>
                    <li>📝 Update or add new requirements via the Edit page.</li>
                </ul>

                <div class="alert alert-info small mt-3">
                    <i class="ti ti-lightbulb"></i> <b>Tip:</b> Use <code>Points</code> to motivate members and <code>Approval</code> for mentor validation.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

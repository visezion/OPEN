@extends('layouts.main')
@php
    $company_settings = getCompanyAllSetting();
@endphp

@section('page-title', __('My Discipleship Journey'))

@section('content')
<div class="row">
    {{-- Sidebar --}}
    

    {{-- Main Journey --}}
    <div class="col-sm-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">
                    <i class="ti ti-road text-primary"></i> {{ __('My Discipleship Journey') }}
                </h5>
                <p class="text-muted small">
                    {{ __('Track your spiritual growth, complete requirements, and move through each stage of discipleship.') }}
                </p>

                {{-- Loop through stages --}}
                @foreach($stages as $stage)
                    @php
                        $stageProgress   = $member->progress->where('stage_id', $stage->id);
                        $completedCount  = $stageProgress->where('status','completed')->count();
                        $totalCount      = $stage->requirements->count();
                        $percentage      = $totalCount > 0 ? round(($completedCount/$totalCount)*100) : 0;

                        $prevStage       = $stages->where('order', $stage->order - 1)->first();
                        $prevCompleted   = !$prevStage || $member->progress->where('stage_id', $prevStage->id)->where('status', 'completed')->count() == $prevStage->requirements->count();
                        $currentCompleted= $member->progress->where('stage_id', $stage->id)->where('status', 'completed')->count() == $stage->requirements->count();
                    @endphp

                    <div class="card mb-4 border">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h6 class="mb-0 fw-bold">
                                {{ $stage->order }}. {{ $stage->name }}
                                @if($currentCompleted)
                                    <span class="badge bg-primary">Completed</span>
                                @elseif(!$prevCompleted)
                                    <span class="badge bg-secondary">🔒 Locked</span>
                                @endif
                            </h6>
                            <span class="badge bg-info">{{ $percentage }}% {{ __('Completed') }}</span>
                        </div>

                        <div class="card-body">
                            <p class="text-muted small">{{ $stage->description }}</p>

                            {{-- Progress bar --}}
                            <div class="progress mb-3" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: {{ $percentage }}%;"></div>
                            </div>

                            {{-- Stage Status --}}
                            @if(!$prevCompleted)
                                <p class="text-muted"><i class="ti ti-lock"></i> {{ __('Complete the previous stage to unlock this one.') }}</p>
                            @elseif($currentCompleted)
                                <ul>
                                    @foreach($stage->requirements as $req)
                                        <li>{{ $req->title }} <span class="badge bg-success">Completed</span></li>
                                    @endforeach
                                </ul>
                            @else
                                {{-- Requirements --}}
                                @if($stage->requirements->count())
                                    <ul class="list-group">
                                        @foreach($stage->requirements as $req)
                                            @php
                                                $progress = $member->progress->firstWhere('requirement_id', $req->id);
                                            @endphp
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <b>{{ $req->title }}</b>
                                                        <span class="badge bg-light text-dark">{{ ucfirst($req->type) }}</span>
                                                        @if($req->is_mandatory) <span class="badge bg-danger">Mandatory</span>@endif
                                                        @if($req->requires_approval) <span class="badge bg-warning text-dark">Approval</span>@endif
                                                        @if($req->points) <span class="badge bg-success">{{ $req->points }} pts</span>@endif
                                                        <p class="text-muted small mb-1">{{ $req->description }}</p>

                                                        {{-- Status --}}
                                                        @if($progress)
                                                            @if($progress->status == 'completed')
                                                                <span class="badge bg-primary"> Completed</span>
                                                            @elseif($progress->status == 'in_review')
                                                                <span class="badge bg-warning text-dark">⏳ In Review</span>
                                                            @elseif($progress->status == 'pending')
                                                                <span class="badge bg-secondary">🕒 Pending</span>
                                                            @endif
                                                        @else
                                                            <span class="badge bg-light text-dark">Not Started</span>
                                                        @endif
                                                    </div>

                                                    {{-- Interaction / Submit --}}
                                                    <div>
                                                        <form action="{{ route('discipleship.requirement.submit', $req->id) }}" method="POST" enctype="multipart/form-data" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="member_id" value="{{ $member->id }}">

                                                            @if($req->type == 'self_check')
                                                                <button class="btn btn-sm btn-outline-primary">Mark as Done</button>
                                                            @elseif($req->type == 'file_upload')
                                                                <input type="file" name="evidence" class="form-control form-control-sm mb-1" required>
                                                                <button class="btn btn-sm btn-outline-primary">Upload</button>
                                                            @elseif($req->type == 'custom_text')
                                                                <input type="text" name="evidence" class="form-control form-control-sm mb-1" placeholder="Write your testimony..." required>
                                                                <button class="btn btn-sm btn-outline-primary">Submit</button>
                                                            @elseif($req->type == 'quiz')
                                                                <a href="{{ route('quiz.start', $req->id) }}" class="btn btn-sm btn-outline-info">Take Quiz</a>
                                                            @elseif($req->type == 'attendance')
                                                                <span class="badge bg-secondary">Auto-tracked</span>
                                                            @elseif($req->type == 'mentor_approval')
                                                                <span class="badge bg-secondary">Awaiting Mentor Approval</span>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">{{ __('No requirements added yet.') }}</p>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection

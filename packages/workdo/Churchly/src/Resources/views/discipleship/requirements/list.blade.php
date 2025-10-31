<div class="p-4 bg-white shadow rounded-3 h-100">
    <h5 class="fw-bold mb-3">
        <i class="ti ti-list-details text-primary"></i> {{ __('Stage Requirements') }}
    </h5>

    <ul class="list-group list-group-flush small">
        @foreach($stages as $stage)
            <li class="list-group-item">
                <b>{{ $stage->order }}. {{ $stage->name }}</b>
                <ul class="text-muted small ps-3 mb-1">
                    @forelse($stage->requirements as $req)
                        <li class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                {{ $req->title }}
                                <span class="badge bg-light text-dark">{{ ucfirst($req->type) }}</span>
                                @if($req->is_mandatory) <span class="badge bg-danger">Mandatory</span>@endif
                                @if($req->requires_approval) <span class="badge bg-warning text-dark">Needs Approval</span>@endif
                                @if($req->points) <span class="badge bg-success">{{ $req->points }} pts</span>@endif
                            </div>

                            <div>
                                @php
                                    $progress = $member->progress->where('requirement_id',$req->id)->first();
                                @endphp

                                @if(!$progress)
                                    @include('churchly::discipleship.requirements.form', ['req' => $req])
                                @else
                                    <span class="badge bg-{{ 
                                        $progress->status === 'approved' ? 'success' : 
                                        ($progress->status === 'rejected' ? 'danger' : 
                                        ($progress->status === 'in_review' ? 'warning text-dark' : 'secondary')) }}">
                                        {{ ucfirst($progress->status) }}
                                    </span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li><i class="text-muted">No requirements yet.</i></li>
                    @endforelse
                </ul>
            </li>
        @endforeach
    </ul>
</div>

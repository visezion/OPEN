@extends('layouts.main')

@section('page-title', __("$member->name Profile"))


@section('page-action')
    <a href="{{ route('members.edit', Crypt::encrypt($member->id)) }}" class="btn btn-sm btn-primary">
        <i class="ti ti-pencil"></i> {{ __('Edit Profile') }}
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- Profile Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <!-- Small Avatar (list view style) -->
                  
                    <img 
                        src="{{ $member->profile_photo 
                            ? asset('storage/'.$member->profile_photo) 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=random' }}" 
                        alt="Profile Picture"
                        class="rounded-circle shadow-sm border"
                        style="width:150px; height:150px; object-fit:cover; padding:15px; margin-right:20px;"
                    >

                    

                    <div>
                        <h4 class="mb-0">{{ $member->name }}</h4>
                        <small>{{ $member->email }} | {{ $member->phone }}</small>
                        <div class="mt-2">
                            <span class="badge {{ $member->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $member->is_active ? __('Active') : __('Inactive') }}
                            </span>
                            <span class="ms-2">{{ __('Member since:') }} {{ $member->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                
                <div class="text-end">
                    <!-- Quick Actions -->
                    <a href="tel:{{ $member->phone }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-phone"></i></a>
                    <a href="mailto:{{ $member->email }}" class="btn btn-outline-primary btn-sm"><i class="ti ti-mail"></i></a>
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="ti ti-brand-whatsapp"></i></a>
                    <a href="#" class="btn btn-outline-secondary btn-sm"><i class="ti ti-download"></i> PDF</a>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">{{ __('Overview') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#church">{{ __('Church Info') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#family">{{ __('Family Tree') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#teams">{{ __('Teams') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#donations">{{ __('Donations') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#attendance">{{ __('Attendance') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activity">{{ __('Activity') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#care">{{ __('Pastoral Care') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#smart-tags">{{ __('Smart Tags') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#discipleship">{{ __('Discipleship') }}</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#custom">{{ __('Custom Fields') }}</button></li>
        </ul>

        <div class="tab-content">
            <!-- Overview -->
            <div class="tab-pane fade show active" id="overview">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        {{-- ✅ Profile Completion --}}
                        <div class="card p-3 mb-3 shadow-sm border-0">
                            <h6><i class="ti ti-user-check"></i> {{ __('Profile Completion') }}</h6>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-primary" style="width: {{ $completion }}%"></div>
                            </div>
                            <small>{{ $completion }}% {{ __('Completed') }}</small>

                            @if($completion < 100)
                                <ul class="mt-2 text-danger small">
                                    @foreach($missingFields as $field)
                                        <li>{{ $field }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- ✅ Engagement Score --}}
                        <div class="card p-3 mb-3 shadow-sm border-0">
                            <h6><i class="ti ti-activity-heartbeat"></i> {{ __('Engagement Score') }}</h6>
                            <h3 class="text-primary">{{ $engagementScore }}/100</h3>
                            <small>{{ __('Based on attendance, giving, volunteering') }}</small>
                        </div>

                        

                        {{-- ✅ Departments & Designations --}}
                        <div class="card p-3 mb-3 shadow-sm border-0" >
                            <h6 class="mb-3">
                                <i class="ti ti-building-church text-primary"></i>
                                {{ __('Branch & Ministries') }}
                            </h6>

                            {{-- Branch --}}
                            <div class="mb-1">
                                <i class="ti ti-home-heart text-success"></i>
                                <strong>{{ __('Branch:') }}</strong>
                                <span class="text-dark">{{ $member->branch->name ?? __('Not Assigned') }}</span>
                            </div>

                            {{-- Departments --}}
                            @if($member->departments && $member->departments->count())
                                <div class="list-group list-group-flush" >
                                    @foreach($member->departments as $dept)
                                        <div class="list-group-item border-0 px-0 mb-1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <i class="ti ti-users text-info me-2"></i>
                                                    <span class="fw-semibold">{{ $dept->name }}</span>
                                                    @if($dept->pivot && $dept->pivot->designation_id)
                                                        <span class="badge bg-light text-dark ms-2">
                                                            <i class="ti ti-id-badge text-muted"></i>
                                                            {{ optional(\Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id))->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Department Members Avatars --}}
                                            <div class="mt-2" >
                                                @php
                                                    $mates = $dept->members()
                                                        ->where('church_members.id', '!=', $member->id) // exclude current member
                                                        ->limit(5)
                                                        ->get();
                                                @endphp

                                                @if($mates->count())
                                                    <div class="d-flex align-items-center">
                                                        <div style="margin-left:30px;"></div>
                                                        @foreach($mates as $index => $mate)
                                                            <img src="{{ $mate->profile_photo 
                                                                ? asset('storage/'.$mate->profile_photo) 
                                                                : 'https://ui-avatars.com/api/?name='.urlencode($mate->name).'&size=50&background=random' }}"
                                                                class="rounded-circle border border-white"
                                                                style="width:30px; height:30px; object-fit:cover; margin-left:-10px; z-index:{{ 10 - $index }};"
                                                                title="{{ $mate->name }}">
                                                        @endforeach

                                                        @if($dept->members()->count() > 5)
                                                            <span class="rounded-circle bg-primary text-white small d-flex align-items-center justify-content-center border border-white"
                                                                style="width:35px; height:35px; margin-left:-10px;">
                                                                +{{ $dept->members()->count() - 5 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <p class="text-muted small mb-0">{{ __('No other members in this department.') }}</p>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">
                                    <i class="ti ti-circle-dashed"></i> {{ __('No departments or designations assigned.') }}
                                </p>
                            @endif
                        </div>


                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="row">
                            {{-- ✅ Birthday Countdown --}}
                            <div class="col-md-9 mb-3">
                                <div class="card p-4 shadow-sm border-0 text-center h-100">
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <div class="rounded-circle bg-light p-3 shadow-sm">
                                            <i class="ti ti-cake text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                    </div>
                                    <h5 class="fw-bold mb-3">{{ __('Birthday Countdown') }}</h5>

                                    @if($birthdayCountdown !== null)
                                        @if($birthdayCountdown == 0)
                                            <h4 class="text-success fw-bold mb-2">🎉 Happy Birthday {{ $member->name }}! 🎂</h4>
                                            <p class="text-muted">Wishing you joy, health and blessings today.</p>
                                        @else
                                            <p class="text-muted mb-3">
                                                🎂 {{ $member->name }}’s birthday is on 
                                                <strong class="text-dark">{{ $birthdayDate }}</strong> 
                                                ({{ $birthdayCountdown }} days left)
                                            </p>
                                            {{-- Month-by-month stepper --}}
                                            <div class="d-flex justify-content-between">
                                                @foreach(range(1,12) as $m)
                                                    <div class="text-center flex-fill">
                                                        <div class="rounded-circle 
                                                            {{ $m == $birthdayMonth ? 'bg-success text-white' : ($m == now()->month ? 'bg-primary text-white' : 'bg-light') }}
                                                            d-inline-flex align-items-center justify-content-center shadow-sm"
                                                            style="width:35px;height:35px;">
                                                            {{ substr(\Carbon\Carbon::create()->month($m)->format('M'),0,1) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-muted fst-italic">No date of birth provided.</p>
                                    @endif
                                </div>
                            </div>

                            {{-- ✅ Quick Actions --}}
                            <div class="col-md-3 mb-3">
                                <div class="card p-3 shadow-sm border-0 text-center h-100">
                                    <h6 class="mb-3"><i class="ti ti-send text-success me-2"></i> {{ __('Quick Actions') }}</h6>
                                    <div class="d-grid gap-2">
                                        <a href="" class="btn btn-outline-primary btn-sm">
                                            <i class="ti ti-message"></i> {{ __('Message') }}
                                        </a>
                                        <a href="" class="btn btn-outline-success btn-sm">
                                            <i class="ti ti-heart-dollar"></i> {{ __('Donation') }}
                                        </a>
                                        <a href="" class="btn btn-outline-warning btn-sm">
                                            <i class="ti ti-calendar-check"></i> {{ __('Attendance') }}
                                        </a>
                                        <a href="{{ route('members.edit', Crypt::encrypt($member->id)) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="ti ti-pencil"></i> {{ __('Edit') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- ✅ Recent Activities --}}
                            <div class="col-md-12">
                                <div class="card p-3 shadow-sm border-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-clock text-primary me-2"></i>
                                        <h6 class="mb-0">{{ __('Recent Activity') }}</h6>
                                    </div>

                                    @if($activities && $activities->count())
                                        <ul class="timeline list-unstyled small ps-3">
                                            @foreach($activities->take(5) as $act)
                                                <li class="mb-2">
                                                    <span class="fw-bold">{{ ucfirst($act->type ?? 'Activity') }}</span> – 
                                                    {{ $act->description }}
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="ti ti-calendar"></i> {{ $act->created_at->diffForHumans() }}
                                                    </small>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <a href="#" class="small text-primary">
                                            <i class="ti ti-list"></i> {{ __('View all activities') }}
                                        </a>
                                    @else
                                        <p class="text-muted fst-italic">{{ __('No recent activity logged.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Church Info -->
            <div class="tab-pane fade" id="church">
                <div class="card p-4 shadow-sm border-0">
                    <div class="row">
                        <!-- Left: Church Details -->
                        <div class="col-md-3 border-end">
                            <h6 class="mb-3">
                                <div class="card p-4 shadow-sm border-0">
                                <i class="ti ti-building-church text-primary"></i>
                                {{ __('Church Details') }}
                            </h6>
                            <div class="card p-4 shadow-sm border-0">
                            <p><strong><i class="ti ti-brand-whatsapp text-success"></i> {{ __('Group ID:') }}</strong> {{ $member->group_id }}</p>
                            <p><strong><i class="ti ti-id text-muted"></i> {{ __('Member ID:') }}</strong> {{ $member->member_id }}</p>
                            <p><strong><i class="ti ti-home-heart text-success"></i> {{ __('Branch:') }}</strong>
                                {{ $member->branch?->name ?? __('Not Assigned') }}
                            </p>

                            {{-- Departments & Designations --}}
                            @if($member->departments && $member->departments->count())
                                @foreach($member->departments as $dept)
                                    <div class="mb-3">
                                        <p class="mb-1">
                                            <i class="ti ti-users text-info"></i>
                                            <strong>{{ $dept->name }}</strong>
                                            @if($dept->pivot && $dept->pivot->designation_id)
                                                <span class="badge bg-light text-dark ms-2">
                                                    <i class="ti ti-id-badge"></i>
                                                    {{ optional(\Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id))->name }}
                                                </span>
                                            @endif
                                        </p>

                                        {{-- Teammates Avatars --}}
                                        @php
                                            $mates = $dept->members()->where('church_members.id', '!=', $member->id)->get();
                                            $totalMates = $mates->count();
                                        @endphp

                                        @if($totalMates)
                                            <div class="d-flex align-items-center mb-1">
                                                @foreach($mates->take(5) as $index => $mate)
                                                    <a href="{{ route('members.show', Crypt::encrypt($mate->id)) }}" title="{{ $mate->name }}">
                                                        <img src="{{ $mate->profile_photo
                                                            ? asset('storage/'.$mate->profile_photo)
                                                            : 'https://ui-avatars.com/api/?name='.urlencode($mate->name).'&size=50&background=random' }}"
                                                            class="rounded-circle border border-white"
                                                            style="width:35px; height:35px; object-fit:cover; margin-left:-10px; z-index:{{ 10 - $index }};">
                                                    </a>
                                                @endforeach

                                                @if($totalMates > 5)
                                                    <span class="rounded-circle bg-primary text-white small d-flex align-items-center justify-content-center border border-white"
                                                        style="width:35px; height:35px; margin-left:-10px;">
                                                        +{{ $totalMates - 5 }}
                                                    </span>
                                                @endif
                                            </div>
                                            <small class="text-muted">{{ $totalMates }} {{ Str::plural('teammate', $totalMates) }} in this department</small>
                                        @else
                                            <p class="text-muted small mb-0">{{ __('No other members in this department.') }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">
                                    <i class="ti ti-circle-dashed"></i> {{ __('No departments or designations assigned.') }}
                                </p>
                            @endif
                        </div>
                    </div>

                        <!-- Right: Appreciation Note -->
                    <div class="col-md-9 d-flex align-items-center">
                            <div class="p-4 bg-light rounded shadow-sm">
                                <h6 class="text-primary mb-3">
                                    <i class="ti ti-heart text-danger"></i> {{ __('A Personal Letter to a Cherished Family Member') }}
                                </h6>

                                {{-- Greeting --}}
                                <p class="small text-muted mb-3">
                                    Dear <strong>{{ $member->name }}</strong>,
                                </p>

                                {{-- Introduction --}}
                                <p class="small text-muted mb-3">
                                    From the moment you joined us on
                                    <strong>{{ $member->church_doj ? \Carbon\Carbon::parse($member->church_doj)->format('F j, Y') : __('N/A') }}</strong>,  
                                    you became more than a record in our books you became a beloved member of this spiritual family.  
                                    We thank God for guiding your steps to this house, and for every way you have contributed to the growth of our community.  
                                </p>

                                {{-- Branch & Membership --}}
                                <p class="small text-muted mb-3">
                                    As part of our <strong>{{ $member->branch?->name ?? 'Main' }}</strong> branch, you have stood as a light among your brothers and sisters.  
                                    Your current status as <strong>{{ $member->membership_status ?? 'Active' }}</strong> reminds us of your commitment to walk faithfully with us.  
                                </p>

                                {{-- Department & Designation --}}
                                @if($member->departments && $member->departments->count())
                                    <p class="small text-muted mb-3">
                                        We also honor your service in the following ministries:  
                                        @foreach($member->departments as $dept)
                                            <br> • <strong>{{ $dept->name }}</strong>
                                            @if($dept->pivot?->designation_id)
                                                — {{ \Workdo\Churchly\Entities\ChurchDesignation::find($dept->pivot->designation_id)?->name }}
                                            @endif
                                        @endforeach
                                    </p>
                                @endif

                                {{-- Family relationships --}}
                                @if($member->spouse)
                                    <p class="small text-muted mb-3">
                                        Together with your spouse, <strong>{{ $member->spouse?->name }}</strong>,  
                                        your household is a living testimony of God’s grace.  
                                    </p>
                                @elseif($member->family)
                                    <p class="small text-muted mb-3">
                                        As part of the <strong>{{ $member->family?->name }}</strong> family group,  
                                        you have enriched our church not only as an individual but also as a pillar of your household.  
                                    </p>
                                @endif

                                {{-- Appreciation --}}
                                <p class="small text-muted mb-3">
                                    Your role as <strong>{{ $member->designation?->name ?? 'a committed servant of Christ' }}</strong>  
                                    inspires others to serve with humility, love, and strength. Every department you’ve touched and every team you’ve joined  
                                    has been strengthened because of your presence and dedication.  
                                </p>

                                {{-- Heartfelt thank you --}}
                                <p class="small text-muted mb-3">
                                    Thank you, <strong>{{ $member->name }}</strong>, for being more than just a member.  
                                    Thank you for being family our brother/sister, our encourager, and a true vessel of God’s work.  
                                    We look forward to many more years of fellowship, growth, and testimony with you by our side.  
                                </p>

                                {{-- Closing --}}
                                <p class="small text-muted mb-0">
                                    With love, honor, and blessings,<br>
                                    <strong>The Founder & Shepherd of this House</strong>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Family Tree -->
            <div class="tab-pane fade" id="family"> 
                
                <div class="card p-4 shadow-sm border-0">
                    <h6><i class="ti ti-users"></i> {{ __('Family Tree') }}</h6>
                    <div class="alert alert-light border rounded shadow-sm mt-4">
                        <h5 class="text-primary">
                            <i class="ti ti-heart text-danger"></i> {{ __('Our Family in Christ') }}
                        </h5>
                        <p class="mb-3 text-muted">
                            Beloved <strong>{{ $member->name }}</strong>, within this <strong>Family Tree</strong> we are reminded that the ties of faith are stronger than blood, for in Christ we are made one body and one household of God.  
                        </p>
                        <p class="mb-3 text-muted">
                            <em>“You are no longer strangers or outsiders. You are citizens with all of God’s holy people. You are members of God’s family, built on the foundation of the apostles and prophets, with Christ Jesus Himself as the cornerstone.”</em> 
                            (<strong>Ephesians 2:19-20</strong>)
                        </p>
                        <p class="mb-0 text-dark fw-semibold">
                            You are not just a name on a record; you are a living stone in God’s temple, a light to this generation, and a priceless part of His eternal family.  
                        </p>

                    </div>
                    <div id="church-tree" style="width:100%; height:700px; border:2px solid #eee;"></div>
                </div>
            </div>



           <!-- Teams --><!-- Teams / Departments -->
<div class="tab-pane fade" id="teams">
    <div class="card p-3 shadow-sm border-0">
        <h6 class="mb-5">
            <i class="ti ti-users text-primary"></i> {{ __('Teams (Departments)') }}
        </h6>

        @forelse($member->departments ?? [] as $dept)
            <div class="mb-4">
                <!-- Department / Team Name -->
                <h6 class="text-dark mb-2">
                    {{ $dept->name }}
                    <span class="badge bg-light text-primary">{{ __('Department') }}</span>
                </h6>

                <!-- Department Members -->
                <div class="row">
                    @foreach($dept->members ?? [] as $tm)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="d-flex align-items-center p-2 border rounded shadow-sm h-100">
                                <!-- Profile Picture -->
                                <img src="{{ $tm->profile_photo 
                                        ? asset('storage/'.$tm->profile_photo) 
                                        : 'https://ui-avatars.com/api/?name='.urlencode($tm->name) }}"
                                    class="rounded-circle me-3"
                                    style="width:50px;height:50px;object-fit:cover;">

                                <!-- Member Info -->
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $tm->name }}</h6>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-phone"></i> {{ $tm->phone ?? '-' }}
                                    </p>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-gift"></i> 
                                        {{ $tm->dob ? \Carbon\Carbon::parse($tm->dob)->format('M d') : '-' }}
                                    </p>
                                    <p class="small text-muted mb-1">
                                        <i class="ti ti-badge"></i> {{ $tm->pivot->designation_id ? \Workdo\Churchly\Entities\ChurchDesignation::find($tm->pivot->designation_id)->name : 'Member' }}
                                    </p>
                                </div>

                                <!-- Action -->
                                <div>
                                    <a href="mailto:{{ $tm->email }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Send Message">
                                        <i class="ti ti-mail"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-muted">{{ __('No departments assigned.') }}</p>
        @endforelse
    </div>
</div>


            <!-- Donations -->
            <div class="tab-pane fade" id="donations">
                <div class="card p-3 shadow-sm border-0">
                    <h6>{{ __('Giving Trends') }}</h6>
                    <canvas id="donationsChart"></canvas>
                </div>
            </div>

            <!-- Attendance -->
            <div class="tab-pane fade" id="attendance">
                <div class="card p-3 shadow-sm border-0">
                    <h6>{{ __('Attendance Calendar') }}</h6>
                    <div id="attendanceCalendar"></div>
                </div>
            </div>

            <!-- Activity -->
            <div class="tab-pane fade" id="activity">
                <div class="card p-3 shadow-sm border-0">
                    <h6>{{ __('Recent Activity') }}</h6>
                    <ul class="timeline">
                        @foreach($activities as $activity)
                            <li><strong>{{ $activity->type }}</strong> — {{ $activity->description }} <small class="text-muted">({{ $activity->created_at->diffForHumans() }})</small></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Discipleship -->

            <!-- Discipleship -->
<div class="tab-pane fade" id="discipleship">
    <div class="container-fluid py-4 bg-light">
        <div class="row">
            <!-- LEFT SIDE: Flow -->
            <div class="col-lg-7">
                 <div class="p-4 bg-white shadow rounded-3 h-100">
                <div class="text-center mb-5">
                    <h3 class="fw-bold text-dark">
                        <i class="ti ti-map text-success"></i> {{ __('Discipleship Pathway') }}
                    </h3>
                    <p class="text-muted">
                        {{ __('This flow shows your discipleship journey. Stages are color-coded to show your progress.') }}
                    </p>
                </div>

                <div class="d-flex flex-wrap justify-content-center align-items-center">
                    @foreach($stages as $stage)
                        @php
                            $progress = $member->progress->where('stage_id', $stage->id)->first();
                            $status = $progress?->status ?? 'pending';
                            $color = $status === 'completed' ? 'success' : ($status === 'active' ? 'warning' : 'primary');
                        @endphp

                        <div class="text-center mx-4 mb-5">
                            <div class="rounded-circle bg-{{ $color }} text-white fw-bold shadow d-flex align-items-center justify-content-center"
                                style="width:100px; height:100px; font-size:1.25rem;">
                                {{ $stage->order }}
                            </div>
                            <div class="mt-3 fw-bold text-dark">{{ $stage->name }}</div>
                        </div>

                        @if(!$loop->last)
                            <i class="ti ti-arrow-right text-secondary fs-3 mx-3"></i>
                        @endif
                    @endforeach
                </div>

                <!-- Legend -->
                <div class="text-center mt-3 mb-5">
                    <span class="badge bg-success px-3 py-2 me-2">Completed</span>
                    <span class="badge bg-warning text-dark px-3 py-2 me-2">Current</span>
                    <span class="badge bg-primary px-3 py-2">Pending</span>
                </div>
            </div>
            </div>

            <!-- RIGHT SIDE: Stage Requirements -->
            <div class="col-lg-5">
                <div class="p-4 bg-white shadow rounded-3 h-100">
                    <h5 class="fw-bold mb-3">
                        <i class="ti ti-list-details text-primary"></i> {{ __('Stage Requirements') }}
                    </h5>
                    <ul class="list-group list-group-flush">
                        @foreach($stages as $stage)
                            <li class="list-group-item">
                                <b>{{ $stage->order }}. {{ $stage->name }}</b>
                                <ul class="text-muted small ps-3 mb-2">
                                    @forelse($stage->requirements as $req)
                                        <li>
                                            {{ $req->title }}
                                            <span class="badge bg-light text-dark">{{ ucfirst($req->type) }}</span>
                                            @if($req->is_mandatory) 
                                                <span class="badge bg-danger">Mandatory</span>
                                            @endif
                                            @if($req->requires_approval) 
                                                <span class="badge bg-warning text-dark">Approval</span>
                                            @endif
                                            @if($req->points) 
                                                <span class="badge bg-success">{{ $req->points }} pts</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li><i class="text-muted">No requirements yet.</i></li>
                                    @endforelse
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('discipleship.my_journey') }}" 
                        class="btn btn-primary w-100 rounded-pill shadow-sm">
                            <i class="ti ti-arrow-right-circle me-1"></i> {{ __('Continue') }}
                        </a>
                    </div>
                </div>
            </div>
             
        </div>
    </div>
</div>



            <!-- Pastoral Care -->
            <div class="tab-pane fade" id="care">
                <div class="row g-3">
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('Household & Family') }}</h6>
                            </div>
                            <div class="card-body">
                                @forelse($households as $household)
                                    <div class="border rounded p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $household->name }}</strong>
                                                @if($household->primaryContact && $household->primaryContact->id === $member->id)
                                                    <span class="badge bg-primary ms-1">{{ __('Primary contact') }}</span>
                                                @endif
                                                @if($household->phone)
                                                    <div class="small text-muted">{{ $household->phone }}</div>
                                                @endif
                                                @if($household->email)
                                                    <div class="small text-muted">{{ $household->email }}</div>
                                                @endif
                                            </div>
                                            <form method="POST" action="{{ route('churchly.households.members.detach', [$household->id, $member->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="ti ti-unlink"></i> {{ __('Remove') }}
                                                </button>
                                            </form>
                                        </div>
                                        @if($household->members->isNotEmpty())
                                            <div class="mt-2 small text-muted">
                                                {{ __('Members:') }}
                                                @foreach($household->members as $houseMember)
                                                    <span class="badge bg-light text-dark me-1 mb-1">
                                                        {{ $houseMember->name }}
                                                        @if($houseMember->pivot && $houseMember->pivot->relationship)
                                                            <span class="text-muted">({{ $houseMember->pivot->relationship }})</span>
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-muted">{{ __('Not yet linked to a household.') }}</p>
                                @endforelse

                                <hr class="my-3">
                                <form method="POST" action="{{ route('churchly.households.members.attach-form') }}">
                                    @csrf
                                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                                    <div class="mb-2">
                                        <label class="form-label">{{ __('Attach to an existing household') }}</label>
                                        <div class="input-group">
                                            <select class="form-select" name="household_id" required>
                                                <option value="">{{ __('Select household') }}</option>
                                                @foreach($availableHouseholds as $availableHousehold)
                                                    <option value="{{ $availableHousehold->id }}">{{ $availableHousehold->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-outline-primary" type="submit">{{ __('Attach') }}</button>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="relationship" class="form-control" placeholder="{{ __('Relationship label (optional)') }}">
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="household-primary" name="is_primary" value="1">
                                        <label class="form-check-label" for="household-primary">{{ __('Set as primary contact') }}</label>
                                    </div>
                                </form>

                                <hr class="my-3">
                                <form method="POST" action="{{ route('churchly.households.store') }}">
                                    @csrf
                                    <input type="hidden" name="primary_contact_id" value="{{ $member->id }}">
                                    <div class="mb-2">
                                        <label class="form-label">{{ __('Create new household') }}</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-6">
                                            <input type="text" name="phone" class="form-control" placeholder="{{ __('Phone') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control" placeholder="{{ __('Email') }}">
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="notes" class="form-control" rows="2" placeholder="{{ __('Notes (optional)') }}"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary btn-sm">{{ __('Save Household') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ __('Follow-up Workflow') }}</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('members.followups.store', $member->id) }}" class="row g-2 mb-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Assign to') }}</label>
                                        <select name="assigned_to" class="form-select">
                                            <option value="">{{ __('Unassigned') }}</option>
                                            @foreach($careTeamUsers as $careUser)
                                                <option value="{{ $careUser->id }}">{{ $careUser->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Due date') }}</label>
                                        <input type="date" name="due_at" class="form-control">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">{{ __('Notes') }}</label>
                                        <textarea name="description" class="form-control" rows="1" placeholder="{{ __('Context or instructions') }}"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Status') }}</label>
                                        <select name="status" class="form-select">
                                            <option value="open">{{ __('Open') }}</option>
                                            <option value="in_progress">{{ __('In progress') }}</option>
                                            <option value="completed">{{ __('Completed') }}</option>
                                            <option value="cancelled">{{ __('Cancelled') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end justify-content-end">
                                        <button class="btn btn-primary">{{ __('Create Follow-up') }}</button>
                                    </div>
                                </form>

                                <hr class="my-3">
                                @forelse($memberFollowUps as $followUp)
                                    <div class="border rounded p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <strong>{{ $followUp->subject }}</strong>
                                                <span class="badge bg-secondary ms-2 text-uppercase">{{ __($followUp->status) }}</span>
                                                @if($followUp->due_at)
                                                    <div class="small text-muted">{{ __('Due') }}: {{ $followUp->due_at->format('M d, Y') }}</div>
                                                @endif
                                                @if($followUp->assignee)
                                                    <div class="small text-muted">{{ __('Assigned to') }}: {{ $followUp->assignee->name }}</div>
                                                @endif
                                            </div>
                                            <form method="POST" action="{{ route('members.followups.destroy', [$member->id, $followUp->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </div>
                                        @if($followUp->description)
                                            <p class="small mt-2 mb-2">{{ $followUp->description }}</p>
                                        @endif
                                        <form method="POST" action="{{ route('members.followups.update', [$member->id, $followUp->id]) }}" class="row g-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="subject" value="{{ $followUp->subject }}">
                                            <input type="hidden" name="description" value="{{ $followUp->description }}">
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Status') }}</label>
                                                <select name="status" class="form-select form-select-sm">
                                                    @foreach(['open','in_progress','completed','cancelled'] as $status)
                                                        <option value="{{ $status }}" @selected($followUp->status === $status)>{{ __(ucwords(str_replace('_',' ', $status))) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Due date') }}</label>
                                                <input type="date" name="due_at" value="{{ optional($followUp->due_at)->format('Y-m-d') }}" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('Assign to') }}</label>
                                                <select name="assigned_to" class="form-select form-select-sm">
                                                    <option value="">{{ __('Unassigned') }}</option>
                                                    @foreach($careTeamUsers as $careUser)
                                                        <option value="{{ $careUser->id }}" @selected($followUp->assigned_to === $careUser->id)>{{ $careUser->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-sm btn-outline-primary">{{ __('Update') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <p class="text-muted">{{ __('No follow-ups recorded yet.') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('Pastoral Notes') }}</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('members.notes.store', $member->id) }}" class="mb-3">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="text" name="title" class="form-control" placeholder="{{ __('Title (optional)') }}">
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="body" class="form-control" rows="3" placeholder="{{ __('Add a confidential note for the pastoral team') }}" required></textarea>
                                    </div>
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Visibility') }}</label>
                                            <select name="visibility" class="form-select">
                                                <option value="staff">{{ __('Staff') }}</option>
                                                <option value="pastoral">{{ __('Pastoral team') }}</option>
                                                <option value="leaders">{{ __('Leaders') }}</option>
                                                <option value="private">{{ __('Only me') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-check mt-4">
                                            <input type="checkbox" class="form-check-input" id="requires-attention" name="requires_attention" value="1">
                                            <label class="form-check-label" for="requires-attention">{{ __('Flag for attention') }}</label>
                                        </div>
                                        <div class="col-md-2 d-flex justify-content-end mt-4">
                                            <button class="btn btn-primary">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="list-group">
                                    @forelse($memberNotes as $note)
                                        <div class="list-group-item list-group-item-action mb-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>{{ $note->title ?? __('Note') }}</strong>
                                                    <span class="badge bg-secondary ms-2 text-uppercase">{{ __($note->visibility) }}</span>
                                                    <div class="small text-muted">{{ optional($note->author)->name }} · {{ $note->created_at->diffForHumans() }}</div>
                                                </div>
                                                <form method="POST" action="{{ route('members.notes.destroy', [$member->id, $note->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                                                </form>
                                            </div>
                                            <p class="mb-0 mt-2">{{ $note->body }}</p>
                                        </div>
                                    @empty
                                        <p class="text-muted">{{ __('No notes yet.') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header">
                                <h6 class="mb-0">{{ __('Communication Log') }}</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('members.communications.store', $member->id) }}" class="row g-2 mb-3">
                                    @csrf
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Channel') }}</label>
                                        <select name="channel" class="form-select" required>
                                            <option value="email">{{ __('Email') }}</option>
                                            <option value="sms">{{ __('SMS') }}</option>
                                            <option value="call">{{ __('Call') }}</option>
                                            <option value="visit">{{ __('Visit') }}</option>
                                            <option value="other">{{ __('Other') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Date') }}</label>
                                        <input type="date" name="sent_at" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">{{ __('Subject') }}</label>
                                        <input type="text" name="subject" class="form-control" placeholder="{{ __('Subject / summary') }}">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="body" class="form-control" rows="2" placeholder="{{ __('Message summary or call notes') }}"></textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button class="btn btn-primary">{{ __('Log Communication') }}</button>
                                    </div>
                                </form>

                                <div class="list-group">
                                    @forelse($memberCommunications as $communication)
                                        <div class="list-group-item mb-2">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong class="text-uppercase">{{ __($communication->channel) }}</strong>
                                                    @if($communication->subject)
                                                        <span class="ms-2">{{ $communication->subject }}</span>
                                                    @endif
                                                    <div class="small text-muted">
                                                        {{ optional($communication->sent_at ?? $communication->created_at)->format('M d, Y H:i') }}
                                                        @if($communication->sender)
                                                            · {{ __('By') }} {{ $communication->sender->name }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($communication->body)
                                                <p class="mb-0 mt-2">{{ $communication->body }}</p>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-muted">{{ __('No communications logged yet.') }}</p>
                                    @endforelse
                                </div>

                                <hr class="my-3">
                                <h6>{{ __('Giving Snapshot') }}</h6>
                                @php
                                    $totalContributions = $memberContributions->sum('amount');
                                    $lastContribution = $memberContributions->first();
                                @endphp
                                <p class="small text-muted mb-1">
                                    {{ __('Total recorded gifts: :amount', ['amount' => number_format($totalContributions, 2)]) }}
                                </p>
                                <p class="small text-muted">
                                    {{ __('Last gift:') }}
                                    @if($lastContribution)
                                        {{ $lastContribution->received_at?->format('M d, Y') }} · {{ number_format($lastContribution->amount, 2) }} {{ $lastContribution->currency }}
                                    @else
                                        {{ __('No gifts recorded') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Smart Tags -->
            <div class="tab-pane fade" id="smart-tags">
                <div class="card shadow-sm border-0">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ __('Smart Tags Automation') }}</h6>
                        <a href="{{ route('churchly.smart-tags.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ti ti-settings"></i> {{ __('Manage Tags') }}
                        </a>
                    </div>
                    <div class="card-body">
                        @php $matchedTagIds = $member->smartTags->pluck('id')->all(); @endphp
                        <div class="mb-4">
                            <h6>{{ __('Current matches') }}</h6>
                            @forelse($member->smartTags as $tag)
                                <span class="badge bg-success me-1 mb-1">{{ $tag->name }}</span>
                            @empty
                                <p class="text-muted">{{ __('No smart tags currently match this profile.') }}</p>
                            @endforelse
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>{{ __('Tag') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Last run') }}</th>
                                        <th>{{ __('Matches') }}</th>
                                        <th class="text-end">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableSmartTags as $smartTag)
                                        <tr>
                                            <td>
                                                <strong>{{ $smartTag->name }}</strong>
                                                @if($smartTag->description)
                                                    <div class="small text-muted">{{ $smartTag->description }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $smartTag->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $smartTag->is_active ? __('Active') : __('Disabled') }}
                                                </span>
                                                @if(in_array($smartTag->id, $matchedTagIds))
                                                    <span class="badge bg-primary ms-1">{{ __('Matches this member') }}</span>
                                                @endif
                                            </td>
                                            <td class="small text-muted">
                                                {{ $smartTag->last_run_at ? $smartTag->last_run_at->diffForHumans() : __('Never') }}
                                            </td>
                                            <td>{{ $smartTag->members_count ?? $smartTag->members()->count() }}</td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('churchly.smart-tags.run', $smartTag->id) }}" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-primary" type="submit">{{ __('Run') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Fields -->
            <div class="tab-pane fade" id="custom">
                <div class="card p-3 shadow-sm border-0">
                    <h6>{{ __('Custom Information') }}</h6>
                    <div class="row">
                        @forelse($member->customValues ?? [] as $custom)
                            <div class="col-md-6 mb-2">
                                <strong>{{ ucfirst(str_replace('_',' ',$custom->field_key)) }}:</strong>
                                <span class="text-muted">{{ $custom->field_value }}</span>
                            </div>
                        @empty
                            <p class="text-muted">{{ __('No custom fields added.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    var attachForm = document.querySelector('#household-attach-form');
    if (attachForm) {
        attachForm.addEventListener('submit', function (event) {
            var select = attachForm.querySelector('select[name="household_id"]');
            if (select && !select.value) {
                event.preventDefault();
                alert('{{ __("Select a household before attaching.") }}');
            }
        });
    }
});
</script>


{{-- Donations Chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Donations Chart
    new Chart(document.getElementById('donationsChart'), {
        type: 'bar',
        data: {
            labels: @json($donationsMonths),
            datasets: [{
                label: 'Donations',
                data: @json($donationsAmounts),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
            }]
        }
    });
</script>

<!-- Family & Church Trees -->
<script src="https://d3js.org/d3.v7.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const members = @json($nodes); // From controller
    const workspaceName = @json($workspaceName);
    const currentMemberId = @json($member->id); // ✅ highlight this member

    const nodes = [];
    const links = [];

    const width = document.getElementById("church-tree").clientWidth || window.innerWidth;
    const height = window.innerHeight;


    const colorDept   = d3.scaleOrdinal(d3.schemeTableau10);
    const colorBranch = d3.scaleOrdinal(d3.schemeSet2);

    // GOD + Workspace
    nodes.push({ id: "GOD", name: "GOD", type: "god" });
    nodes.push({ id: "WORKSPACE", name: workspaceName, type: "workspace" });
    links.push({ source: "WORKSPACE", target: "GOD", type: "god" });

    const branches = {};
    const departments = {};

    // --- Add members ---
    members.forEach(m => {
        m.type = "member";
        nodes.push(m);

        if (m.department) {
            const deptKey = m.department + "-" + m.branch;
            if (!departments[deptKey]) {
                departments[deptKey] = {
                    id: "dept-" + deptKey,
                    name: m.department,
                    type: "department",
                    branch: m.branch
                };
                nodes.push(departments[deptKey]);
            }
            links.push({ source: m.id, target: departments[deptKey].id, type: "department" });
        } else if (m.branch) {
            if (!branches[m.branch]) {
                branches[m.branch] = {
                    id: "branch-" + m.branch,
                    name: m.branch,
                    type: "branch"
                };
                nodes.push(branches[m.branch]);
            }
            links.push({ source: m.id, target: branches[m.branch].id, type: "branch" });
        }
    });

    // --- Connect departments → branches
    Object.values(departments).forEach(dept => {
        if (dept.branch) {
            if (!branches[dept.branch]) {
                branches[dept.branch] = {
                    id: "branch-" + dept.branch,
                    name: dept.branch,
                    type: "branch"
                };
                nodes.push(branches[dept.branch]);
            }
            links.push({ source: dept.id, target: branches[dept.branch].id, type: "branch" });
        }
    });

    // --- Connect branches → workspace
    Object.values(branches).forEach(branch => {
        links.push({ source: branch.id, target: "WORKSPACE", type: "workspace" });
    });

    // ✅ Create SVG with zoom
    const svg = d3.select("#church-tree").append("svg")
        .attr("width", '100%')
        .attr("height", '700px')
        .call(d3.zoom().scaleExtent([0.2, 2]).on("zoom", (event) => {
            container.attr("transform", event.transform);
        }));

    const container = svg.append("g"); // ✅ zoomable group

    const simulation = d3.forceSimulation(nodes)
        .force("link", d3.forceLink(links).id(d => d.id).distance(d => {
            if (d.type === "department") return 100;
            if (d.type === "branch") return 150;
            if (d.type === "workspace") return 200;
            return 250;
        }))
        .force("charge", d3.forceManyBody().strength(-350))
        .force("center", d3.forceCenter(width / 2, height / 2));

    // ✅ Links
    const link = container.append("g")
        .attr("stroke-opacity", 0.6)
        .selectAll("line").data(links).enter().append("line")
        .attr("stroke", d => {
            if (d.type === "department") return colorDept(d.source.name);
            if (d.type === "branch") return colorBranch(d.source.name);
            if (d.type === "workspace") return "#6c757d";
            if (d.type === "god") return "#000";
            return "#999";
        })
        .attr("stroke-width", d => d.type === "god" ? 3 : 2)
        .attr("stroke-dasharray", d => d.type === "branch" ? "4,2" : "0");

    // ✅ Node groups
    const node = container.append("g")
        .selectAll("g")
        .data(nodes)
        .enter()
        .append("g")
        .call(d3.drag()
            .on("start", dragstarted)
            .on("drag", dragged)
            .on("end", dragended)
        );

    // Circle border
    node.append("circle")
        .attr("r", d => d.type === "god" ? 40 :
                       d.type === "workspace" ? 32 :
                       d.type === "branch" ? 28 :
                       d.type === "department" ? 24 : 20)
        .attr("fill", "#fff")
        .attr("stroke", d => {
            if (d.type === "god") return "#0d6efd";
            if (d.type === "workspace") return "#6c757d";
            if (d.type === "branch") return colorBranch(d.name);
            if (d.type === "department") return colorDept(d.name);
            if (d.department) return colorDept(d.department);
            if (d.branch) return colorBranch(d.branch);
            return "#999";
        })
        .attr("stroke-width", 3);

    // Profile photo (for members only)
    node.filter(d => d.type === "member").append("image")
        .attr("xlink:href", d => d.photo || null)
        .attr("x", -15).attr("y", -15)
        .attr("width", 30).attr("height", 30)
        .attr("clip-path", (d, i) => `url(#clip-${i})`);

    // Clip-paths for round images
    svg.append("defs")
        .selectAll("clipPath")
        .data(nodes)
        .enter()
        .append("clipPath")
        .attr("id", (d, i) => `clip-${i}`)
        .append("circle")
        .attr("r", 15).attr("cx", 0).attr("cy", 0);

    // ✅ Labels
    const label = container.append("g")
        .selectAll("text").data(nodes).enter().append("text")
        .text(d => d.name)
        .attr("font-size", d => d.type === "god" ? 16 :
                               d.type === "workspace" ? 14 : 11)
        .attr("font-weight", d => d.id === currentMemberId ? "bold" : "normal")
        .attr("text-anchor", d => d.id === currentMemberId ? "middle" : "start") // center only current member
        .attr("dy", d => d.id === currentMemberId ? 40 : 5) // push label under circle if current
        .attr("dx", d => d.id === currentMemberId ? 0 : 25);

    simulation.on("tick", () => {
        link.attr("x1", d => d.source.x).attr("y1", d => d.source.y)
            .attr("x2", d => d.target.x).attr("y2", d => d.target.y);
        node.attr("transform", d => `translate(${d.x},${d.y})`);
        label.attr("x", d => d.x).attr("y", d => d.y);
    });

    // ✅ Auto zoom & fit
    simulation.on("end", () => {
        const bounds = container.node().getBBox();
        const fullWidth = width, fullHeight = height;
        const dx = bounds.width, dy = bounds.height;
        const x = bounds.x + dx / 2, y = bounds.y + dy / 2;
        const scale = Math.max(0.5, Math.min(2, 0.85 / Math.max(dx / fullWidth, dy / fullHeight)));
        const translate = [fullWidth / 2 - scale * x, fullHeight / 2 - scale * y];

        svg.transition().duration(750).call(
            d3.zoom().transform,
            d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale)
        );
    });

    // ✅ Drag Handlers
    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x; d.fy = d.y;
    }
    function dragged(event, d) { d.fx = event.x; d.fy = event.y; }
    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null; d.fy = null;
    }
});
</script>

@endpush

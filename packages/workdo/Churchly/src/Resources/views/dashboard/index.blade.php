@extends('layouts.main')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@push('css')
<style>
    .church-dashboard .dashboard-card,
    .church-dashboard .dashboard-project-card,
    .church-dashboard .card,
    .church-dashboard .dashboard-wrp > a.card {
        border: 1px solid #d8e2ef !important;
        box-shadow: none !important;
    }

    .church-dashboard .card-header {
        border-bottom: 1px solid #d8e2ef !important;
        background: #ffffff;
    }

    .church-dashboard .card-footer {
        border-top: 1px solid #d8e2ef !important;
        background: #ffffff;
    }

    .church-dashboard .input-group .form-control,
    .church-dashboard .input-group .btn,
    .church-dashboard .theme-avtar,
    .church-dashboard .badge {
        border: 1px solid #d8e2ef !important;
    }

    .church-dashboard .qr-card img {
        border: 1px solid rgba(255, 255, 255, 0.45);
        border-radius: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('click', function (event) {
    const button = event.target.closest('.copy-link');
    if (!button) {
        return;
    }

    const link = button.dataset.link || button.closest('.input-group')?.querySelector('input')?.value;
    if (!link) {
        return;
    }

    navigator.clipboard.writeText(link).then(() => {
        const original = button.innerHTML;
        button.innerHTML = '<i class="ti ti-check"></i>';
        setTimeout(() => {
            button.innerHTML = original;
        }, 1400);
    }).catch(() => {
        const original = button.innerHTML;
        button.innerHTML = '<i class="ti ti-alert-circle text-warning"></i>';
        setTimeout(() => {
            button.innerHTML = original;
        }, 1400);
    });
});
</script>
@endpush

@section('page-breadcrumb')
    {{ __('Church') }}
@endsection



@section('content')

    @php
        $activeWorkspace = \App\Models\WorkSpace::find(getActiveWorkSpace());
        $workspaceKey = $activeWorkspace?->slug ?: getActiveWorkSpace();
        $feedbackFormUrl = $workspaceKey ? route('churchly.feedback.form', ['workspace' => $workspaceKey]) : '#';
        $feedbackSubmitUrl = $workspaceKey ? route('churchly.feedback.submit', ['workspace' => $workspaceKey]) : '#';
        $selfServiceUrl = $workspaceKey ? route('churchly.self.register', ['workspace' => $workspaceKey]) : '#';
    @endphp

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    

<div class="row row-gap mb-4 church-dashboard">
    <!-- LEFT SECTION (Main Dashboard) -->
    <div class="col-xl-9 col-12">
        <div class="row row-gap mb-4">
            <!-- Verse of the Day -->
            <div class="col-xl-8 col-12">
                <div class="dashboard-card">
                    <img src="{{ asset('assets/images/layer.png') }}" class="dashboard-card-layer" alt="layer">
                    <div class="card-inner">
                        <div class="card-content">
                            <!--<h2>{{ Auth::user()->ActiveWorkspaceName() }} VERSE OF THE DAY</h2>-->
                            <h2>VERSE OF THE DAY</h2>
                            @if(!empty($verseOfDay))
                                
                                <p class="mb-2 ">“{{ $verseOfDay['text'] }}”</p>
                                <p class="fw-semibold text-muted">{{ $verseOfDay['reference'] }} ({{ $verseOfDay['version'] }})</p>
                            @else
                                <p>{{ __('Manage your church with ease through organized member directories, automated reminders, and real-time service analytics.') }}</p>
                            @endif
                        </div>
                        <div class="card-icon d-flex align-items-center justify-content-center">
                            <!-- SVG ICON -->
                            <!-- (SVG content remains unchanged for readability) -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR CODE CARD -->
            <div class="col-xl-4 col-12">
                <div class="card p-3 bg-primary text-center">
                    @php
                        $member = \Workdo\Churchly\Entities\ChurchMember::where('user_id', Auth::id())->first();
                    @endphp
                    <div style="padding-left: 0px;important;" class="qr-card">
                        <h5 class="mb-3 fw-bold text-white">{{ __('Attendance QR Code') }}</h5>
                        @if($member && $member->qr_code)
                            <img src="{{ asset('storage/' . $member->qr_code) }}" height = "150px" alt="QR Code">
                            <p class="mt-2 text-white"><small>{{ __('Scan this at service entry for attendance tracking.') }}</small></p>
                            <a href="{{ asset('storage/' . $member->qr_code) }}" 
                                target="_blank" 
                                class="btn btn-warning btn-lg w-500 mt-3 d-flex align-items-center justify-content-center gap-2 shadow">
                                    <i class="ti ti-download fs-4"></i>
                                    <span class="fw-bold text-dark">{{ __('QR Code') }}</span>
                            </a>

                        @elseif($member)
                            <form action="{{ route('churchly.members.generate_qr', $member->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="ti ti-qrcode"></i> {{ __('Generate QR Code') }}
                                </button>
                            </form>
                        @else
                            <p class="text-white mb-0">{{ __('No linked member account found.  You are not a member of any church.') }}</p><br><br>
                            <button  class="btn btn-light">
                                    <i class="ti ti-phone"></i> {{ _('Contact your administrator.') }}
                                </button>
                        @endif
                    </div>
                </div>
           
            </div>
            <!-- Mini Cards -->
        </div>
    </div>

<!-- RIGHT SECTION (Learning Sidebar) -->
        <div class="col-xl-3 col-12">
        
            <div class="dashboard-wrp mb-4">                
                <a id="trial-getting-started" target="_blank" href="#" class="text-primary card mb-3 px-3 py-2 d-flex flex-row align-items-center no-underline shadow-sm">
					<div class="rounded bg-dark-primary mr-3 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
						<i class="fas fa-star white fa-lg"></i>		
					</div>
					<div class="flex-grow-1" data-lang="learn_churchtrac">
						<b>Getting Started</b><br>
						Learn how {{ config('app.name') }} works
					</div>
					<i class="fas fa-arrow-right float-right pt-1"></i>
				</a>
            
                <a id="trial-getting-started" target="_blank" href="#" class="text-primary card mb-3 px-3 py-2 d-flex flex-row align-items-center no-underline shadow-sm">
					<div class="rounded bg-dark-primary mr-3 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
						<i class="fas fa-users white fa-lg"></i>		
					</div>
					<div class="flex-grow-1" data-lang="learn_churchtrac">
						<b>Import or Add Your Members</b><br>
						Quickly build your people database
					</div>
					<i class="fas fa-arrow-right float-right pt-1"></i>
				</a>
                

                <a id="trial-getting-started" target="_blank" href="#" class="text-primary card mb-3 px-3 py-2 d-flex flex-row align-items-center no-underline shadow-sm">
					<div class="rounded bg-dark-primary mr-3 d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
						<i class="ti ti-settings white fa-lg"></i>		
					</div>
					<div class="flex-grow-1" data-lang="learn_churchtrac">
						<b>Configure Admin Settings</b><br>
						Set up global options and settings
					</div>
					<i class="fas fa-arrow-right float-right pt-1"></i>
				</a>
                	
                

                
		    </div>						
		</div>
			
						

        <div class="col-xl-6 col-12">
                <div class="row dashboard-wrp">
                    @php
                        $items = [
                            ['label' => 'Total Member', 'icon' => 'fas fa-users', 'count' => $stats['members'], 'color' => 'text-primary'],
                            ['label' => ' New Members', 'icon' => 'ti ti-user-plus', 'count' => $stats['weekly_new'], 'color' => 'text-success'],
                            ['label' => 'Workers', 'icon' => 'ti ti-briefcase', 'count' => $stats['workers'], 'color' => 'text-warning'],
                            ['label' => 'Leaders', 'icon' => 'ti ti-crown', 'count' => $stats['leaders'], 'color' => 'text-danger'],
                        ];
                    @endphp

                        @foreach ($items as $item)
                        <div class="col-sm-4 col-12">
                            <div class="dashboard-project-card">
                                <div class="card-inner d-flex justify-content-between">
                                    <div class="card-content">
                                        <div class="theme-avtar bg-white">
                                            <i class="{{ $item['icon'] }} {{ $item['color'] ?? '' }}"></i>
                                        </div>
                                        <a href="#">
                                            <h3 class="mt-3 mb-0 {{ $item['color'] ?? '' }}">{{ __($item['label']) }}</h3>
                                        </a>
                                    </div>
                                    <h3 class="mb-3">{{ $item['count'] }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-sm-4 col-12">
                        <div class="dashboard-project-card">
                            <div class="card-inner d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <a href="#">
                                        <h3 class="mt-3 mb-0 text-primary">Total Branches</h3>
                                    </a>
                                </div>
                                <h3 class="mb-3">{{ $stats['members'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="dashboard-project-card bg-primary">
                            <div class="card-inner d-flex justify-content-between">
                                <div class="card-content">
                                    
                                    <a href="#">
                                        <h6 class="px-3 mt-3 mb-3 text-white">Thank You for using {{ config('app.name') }}</h3>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            


        <!-- Tasks & Project Chart -->
        <div class="col-xxl-6">
            <!-- Tasks Overview -->
           <div class="row mb-4">
    
            <div class="card p-3 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="mb-0">{{ __('Shareable Links') }}</h6>
                        <small class="text-muted">{{ __('Give staff quick access to the feedback form and member signup page.') }}</small>
                    </div>
                    <span class="badge bg-soft-primary text-primary">{{ __('Copy to clipboard') }}</span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Public feedback form') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly value="{{ $feedbackFormUrl }}">
                            <button class="btn btn-outline-secondary copy-link" type="button" data-link="{{ $feedbackFormUrl }}">
                                <i class="ti ti-clipboard"></i>
                            </button>
                        </div>
                        <small class="text-muted">{{ __('Share this URL so anyone can leave praise or concerns anonymously.') }}</small>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Self-service member signup') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly value="{{ $selfServiceUrl }}">
                            <button class="btn btn-outline-secondary copy-link" type="button" data-link="{{ $selfServiceUrl }}">
                                <i class="ti ti-clipboard"></i>
                            </button>
                        </div>
                        <small class="text-muted">{{ __('Invite volunteers to register themselves quickly.') }}</small>
                    </div>
                </div>
            </div>
        </div>
 

            <!-- Project Status -->
            <div class="card">
                <div class="card-header">
                    <div class="float-end">
                        <a href="#" data-bs-toggle="tooltip" title="Referrals">
                            <i class=""></i>
                        </a>
                    </div>
                    <h5>{{ __('Comıng Soon') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <div id="projects-chart"></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="f-10 lh-1 fas fa-circle text-danger"></i>
                                <span class="ms-2 text-sm">{{ __('On Going') }}</span>
                            </div>
                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="f-10 lh-1 fas fa-circle text-warning"></i>
                                <span class="ms-2 text-sm">{{ __('On Hold') }}</span>
                            </div>
                            <div class="col-6 mb-2 d-flex align-items-center">
                                <i class="f-10 lh-1 fas fa-circle text-primary"></i>
                                <span class="ms-2 text-sm">{{ __('Finished') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <div class="col-xxl-12">
            <!-- Tasks Overview -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>{{ __('Comming Soon Overview') }}</h5>
                </div>
                <div class="card-body p-2">
                    <div id="task-area-chart">
                        ...
                    </div>
                </div>
            </div>

            
        </div>

@endsection

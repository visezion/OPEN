@extends('layouts.main')

@section('page-title')
    {{ __('Feedback Analytics Dashboard') }}
@endsection

@section('page-breadcrumb')
    {{ __('Dashboard') }}
@endsection
@push('css')
    {{-- Chart.js --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
@endpush


@section('page-action')
    <a href="{{ route('feedback.index') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-eye"></i> View All Feedback
    </a>
    <a href="{{ route('feedback.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> 
        </a>
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

        <div class="row row-gap mb-4">
            <!-- Church Overview Card -->
            <div class="col-xl-6 col-12">
                <div class="dashboard-card">
                    <img src="{{ asset('assets/images/layer.png') }}" class="dashboard-card-layer" alt="layer">
                    <div class="card-inner">
                        <div class="card-content">
                            <h2>{{ Auth::user()->ActiveWorkspaceName() }}</h2>
                                <p>{{ __('Manage your church Feedback and Workers Report with ease through organized feedback, automated reminders, and real-time service analytics.') }}</p>
                            <div class="btn-wrp d-flex gap-3">
                                <a href="{{ route('feedback.create') }}" class="btn btn-primary d-flex align-items-center gap-1 cp_link" tabindex="0" data-link="{{ route('feedback.create') }}" data-bs-whatever="Copy Link" data-bs-toggle="tooltip" data-bs-original-title="" title="">
                                    <i class="ti ti-link text-white"></i>
                                <span>Create Feedback</span></a>
                                <!-- <a href="javascript:" class="btn btn-primary" tabindex="0">
                                    <i class="ti ti-share text-white"></i>
                                </a> -->
                            </div>
                        </div>
                        <div class="card-icon  d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="63" height="70" viewBox="0 0 63 70" fill="none">
                                <path opacity="0.6" d="M43.3204 60.5504L35.571 68.311C33.3217 70.5635 29.6749 70.5635 27.4294 68.311L19.68 60.5504C17.6533 58.5209 14.4442 58.2942 12.1527 60.0162L6.93626 63.933C4.40676 65.8318 0.794922 64.0252 0.794922 60.858V9.95489C0.794922 6.78762 4.40676 4.9811 6.93626 6.87992L12.1527 10.7967C14.4442 12.5187 17.6533 12.292 19.68 10.2625L27.4294 2.50184C29.6787 0.249388 33.3256 0.249388 35.571 2.50184L43.3204 10.2625C45.3471 12.292 48.5562 12.5187 50.8478 10.7967L56.0642 6.87992C58.5937 4.9811 62.2055 6.78762 62.2055 9.95489V60.858C62.2055 64.0252 58.5937 65.8318 56.0642 63.933L50.8478 60.0162C48.5562 58.2942 45.3471 58.5209 43.3204 60.5504Z" fill="#18BF6B"></path>
                                <path d="M46.8516 30.6055H27.6596C26.0705 30.6055 24.7808 29.314 24.7808 27.7227C24.7808 26.1314 26.0705 24.8398 27.6596 24.8398H46.8516C48.4407 24.8398 49.7304 26.1314 49.7304 27.7227C49.7304 29.314 48.4407 30.6055 46.8516 30.6055ZM49.7304 43.0977C49.7304 41.5064 48.4407 40.2149 46.8516 40.2149H27.6596C26.0705 40.2149 24.7808 41.5064 24.7808 43.0977C24.7808 44.6891 26.0705 45.9806 27.6596 45.9806H46.8516C48.4407 45.9806 49.7304 44.6891 49.7304 43.0977ZM16.1444 24.8398C14.5553 24.8398 13.2656 26.1314 13.2656 27.7227C13.2656 29.314 14.5553 30.6055 16.1444 30.6055C17.7335 30.6055 19.0232 29.314 19.0232 27.7227C19.0232 26.1314 17.7335 24.8398 16.1444 24.8398ZM16.1444 40.2149C14.5553 40.2149 13.2656 41.5064 13.2656 43.0977C13.2656 44.6891 14.5553 45.9806 16.1444 45.9806C17.7335 45.9806 19.0232 44.6891 19.0232 43.0977C19.0232 41.5064 17.7335 40.2149 16.1444 40.2149Z" fill="#18BF6B"></path>
                            </svg>
                        </div>
                    </div>
                </div>    
            </div>
            

        <!-- Mini Cards -->
        <!-- Feedback Mini Cards -->
        <div class="col-xl-6 col-12">
            <div class="row dashboard-wrp">
     
                @php
                
                    $feedbackStats = [
                      
                        ['label' => 'Pending Reviews', 'icon' => 'ti ti-clock', 'count' => $statswithcount['pending'] ?? 0, 'color' => 'text-danger'],
                        ['label' => 'Resolved', 'icon' => 'ti ti-check', 'count' => $statswithcount['resolved'] ?? 0, 'color' => 'text-success'],
                        ['label' => 'Reviewed', 'icon' => 'ti ti-eye-check', 'count' => $statswithcount['reviewed'] ?? 0, 'color' => 'text-warning'],
                        ['label' => 'Total Feedbacks', 'icon' => 'ti ti-message-dots', 'count' => $statswithcount['total'] ?? 0, 'color' => 'text-primary'],
                        
                    ];
                @endphp

                @foreach ($feedbackStats as $stat)
                    <div class="col-sm-6 col-12 mb-3">
                        <div class="dashboard-project-card">
                            <div class="card-inner  d-flex justify-content-between">
                                <div class="card-content">
                                    <div class="theme-avtar bg-white">
                                        <i class="{{ $stat['icon'] }} {{ $stat['color'] }}"></i>
                                    </div>
                                    <a href="#">
                                        <h6 class="mt-3 mb-0 {{ $stat['color'] }}">{{ __($stat['label']) }}</h6>
                                    </a>
                                </div>
                                <h3 class="mb-0">{{ $stat['count'] }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
               
            </div>
            </div>
        </div>
         
        
        <div class="row">
            <div class="col-xxl-6 col-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Recent Feedback</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentFeedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->title }}</td>
                                    <td>{{ ucfirst($feedback->type) }}</td>
                                    <td>{{ ucfirst($feedback->category) }}</td>
                                    <td><span class="badge bg-{{ $feedback->status == 'resolved' ? 'success' : ($feedback->status == 'reviewed' ? 'warning' : 'secondary') }}">{{ ucfirst($feedback->status) }}</span></td>
                                    <td>{{ $feedback->created_at->diffForHumans() }} </td>
                                    <td>
                                        <a href="{{ route('feedback.show', \Illuminate\Support\Facades\Crypt::encrypt( $feedback->id)) }}" class="btn btn-sm btn-info">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>   
            </div> 

            <div class="col-xxl-3 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5>Feedback Category Chart</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="feedbackCategoryChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-12">
                <div class="card h-100">
                    <div class="card-header">
                        <h5>Feedback Type Chart</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="feedbackTypeChart" height="10"></canvas>
                    </div>
                </div>
            </div>
        </div>
@endsection


@push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('feedback-calendar');

            if (calendarEl) {
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: {!! json_encode($feedbackEvents) !!}, // from controller
                    eventClick: function (info) {
                        if (info.event.url) {
                            window.open(info.event.url, '_blank');
                            info.jsEvent.preventDefault();
                        }
                    }
                });

                calendar.render();
            }
        });
    </script>
    <script>
        // FeedbackTypeChart
        const ctxType = document.getElementById('feedbackTypeChart');
        if (ctxType) {
            new Chart(ctxType, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($stats)) !!},
                    datasets: [{
                        label: 'Feedback Types',
                        data: {!! json_encode(array_values($stats)) !!},
                        backgroundColor: ['#dc3545', '#ffc107', '#198754', '#0d6efd']
                    }]
                }
            });
        }

        // FeedbackCategoryChart
        const ctxCat = document.getElementById('feedbackCategoryChart');
        if (ctxCat) {
            new Chart(ctxCat, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($categoryCounts)) !!},
                    datasets: [{
                        label: 'Category',
                        data: {!! json_encode(array_values($categoryCounts)) !!},
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    indexAxis: 'y'
                }
            });
        }

    </script>
@endpush


@extends('layouts.main')

@section('page-title', __('Attendance Analytics Dashboard'))

@section('content')
<div class="row">


@if($member->qr_code)
    <div class="text-center">
        <img src="{{ asset('storage/' . $member->qr_code) }}" 
             alt="QR Code for {{ $member->name }}" 
             class="img-fluid rounded shadow-sm" style="max-width:200px;">
        <p class="small text-muted mt-2">{{ __('Scan this code to check in') }}</p>
    </div>
@else
    <form method="POST" action="{{ route('churchly.members.generate_qr', $member->id) }}">
        @csrf
        <button class="btn btn-outline-primary btn-sm">
            <i class="ti ti-qrcode"></i> {{ __('Generate QR Code') }}
        </button>
    </form>
@endif


    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h6>{{ __('Attendance Trend') }}</h6>
            <canvas id="trendChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 shadow-sm">
            <h6>{{ __('Absentee Alerts (Last 3 Weeks)') }}</h6>
            <ul>
                @foreach($absentees->where('recent_absences','>=',3) as $m)
                    <li>{{ $m->name }} - {{ $m->recent_absences }} absences</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('trendChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($trend->pluck('day')) !!},
            datasets: [{
                label: 'Attendance',
                data: {!! json_encode($trend->pluck('total')) !!},
                borderColor: 'blue',
                fill: false
            }]
        }
    });
</script>
@endpush

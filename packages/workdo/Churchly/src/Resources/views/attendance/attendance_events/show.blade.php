@extends('layouts.main')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('page-title', $attendanceEvent->event->title . ' - ' . __('Attendance'))

@section('page-action')
    <a href="{{ route('churchly.attendance_events.index') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-eye"></i> {{ __('View All Attendance Events') }}
    </a>
@endsection

@section('content')
<div class="col-md-12">
    <div class="row">
        {{-- ===========================
            Parse Enabled Methods Safely
        ============================ --}}
        @php
            $methods = is_array($attendanceEvent->enabled_methods)
                ? $attendanceEvent->enabled_methods
                : (json_decode($attendanceEvent->enabled_methods ?? '[]', true) ?? []);
      
            $hasManual = in_array('manual', $methods);
            $hasQr = in_array('qr', $methods);
        @endphp

        {{-- ===========================
            EVENT DETAILS CARD
        ============================ --}}
       

        <div class="@if($hasManual && $hasQr) col-md-4 @elseif($hasManual || $hasQr)  col-md-8 @else col-md-12 @endif">
            <div class="card shadow-sm p-4 mb-4">
                <h5 class="fw-bold">{{ $attendanceEvent->event->title }}</h5>
                <p class="text-muted">{{ $attendanceEvent->event->description }}</p>

                <div class="mb-3">
                    <strong>{{ __('Date:') }}</strong> {{ $attendanceEvent->event->date }} <br>
                    <strong>{{ __('Mode:') }}</strong> {{ ucfirst($attendanceEvent->mode) }} <br>
                    <strong>{{ __('Methods Enabled:') }}</strong> {{ implode(', ', $methods) }}
                </div>

                {{-- Online Meeting Info --}}
                @if($attendanceEvent->mode !== 'onsite')
                    <div class="mb-3">
                        <strong>{{ __('Online Platform:') }}</strong> {{ ucfirst($attendanceEvent->online_platform ?? '-') }} <br>
                        @if($attendanceEvent->meeting_link)
                            <a href="{{ $attendanceEvent->meeting_link }}" 
                               target="_blank" 
                               class="btn btn-sm btn-primary mt-2">
                                {{ __('Join Online Event') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- ===========================
            MANUAL ATTENDANCE METHOD
        ============================ --}}
        @if(in_array('manual', $methods))
        <div class="col-md-4">
            <div class="card p-3 mb-4 shadow-sm">
                <h6 class="fw-bold">{{ __('Manual Attendance Marking') }}</h6>
                <p class="text-muted small mb-3">
                    {{ __('Search for a member by name, phone number, or member ID. 
                    Select the correct person, then click “Mark Present” to confirm attendance.') }}
                </p>

                <form action="{{ route('churchly.attendance.manualCheckIn', $attendanceEvent->id) }}" 
                      method="POST" class="row g-3 mt-4">
                    @csrf
                    <div class="col-md-7">
                        <select id="member-search" name="member_id" class="form-control" required></select>
                    </div>
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-check"></i> {{ __('Mark Present') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- ===========================
            QR CODE SCANNER METHOD
        ============================ --}}
        @if(in_array('qr', $methods))
        <div class="col-md-4">
            <div class="card p-3 mb-4 shadow-sm">
                <h6 class="fw-bold">{{ __('QR Code Attendance Scanner') }}</h6>
                <p class="text-muted small mb-3">
                    {{ __('Scan a member’s unique QR code to mark attendance instantly. 
                    Works online and offline, syncing automatically once reconnected.') }}
                </p>

                <div class="text-center mt-5">
                    <a href="{{ route('churchly.attendance_events.scan', $attendanceEvent->id) }}"
                       class="btn btn-success d-flex align-items-center justify-content-center gap-2 shadow-sm w-100"
                       title="{{ __('Open QR Scanner') }}">
                        <i class="ti ti-qrcode fs-4"></i>
                        <span class="fw-semibold">{{ __('Launch QR Scanner') }}</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===========================
        ATTENDANCE RECORDS TABLE
    ============================ --}}
    <div class="card p-3 mb-4 shadow-sm">
        <h6 class="fw-bold mt-2">{{ __('Attendance Records') }}</h6>

        <table class="table table-bordered align-middle mt-3">
            <thead class="table-light">
                <tr>
                    <th>{{ __('Member') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Check-In Time') }}</th>
                    <th>{{ __('Device Used') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendanceEvent->records as $record)
                    <tr>
                        <td>{{ $record->member->name ?? __('Visitor') }}</td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($record->status) }}</span>
                        </td>
                        <td>{{ $record->check_in_time ?? '-' }}</td>
                        <td>{{ strtoupper($record->device_used) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            {{ __('No attendance records available yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    $('#member-search').select2({
        placeholder: "{{ __('Search Member by Name, Phone, or ID') }}",
        minimumInputLength: 1,
        ajax: {
            url: "{{ route('churchly.attendance.searchMember') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { q: params.term };
            },
            processResults: function (data) {
                return {
                    results: data.map(function (member) {
                        return { 
                            id: member.id, 
                            text: member.name + ' (' + member.phone + ' | ID:' + member.id + ')' 
                        };
                    })
                };
            }
        }
    });
});
</script>
@endpush

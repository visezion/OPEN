@extends('layouts.main')

@section('page-title', __('Attendance Events'))

@section('page-action')
    <a href="{{ route('churchly.attendance_events.create') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> {{ __('New Attendance Event') }}
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Main Content --}}
    <div class="col-lg-9">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">{{ __('Attendance Events Management') }}</h5>
                    <small class="text-muted">{{ __('Track and monitor attendance records for all church gatherings and programs.') }}</small>
                </div>
                
            </div>

            {{-- Summary Cards --}}
            <div class="card-body pb-0">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-calendar text-primary fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6">{{ $attendanceEvents->total() }}</div>
                                <div class="text-muted small">{{ __('Total Events') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-wifi text-info fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6">{{ $attendanceEvents->where('mode', 'online')->count() }}</div>
                                <div class="text-muted small">{{ __('Online') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm bg-light-subtle text-center py-2">
                            <div class="card-body p-2">
                                <i class="ti ti-building-church text-success fs-4 mb-1 d-block"></i>
                                <div class="fw-bold fs-6">{{ $attendanceEvents->where('mode', 'onsite')->count() }}</div>
                                <div class="text-muted small">{{ __('Onsite') }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            

            {{-- Attendance Table --}}
            <div class="card-body pt-0">
                @if($attendanceEvents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Event Name') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Mode') }}</th>
                                    <th>{{ __('Methods Enabled') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceEvents as $attendanceEvent)
                                    <tr>
                                        <td>
                                            @if($attendanceEvent->event)
                                                <a href="{{ route('churchly.events.show', $attendanceEvent->event_id) }}" 
                                                class="fw-semibold text-primary text-decoration-none">
                                                    {{ $attendanceEvent->event->title ?? __('N/A') }}
                                                </a>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $attendanceEvent->event->description 
                                                        ? Str::limit($attendanceEvent->event->description, 60) 
                                                        : __('No description provided') }}
                                                </small>
                                            @else
                                                <span class="text-muted">{{ __('Event not found') }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $attendanceEvent->event && $attendanceEvent->event->date 
                                                ? \Carbon\Carbon::parse($attendanceEvent->event->date)->format('M d, Y') 
                                                : __('-') }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $attendanceEvent->mode == 'online' ? 'info' : ($attendanceEvent->mode == 'hybrid' ? 'warning' : 'success') }}">
                                                <i class="ti {{ $attendanceEvent->mode == 'online' ? 'ti-wifi' : ($attendanceEvent->mode == 'hybrid' ? 'ti-device-laptop' : 'ti-building-church') }}"></i>
                                                {{ ucfirst($attendanceEvent->mode) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if(!empty($attendanceEvent->enabled_methods))
                                                @foreach($attendanceEvent->enabled_methods as $method)
                                                    <span class="badge bg-secondary me-1">
                                                        <i class="ti ti-check"></i> {{ ucfirst($method) }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">{{ __('No methods enabled') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('churchly.attendance_events.show', $attendanceEvent->id) }}" 
                                                class="btn btn-sm btn-outline-primary" 
                                                title="{{ __('View Attendance Details') }}">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <a href="{{ route('churchly.attendance_events.edit', $attendanceEvent->id) }}" 
                                                class="btn btn-sm btn-outline-secondary" 
                                                title="{{ __('Edit Attendance Event') }}">
                                                    <i class="ti ti-pencil"></i>
                                                </a>
                                                <form action="{{ route('churchly.attendance_events.destroy', $attendanceEvent->id) }}" 
                                                    method="POST" 
                                                    onsubmit="return confirm('{{ __('Are you sure you want to delete this attendance event?') }}');" 
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="{{ __('Delete Event') }}">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $attendanceEvents->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-user-check text-muted" style="font-size: 48px;"></i>
                        <h6 class="mt-3 fw-semibold">{{ __('No Attendance Events Found') }}</h6>
                        <p class="text-muted">{{ __('Start by creating a new attendance event to track members effectively.') }}</p>
                        <a href="{{ route('churchly.attendance_events.create') }}" class="btn btn-primary mt-2">
                            <i class="ti ti-plus"></i> {{ __('Create First Attendance Event') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Sidebar --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        {{-- Instruction Tips --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> {{ __('Attendance Tips & Guidance') }}</h6>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>mode</strong> (Online / Onsite / Hybrid) to manage event attendance effectively.</li>
                    <li>Enable suitable <strong>methods</strong> (QR code, manual entry, or ID scan) for tracking.</li>
                    <li>Click <strong>View</strong> to see who attended and their check-in times.</li>
                    <li>Attendance data is automatically synced with the member list.</li>
                    <li>Archived events can be accessed anytime for reports and analytics.</li>
                </ul>
            </div>
        </div>

        {{-- Notifications --}}
        
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="ti ti-bell"></i> {{ __('Recent Attendance Updates') }}</h6>
                <a href="{{ route('churchly.attendance_events.index') }}" class="small text-muted">{{ __('View All') }}</a>
            </div>
            <div class="card-body small">
                @forelse($recentAttendance as $att)
                    <div class="alert alert-{{ $att->mode == 'online' ? 'info' : ($att->mode == 'hybrid' ? 'warning' : 'success') }} py-2 mb-2">
                        <i class="ti ti-calendar-event"></i> 
                        <strong>{{ $att->event->title ?? 'Unnamed Event' }}</strong><br>
                        <span class="text-muted">
                            {{ __('Created on') }} {{ $att->created_at->format('M d, Y h:i A') }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">
                        <i class="ti ti-bell-off fs-3"></i>
                        <p class="mt-2 mb-0">{{ __('No recent updates available.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

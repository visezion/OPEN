@extends('layouts.main')

@section('page-title', __('Church Events'))

@section('page-action')
    <a href="{{ route('churchly.events.create') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> {{ __('Add New Event') }}
    </a>
@endsection

@section('content')
<div class="row">
    {{-- Main Content --}}
    <div class="col-lg-9">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                <div>
                    <h5 class="mb-0 fw-bold">{{ __('Upcoming & Past Events') }}</h5>
                    <small class="text-muted">{{ __('View, manage, and organize all your church events in one place.') }}</small>
                </div>
                
            </div>

            <div class="card-body">
                {{-- Filter and Search Bar --}}
                <form method="GET" class="row g-2 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('Search by title or description...') }}" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="event_type" class="form-select form-select-sm">
                            <option value="">{{ __('All Types') }}</option>
                            <option value="worship" {{ request('event_type') == 'worship' ? 'selected' : '' }}>{{ __('Worship') }}</option>
                            <option value="meeting" {{ request('event_type') == 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                            <option value="training" {{ request('event_type') == 'training' ? 'selected' : '' }}>{{ __('Training') }}</option>
                            <option value="outreach" {{ request('event_type') == 'outreach' ? 'selected' : '' }}>{{ __('Outreach') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="ti ti-search"></i> {{ __('Filter') }}
                        </button>
                    </div>
                </form>

                {{-- Events Table --}}
                @if($events->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Time') }}</th>
                                    <th>{{ __('Type') }}</th>
                                     <th class="text-center">{{ __('Status') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $event)
                                <tr>
                                    <td>
                                        <a href="{{ route('churchly.events.show', $event->id) }}" class="fw-semibold text-primary">
                                            {{ $event->title }}
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($event->description, 60) }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                    <td> {{ $event->start_time ? date('h:i A', strtotime($event->start_time)) : '—' }} -  {{ $event->end_time ? date('h:i A', strtotime($event->end_time)) : '—' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $event->event_type == 'worship' ? 'info' : ($event->event_type == 'meeting' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($event->event_type) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ \Carbon\Carbon::parse($event->date)->isFuture() ? 'bg-success' : 'bg-secondary' }}">
                                            {{ \Carbon\Carbon::parse($event->date)->isFuture() ? __('Upcoming') : __('Completed') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('churchly.events.approve', $event->id) }}" class="btn btn-sm btn-outline-success" title="{{ __('View Approval') }}">
                                                <i class="ti ti-checks"></i>
                                            </a>     
                                            <a href="{{ route('churchly.events.review', $event->id) }}" class="btn btn-sm btn-outline-warning" title="{{ __('View Preview') }}">
                                                <i class="ti ti-check"></i>
                                            </a>    
                                            <a href="{{ route('churchly.events.show', $event->id) }}" class="btn btn-sm btn-outline-primary" title="{{ __('View Details') }}">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('churchly.events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary" title="{{ __('Edit Event') }}">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('churchly.events.destroy', $event->id) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('{{ __('Are you sure you want to delete this event?') }}');" 
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
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-calendar-event text-muted" style="font-size: 48px;"></i>
                        <h6 class="mt-3">{{ __('No events found') }}</h6>
                        <p class="text-muted">{{ __('Start by creating your first event to manage your church activities effectively.') }}</p>
                        <a href="{{ route('churchly.events.create') }}" class="btn btn-primary mt-2">
                            <i class="ti ti-plus"></i> {{ __('Create Your First Event') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right Sidebar: Tips and Notifications --}}
    <div class="col-lg-3 mt-4 mt-lg-0">
        {{-- Instruction Tips --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header  text-white py-2">
                <h5 class="mb-0"><i class="ti ti-bulb"></i> {{ __('Instruction & Tips') }}</h6>
            </div>
            <div class="card-body small text-muted">
                <ul class="ps-3 mb-0">
                    <li>Use the <strong>Filter</strong> bar to quickly find specific events by type or date.</li>
                    <li>Click <strong>“View”</strong> to open full event details including description and participants.</li>
                    <li>Use <strong>“Edit”</strong> to update the event’s date, time, or venue.</li>
                    <li>Only delete an event if it’s canceled — this action cannot be undone.</li>
                    <li>Completed or past events are automatically archived in the database.</li>
                </ul>
            </div>
        </div>

       {{-- Notifications --}}
           

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">
                        <i class="ti ti-bell"></i> {{ __('Recent Notifications') }}
                    </h6>
                    <a href="{{ route('churchly.events.index') }}" class="text-muted small">{{ __('View All') }}</a>
                </div>

                <div class="card-body small">
                    @forelse($recentEvents as $event)
                        <div class="alert alert-{{ 
                            $event->event_type == 'worship' ? 'info' : 
                            ($event->event_type == 'meeting' ? 'warning' : 
                            ($event->event_type == 'outreach' ? 'success' : 'secondary')) 
                        }} mb-2 py-2">
                            <i class="ti ti-calendar-event"></i>
                            <strong>{{ $event->title }}</strong>
                            <br>
                            <span class="text-muted">
                                {{ __('Scheduled for') }} {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                                @if($event->time)
                                    {{ __('at') }} {{ \Carbon\Carbon::parse($event->time)->format('h:i A') }}
                                @endif
                            </span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3">
                            <i class="ti ti-bell-off" style="font-size: 28px;"></i>
                            <p class="mt-2 mb-0">{{ __('No recent event notifications yet.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

    </div>
</div>
@endsection

@extends('layouts.main')

@section('page-title', __('Maintenance schedules – Print'))
@section('page-breadcrumb', __('Maintenance'))
@section('page-action')
    <a href="{{ route('maintenance.index') }}" class="btn btn-outline-secondary btn-sm">
        {{ __('Back to list') }}
    </a>
    <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.print();">
        {{ __('Print now') }}
    </button>
@endsection

@section('content')
    @php
        $filters = $filters ?? [];
    @endphp
    <div class="card print-card">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ __('Printable maintenance report') }}</h5>
            <div class="mb-4">
                <strong class="d-block mb-2">{{ __('Active filters') }}</strong>
                @php
                    $activeFilters = collect($filters)->filter(fn ($value) => !empty($value));
                @endphp
                @if($activeFilters->isEmpty())
                    <p class="text-muted mb-0">{{ __('None') }}</p>
                @else
                    <ul class="list-inline mb-0">
                        @foreach($activeFilters as $key => $value)
                            <li class="list-inline-item badge bg-light text-dark border">
                                {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ ucfirst($value) }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Asset') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Branch') }}</th>
                            <th>{{ __('Department') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Next due') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Assigned to') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>
                                    <strong>{{ $schedule->asset_name }}</strong><br>
                                    <small class="text-muted">{{ $schedule->asset_code }}</small>
                                </td>
                                <td>{{ $schedule->category }}</td>
                                <td>{{ $schedule->branch->name ?? __('Headquarters') }}</td>
                                <td>{{ $schedule->department->name ?? __('General') }}</td>
                                <td>{{ ucfirst($schedule->priority) }}</td>
                                <td>{{ optional($schedule->next_due_date)->format('Y-m-d') }}</td>
                                <td>{{ ucfirst($schedule->status) }}</td>
                                <td>{{ $schedule->assignedTo->name ?? __('Unassigned') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">{{ __('No records to print.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-card, .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }

            aside, .sidebar, .navbar, .layout-footer {
                display: none !important;
            }
        }

        .print-card {
            background: #fff;
            border: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => setTimeout(() => window.print(), 200));
    </script>
@endsection

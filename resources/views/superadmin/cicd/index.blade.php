@extends('layouts.main')

@section('page-title')
    {{ __('CI/CD Pipeline') }}
@endsection

@section('page-breadcrumb')
    {{ __('CI/CD Pipeline') }}
@endsection

@push('css')
    <style>
        .cicd-page .card {
            border: 1px solid #d8e2ef;
            border-radius: 14px;
            box-shadow: none !important;
            background: #ffffff;
        }

        .cicd-page .card-header {
            border-bottom: 1px solid #d8e2ef;
            background: #ffffff;
            padding: 14px 18px;
        }

        .cicd-page .card-body {
            padding: 18px;
        }

        .cicd-page .cicd-top-actions {
            flex-wrap: wrap;
        }

        .cicd-page .table-responsive {
            border: 1px solid #d8e2ef;
            border-radius: 12px;
            background: #ffffff;
        }

        .cicd-page .table {
            margin-bottom: 0;
        }

        .cicd-page .table > thead > tr > th {
            background: #f8fbff;
            border-bottom: 1px solid #d8e2ef !important;
            color: #5f7696;
            font-size: 12px;
            letter-spacing: .04em;
            text-transform: uppercase;
            font-weight: 700;
            white-space: nowrap;
        }

        .cicd-page .table > tbody > tr > td {
            border-bottom: 1px solid #e7edf6 !important;
            color: #1f3a62;
            vertical-align: middle;
        }

        .cicd-page .table > tbody > tr:last-child > td {
            border-bottom: 0 !important;
        }

        .cicd-page .repo-meta {
            border: 1px solid #e3ebf7;
            border-radius: 10px;
            background: #fbfdff;
            padding: 12px 14px;
        }
    </style>
@endpush

@section('page-action')
    <div class="d-flex align-items-center gap-2 cicd-top-actions">
        <a class="btn btn-sm btn-light" href="https://github.com/{{ $owner }}/{{ $repo }}/actions" target="_blank">
            <i class="ti ti-external-link"></i> {{ __('Open GitHub Actions') }}
        </a>
        <form action="{{ route('superadmin.cicd.dispatch') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary" @if(!$tokenPresent) disabled @endif
                data-bs-toggle="tooltip" title="{{ $tokenPresent ? __('Dispatch workflow on main') : __('Set GITHUB_TOKEN in .env') }}">
                <i class="ti ti-player-play"></i> {{ __('Run Deploy') }}
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="row cicd-page g-3">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ __('Recent Workflow Runs') }}</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                    @endif

                    @if($error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Conclusion') }}</th>
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('When') }}</th>
                                    <th>{{ __('Actor') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($runs as $run)
                                    <tr>
                                        <td class="text-wrap">{{ $run['name'] ?? ($run['display_title'] ?? 'workflow') }}</td>
                                        <td>
                                            @php $st = $run['status'] ?? 'unknown'; @endphp
                                            <span class="badge @switch($st) @case('queued') bg-secondary @break @case('in_progress') bg-info @break @case('completed') bg-success @break @default bg-light text-dark @endswitch">{{ $st }}</span>
                                        </td>
                                        <td>
                                            @php $cc = $run['conclusion'] ?? ''; @endphp
                                            @if($cc)
                                                <span class="badge @switch($cc) @case('success') bg-success @break @case('failure') bg-danger @break @case('cancelled') bg-secondary @break @default bg-light text-dark @endswitch">{{ $cc }}</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-dark">{{ $run['head_branch'] ?? '' }}</span></td>
                                        <td class="small text-muted">{{ \Illuminate\Support\Carbon::parse($run['created_at'] ?? now())->diffForHumans() }}</td>
                                        <td class="small">{{ $run['actor']['login'] ?? '' }}</td>
                                        <td>
                                            @if(!empty($run['html_url']))
                                                <a class="btn btn-sm btn-outline-secondary" href="{{ $run['html_url'] }}" target="_blank">{{ __('View') }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">{{ __('No runs found') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Repository') }}</h5>
                </div>
                <div class="card-body">
                    <div class="repo-meta">
                        <div class="mb-2"><strong>{{ $owner }}/{{ $repo }}</strong></div>
                        <div class="small text-muted">{{ __('Workflow') }}: {{ $workflow }}</div>
                        <div class="small text-muted">{{ __('Token set') }}: <span class="badge {{ $tokenPresent ? 'bg-success' : 'bg-danger' }}">{{ $tokenPresent ? __('Yes') : __('No') }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

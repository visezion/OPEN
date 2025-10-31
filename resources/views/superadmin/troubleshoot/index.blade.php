@extends('layouts.main')

@section('page-title')
    {{ __('Troubleshoot') }}
@endsection

@section('page-breadcrumb')
    {{ __('Troubleshoot') }}
@endsection

@section('page-action')
    <div class="d-flex gap-2">
        <form action="{{ route('superadmin.troubleshoot.storage-link') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Create public/storage symlink') }}">
                <i class="ti ti-link"></i> {{ __('Create/Repair Storage Symlink') }}
            </button>
        </form>

        <form action="{{ route('superadmin.troubleshoot.cache-clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                title="{{ __('Run cache:clear, config:clear, route:clear, view:clear, optimize:clear') }}">
                <i class="ti ti-broom"></i> {{ __('Clear All Caches') }}
            </button>
        </form>

        <form action="{{ route('superadmin.troubleshoot.cache-build') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip"
                title="{{ __('Run config:cache, route:cache, view:cache') }}">
                <i class="ti ti-rocket"></i> {{ __('Rebuild Caches') }}
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ __('Image & Upload Troubleshoot') }}</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                    @endif

                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold">{{ __('Public storage link') }}</div>
                                <div class="text-muted small">{{ $publicStorage }}</div>
                            </div>
                            @if($linkExists)
                                <span class="badge bg-success">{{ __('Exists') }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ __('Missing') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-semibold">{{ __('Storage public path') }}</div>
                                <div class="text-muted small">{{ $storagePublic }}</div>
                            </div>
                            @if($targetExists)
                                <span class="badge bg-success">{{ __('Exists') }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ __('Missing') }}</span>
                            @endif
                        </div>
                    </div>

                    <p class="text-muted mb-2">{{ __('If images are not visible, create or repair the symbolic link to public/storage. You can also clear and rebuild Laravel caches so new code and views take effect.') }}</p>
                    <form action="{{ route('superadmin.troubleshoot.storage-link') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-link"></i> {{ __('Create/Repair Storage Symlink') }}
                        </button>
                    </form>

                    <hr/>
                    <div class="d-flex gap-2">
                        <form action="{{ route('superadmin.troubleshoot.cache-clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="ti ti-broom"></i> {{ __('Clear All Caches') }}
                            </button>
                        </form>
                        <form action="{{ route('superadmin.troubleshoot.cache-build') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-rocket"></i> {{ __('Rebuild Caches') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Diagnostics') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ __('.env file present') }}</span>
                            <span class="badge {{ $envExists ? 'bg-success' : 'bg-danger' }}">{{ $envExists ? __('Yes') : __('No') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ __('APP_KEY set') }}</span>
                            <span class="badge {{ $appKeySet ? 'bg-success' : 'bg-danger' }}">{{ $appKeySet ? __('Yes') : __('No') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ __('storage/ writable') }}</span>
                            <span class="badge {{ $writableStorage ? 'bg-success' : 'bg-danger' }}">{{ $writableStorage ? __('Yes') : __('No') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ __('bootstrap/cache writable') }}</span>
                            <span class="badge {{ $writableBootstrap ? 'bg-success' : 'bg-danger' }}">{{ $writableBootstrap ? __('Yes') : __('No') }}</span>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">{{ __('Cache driver') }}</div>
                            <div class="fw-semibold">{{ $cacheDriver }}</div>
                            <div>
                                <span class="badge {{ $cacheOk ? 'bg-success' : 'bg-danger' }}">{{ $cacheOk ? __('Write OK') : __('Write failed') }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">{{ __('Queue connection') }}</div>
                            <div class="fw-semibold">{{ $queueConnection }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">{{ __('Session driver') }}</div>
                            <div class="fw-semibold">{{ $sessionDriver }}</div>
                        </li>
                        <li class="list-group-item">
                            <div class="small text-muted">{{ __('Database connectivity') }}</div>
                            <div>
                                @if($dbOk)
                                    <span class="badge bg-success">{{ __('OK') }}</span>
                                @else
                                    <span class="badge bg-danger">{{ __('Failed') }}</span>
                                    <div class="text-muted small mt-1">{{ Str::limit($dbError, 120) }}</div>
                                @endif
                            </div>
                        </li>
                    </ul>

                    <div class="mt-3 d-flex gap-2">
                        <form action="{{ route('superadmin.troubleshoot.permissions-fix') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-shield-check"></i> {{ __('Verify/Set Permissions') }}
                            </button>
                        </form>
                        <form action="{{ route('superadmin.troubleshoot.logs-clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="ti ti-trash"></i> {{ __('Clear Log') }}
                            </button>
                        </form>
                    </div>

                    @if(!empty($logTail))
                        <hr/>
                        <div class="small text-muted mb-1">{{ __('Last 100 log lines') }}</div>
                        <pre class="small" style="max-height:240px;overflow:auto;background:#0f172a;color:#e5e7eb;padding:.75rem;border-radius:.5rem;">{{ $logTail }}</pre>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

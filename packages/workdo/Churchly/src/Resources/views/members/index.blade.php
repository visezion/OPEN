@extends('layouts.main')

@section('page-title', __('Church Members'))

@section('page-action')
<div class="d-flex flex-wrap gap-2">
     @permission('user manage')
            <a href="{{ route('users.list.view') }}" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Verify Member') }}"
                class="btn btn-sm btn-primary btn-icon me-2">
                <i class="ti ti-user-check"></i>
            </a>
        @endpermission
    @permission('user logs history')
        <a href="{{ route('users.userlog.history') }}" class="btn btn-sm btn-primary me-2" data-bs-toggle="tooltip"
            data-bs-placement="top" title="{{ __('User Logs History') }}">
              <i class="ti ti-list"></i>
          
        </a>
    @endpermission

    {{-- ✅ Import Members (AJAX popup) --}}
    <button class="btn btn-sm btn-primary me-2" id="openImportModal" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Import Members') }}">
        <i class="ti ti-file-import"></i>
    </button>


    {{-- ✅ Add New Member --}}
    @permission('church_member create')
        <a href="{{ route('churchly.members.create') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Add Members') }}">
            <i class="ti ti-plus"></i> 
        </a>
    @endpermission
</div>
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="ti ti-users text-primary"></i> {{ __('Church Members') }}
                </h5>
            </div>
            <div class="card-body">
                {{-- ✅ Filters --}}
                <form method="GET" action="{{ route('members.index') }}" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <select name="branch_id" class="form-select">
                            <option value="">{{ __('All Branches') }}</option>
                            @foreach($branches as $id => $name)
                                <option value="{{ $id }}" {{ request('branch_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="form-control" placeholder="{{ __('Search by Name or Phone') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i> {{ __('Filter') }}
                        </button>
                    </div>
                </form>

                {{-- ✅ Members Table --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('No') }}</th>
                                <th>{{ __('Member ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Departments') }}</th>
                                <th>{{ __('Date of Joining') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <td>{{ $loop->iteration + ($members->firstItem() - 1) }}</td>
                                    <td>
                                        <a href="{{ route('members.show', Crypt::encrypt($member->id)) }}"
                                           class="btn btn-outline-primary btn-sm">
                                           #{{ $member->member_id }}
                                        </a>
                                    </td>
                                    <td>{{ $member->name ?? '-' }}</td>
                                    <td>{{ $member->phone ?? '-' }}</td>
                                    <td>{{ $member->email ?? '-' }}</td>
                                    <td>{{ $member->branch?->name ?? '-' }}</td>
                                    <td>{{ $member->departments->pluck('name')->implode(', ') ?: '-' }}</td>
                                    <td>{{ $member->church_doj?->format('d M Y') ?? '-' }}</td>
                                    <td class="text-center">
                                        @include('churchly::members.button', ['member' => $member])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">
                                        {{ __('No members found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ✅ Placeholder for dynamically loaded modal --}}
<div id="importModalContainer"></div>
@endsection


@push('scripts')
<script>
document.getElementById('openImportModal').addEventListener('click', function() {
    fetch("{{ route('members.import.modal') }}")
        .then(response => response.text())
        .then(html => {
            // Insert modal HTML into container
            document.getElementById('importModalContainer').innerHTML = html;

            // Initialize Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('importModal'));
            modal.show();
        })
        .catch(error => console.error('Error loading modal:', error));
});
</script>
@endpush

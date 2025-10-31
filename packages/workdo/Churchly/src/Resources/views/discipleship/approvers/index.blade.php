@extends('layouts.main')

@section('page-title', __('Discipleship Approvers'))

@section('content')
<div class="container-fluid py-4">
    <!-- Assign Approver Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="ti ti-user-check text-primary"></i> {{ __('Assign New Approver') }}
            </h5>

            <form method="POST" action="{{ route('discipleship.approvers.store') }}">
                @csrf
                <div class="row g-3">
                    <!-- Scope -->
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Scope') }}</label>
                        <select name="scope" id="scopeSelect" class="form-select" required>
                            <option value="branch">{{ __('Branch') }}</option>
                            <option value="department">{{ __('Department') }}</option>
                            <option value="stage">{{ __('Stage') }}</option>
                        </select>
                    </div>

                    <!-- Reference -->
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Reference') }}</label>
                        <select name="reference_id" id="referenceSelect" class="form-select" required>
                            {{-- JS will swap options based on scope --}}
                        </select>
                    </div>

                    <!-- Approver User -->
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Approver') }}</label>
                        <select name="user_id" class="form-select" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="ti ti-plus"></i> {{ __('Assign') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Approvers List -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3">
                <i class="ti ti-users text-success"></i> {{ __('Assigned Approvers') }}
            </h5>

            <table class="table table-striped table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('Scope') }}</th>
                        <th>{{ __('Reference') }}</th>
                        <th>{{ __('Approver') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvers as $approver)
                        <tr>
                            <td>{{ ucfirst($approver->scope) }}</td>
                            <td>
                                @if($approver->scope == 'branch')
                                    {{ optional($branches->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id }}
                                @elseif($approver->scope == 'department')
                                    {{ optional($departments->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id }}
                                @elseif($approver->scope == 'stage')
                                    {{ optional($stages->where('id',$approver->reference_id)->first())->name ?? $approver->reference_id }}
                                @endif
                            </td>
                            <td>{{ $approver->user->name }}</td>
                            <td>
                                <form method="POST" action="{{ route('discipleship.approvers.destroy', $approver->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="ti ti-trash"></i> {{ __('Remove') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                <i class="ti ti-inbox"></i> {{ __('No approvers assigned yet.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const scopeSelect = document.getElementById('scopeSelect');
        const referenceSelect = document.getElementById('referenceSelect');

        const branches = @json($branches);
        const departments = @json($departments);
        const stages = @json($stages);

        function populateReferences(scope) {
            referenceSelect.innerHTML = '';

            let options = [];
            if (scope === 'branch') {
                options = branches.map(b => ({id: b.id, name: b.name}));
            } else if (scope === 'department') {
                options = departments.map(d => ({id: d.id, name: d.name}));
            } else if (scope === 'stage') {
                options = stages.map(s => ({id: s.id, name: s.name}));
            }

            options.forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.id;
                option.textContent = opt.name;
                referenceSelect.appendChild(option);
            });
        }

        scopeSelect.addEventListener('change', function () {
            populateReferences(this.value);
        });

        // init with branch
        populateReferences(scopeSelect.value);
    });
</script>
@endpush

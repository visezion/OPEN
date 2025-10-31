@extends('layouts.main')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
        <i class="ti ti-check me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
        <i class="ti ti-alert-circle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@section('page-title', 'Preview Imported Members')

@section('content')
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Preview Cleaned Data</h4>
        <span class="text-muted small">
            <span class="badge bg-success">Green = Exact</span>
            <span class="badge bg-warning">Yellow = Alias / Fuzzy</span>
            <span class="badge bg-danger">Red = Unknown</span>
        </span>
    </div>

    <div class="card-body">
        <form action="{{ route('members.import.confirm') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Role</th>
                            <th>Date Joined</th>
                            <th>Emergency Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cleanRows as $i => $row)
                            <tr>
                                <td>
                                    {{ $row['name'] }}
                                    <input type="hidden" name="rows[{{ $i }}][name]" value="{{ $row['name'] }}">
                                </td>
                                <td>
                                    {{ $row['email'] }}
                                    <input type="hidden" name="rows[{{ $i }}][email]" value="{{ $row['email'] }}">
                                </td>
                                <td>
                                    {{ $row['phone'] }}
                                    <input type="hidden" name="rows[{{ $i }}][phone]" value="{{ $row['phone'] }}">
                                </td>

                                {{-- Branch --}}
                                <td>
                                    @if($row['branch']['name'] === 'Unknown')
                                        <select name="rows[{{ $i }}][branch_id]" class="form-select form-select-sm" required>
                                            <option value="">-- Select Branch --</option>
                                            @foreach($branches as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="badge bg-danger">Unknown</span>
                                    @else
                                        {{ $row['branch']['name'] }}
                                        <input type="hidden" name="rows[{{ $i }}][branch_id]" value="{{ $row['branch']['id'] }}">
                                    @endif
                                </td>

                                {{-- Department --}}
                                <td>
                                    {{ $row['department']['name'] }}
                                    <input type="hidden" name="rows[{{ $i }}][department_id]" value="{{ $row['department']['id'] }}">
                                    <span class="badge 
                                        @if($row['department']['confidence'] == 100) bg-success
                                        @elseif($row['department']['confidence'] >= 70) bg-warning
                                        @else bg-danger @endif">
                                        {{ ucfirst($row['department']['matchType']) }}
                                    </span>
                                </td>

                                {{-- Designation --}}
                                <td>
                                    {{ $row['designation']['name'] }}
                                    <input type="hidden" name="rows[{{ $i }}][designation_id]" value="{{ $row['designation']['id'] }}">
                                    <span class="badge 
                                        @if($row['designation']['confidence'] == 100) bg-success
                                        @elseif($row['designation']['confidence'] >= 70) bg-warning
                                        @else bg-danger @endif">
                                        {{ ucfirst($row['designation']['matchType']) }}
                                    </span>
                                </td>

                                {{-- ✅ Role --}}
                                <td>
                                    <select name="rows[{{ $i }}][role_id]" 
                                            class="form-select form-select-sm" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles as $id => $name)
                                            @if(!in_array($name, ['Super Admin', 'Company']))
                                                <option value="{{ $id }}" 
                                                    {{ $row['role']['id'] == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if($row['role']['name'] === 'Unknown')
                                        <span class="badge bg-danger">Unknown</span>
                                    @endif
                                </td>

                                {{-- Date Joined --}}
                                <td>
                                    {{ $row['church_doj'] }}
                                    <input type="hidden" name="rows[{{ $i }}][church_doj]" value="{{ $row['church_doj'] }}">
                                </td>

                                {{-- Emergency Contact --}}
                                <td>
                                    {{ $row['emergency_contact'] }} <br>
                                    <small class="text-muted">{{ $row['emergency_phone'] }}</small>
                                    <input type="hidden" name="rows[{{ $i }}][emergency_contact]" value="{{ $row['emergency_contact'] }}">
                                    <input type="hidden" name="rows[{{ $i }}][emergency_phone]" value="{{ $row['emergency_phone'] }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('members.import.modal') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Back
                </a>
                <div>
                    <a href="{{ route('members.index') }}" class="btn btn-light me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check"></i> Confirm & Upload
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

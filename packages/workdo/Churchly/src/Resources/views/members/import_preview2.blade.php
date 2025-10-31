@extends('layouts.main')

@section('page-title', 'Preview Imported Members')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Preview Cleaned Data</h4>
        <p class="text-muted">Check mappings. "Unknown" means not found in DB.</p>
    </div>
    <div class="card-body">
        <form action="{{ route('members.import.confirm') }}" method="POST">
            @csrf
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th><th>Email</th><th>Phone</th>
                        <th>Branch</th><th>Department</th><th>Designation</th><th>Role</th>
                        <th>Date Joined</th><th>Emergency Contact</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cleanRows as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['email'] }}</td>
                            <td>{{ $row['phone'] }}</td>

                            {{-- Highlight Unknowns in red --}}
                            <td class="{{ $row['branch_name'] === 'Unknown' ? 'table-danger' : '' }}">
                                {{ $row['branch_name'] }}
                            </td>
                            <td class="{{ $row['department_name'] === 'Unknown' ? 'table-danger' : '' }}">
                                {{ $row['department_name'] }}
                            </td>
                            <td class="{{ $row['designation_name'] === 'Unknown' ? 'table-danger' : '' }}">
                                {{ $row['designation_name'] }}
                            </td>
                            <td class="{{ $row['role_name'] === 'Unknown' ? 'table-danger' : '' }}">
                                {{ $row['role_name'] }}
                            </td>

                            <td>{{ $row['church_doj'] }}</td>
                            <td>{{ $row['emergency_contact'] }} ({{ $row['emergency_phone'] }})</td>
                        </tr>

                        {{-- Hidden row payload --}}
                        <input type="hidden" name="rows[]" value="{{ json_encode($row) }}">
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Confirm & Upload</button>
            <a href="{{ route('members.file') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

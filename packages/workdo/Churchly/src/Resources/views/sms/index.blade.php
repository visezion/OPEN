@extends('layouts.main')

@section('page-title', 'SMS Gateways')

@section('content')
<div class="card">
    <div class="card-header">Add SMS Gateway</div>
    <div class="card-body">
        <form action="{{ route('sms-gateway.store') }}" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-md-3">
                    <input name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-3">
                    <select name="driver" class="form-control" required>
                        <option value="twilio">Twilio</option>
                        <option value="zender">Zender</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input name="api_key" class="form-control" placeholder="API Key">
                </div>
                <div class="col-md-3">
                    <input name="url" class="form-control" placeholder="Zender URL">
                </div>
                <div class="col-12 mt-2">
                    <button class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">Gateways</div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Name</th><th>Driver</th><th>Actions</th></tr>
            @foreach($gateways as $g)
                <tr>
                    <td>{{ $g->name }}</td>
                    <td>{{ ucfirst($g->driver) }}</td>
                    <td>
                        <form action="{{ route('sms-gateway.destroy', $g->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

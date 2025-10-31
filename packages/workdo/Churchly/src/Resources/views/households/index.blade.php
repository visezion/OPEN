@extends('layouts.main')

@section('page-title', __('Households'))
@section('page-breadcrumb', __('Household Directory'))

@section('page-action')
    <a href="{{ route('members.index') }}" class="btn btn-sm btn-light">
        <i class="ti ti-arrow-left"></i> {{ __('Back to members') }}
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Create Household') }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.households.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">{{ __('Household name') }}</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('Primary contact (optional)') }}</label>
                        <input type="number" name="primary_contact_id" class="form-control" placeholder="{{ __('Member ID') }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('Phone') }}</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('Address') }}</label>
                        <input type="text" name="address_line1" class="form-control mb-2" placeholder="{{ __('Address line 1') }}">
                        <input type="text" name="address_line2" class="form-control mb-2" placeholder="{{ __('Address line 2') }}">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control" placeholder="{{ __('City') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="state" class="form-control" placeholder="{{ __('State') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="postal_code" class="form-control" placeholder="{{ __('Postal code') }}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="country" class="form-control" placeholder="{{ __('Country code') }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Notes') }}</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary">{{ __('Save household') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Existing households') }}</h6>
            </div>
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Primary contact') }}</th>
                            <th>{{ __('Members') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($households as $household)
                            <tr>
                                <td>
                                    <strong>{{ $household->name }}</strong>
                                    @if($household->phone)
                                        <div class="small text-muted">{{ $household->phone }}</div>
                                    @endif
                                    @if($household->email)
                                        <div class="small text-muted">{{ $household->email }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ optional($household->primaryContact)->name ?? __('—') }}
                                </td>
                                <td>
                                    {{ $household->members->count() }}
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#household-{{ $household->id }}">
                                        <i class="ti ti-pencil"></i> {{ __('Edit') }}
                                    </button>
                                    <form method="POST" action="{{ route('churchly.households.destroy', $household->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Delete this household?') }}')" type="submit">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr class="collapse" id="household-{{ $household->id }}">
                                <td colspan="4">
                                    <form method="POST" action="{{ route('churchly.households.update', $household->id) }}" class="row g-2">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Name') }}</label>
                                            <input type="text" name="name" value="{{ $household->name }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Primary contact ID') }}</label>
<input type="number" name="primary_contact_id" value="{{ $household->primary_contact_id }}" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">{{ __('Phone') }}</label>
                                            <input type="text" name="phone" value="{{ $household->phone }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Email') }}</label>
                                            <input type="email" name="email" value="{{ $household->email }}" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Postal code') }}</label>
                                            <input type="text" name="postal_code" value="{{ $household->postal_code }}" class="form-control">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('Notes') }}</label>
                                            <textarea name="notes" class="form-control" rows="2">{{ $household->notes }}</textarea>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary btn-sm">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                    @if($household->members->isNotEmpty())
                                        <hr>
                                        <h6 class="small text-uppercase text-muted">{{ __('Members') }}</h6>
                                        @foreach($household->members as $member)
                                            <span class="badge bg-light text-dark me-1 mb-1">
                                                {{ $member->name }}
                                                @if($member->pivot && $member->pivot->relationship)
                                                    <span class="text-muted">({{ $member->pivot->relationship }})</span>
                                                @endif
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">{{ __('No households found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $households->links() }}
            </div>
        </div>
    </div>
</div>
@endsection


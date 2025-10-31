@extends('layouts.main')

@section('page-title')
    {{ __('Import / Export Members') }}
@endsection

@section('page-breadcrumb')
    {{ __('Members') }}
@endsection

@section('page-action')
    <div class="col-auto">
        <a href="{{ asset('templates/members_template.csv') }}" class="btn btn-sm btn-info">
            <i class="ti ti-download"></i> {{ __('Download CSV Template') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Import Members from CSV') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('members.file') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">{{ __('Upload CSV File') }}</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                        <small class="form-text text-muted">
                            {{ __('Only .csv files allowed (max 2MB). Make sure headers match the template.') }}
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Upload & Preview') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

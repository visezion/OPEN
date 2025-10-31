@extends('churchly::layouts.public')

@section('page-title', __('Church Member Registration'))

@section('styles')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .main {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        padding: 40px 30px;
        width: 100%;
        max-width: 550px;
    }

    .main h2 {
        text-align: center;
        color: #2e7d32;
        margin-bottom: 30px;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="date"],
    textarea,
    select {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        background: #fdfdfd;
    }

    textarea {
        resize: vertical;
    }

    button[type="submit"] {
        padding: 12px;
        border-radius: 6px;
        border: none;
        background-color: #388e3c;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: background 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #2e7d32;
    }

    .form-required::after {
        content: "*";
        color: red;
        margin-left: 4px;
    }

    .alert {
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
@endsection

@section('content')
<div class="main">
    <h2>{{ __('Register as a Church Member') }}</h2>

    {{-- ✅ Flash & Validation messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::open([
        'route' => ['churchly.self.register.store', $workspace],
        'method' => 'post',
        'id' => 'member-self-register-form',
        'enctype' => 'multipart/form-data'
    ]) }}

        {{-- Name --}}
        <label for="name" class="form-required">{{ __('Full Name') }}</label>
        {{ Form::text('name', null, ['required', 'placeholder' => __('Enter Full Name')]) }}

        {{-- Email --}}
        <label for="email" class="form-required">{{ __('Email Address') }}</label>
        {{ Form::email('email', null, ['required', 'placeholder' => __('Enter Email Address')]) }}

        {{-- Phone --}}
        <label for="phone">{{ __('Phone Number') }}</label>
        {{ Form::text('phone', null, ['placeholder' => __('Enter Phone Number')]) }}

        {{-- DOB --}}
        <label for="dob">{{ __('Date of Birth') }}</label>
        {{ Form::date('dob', null, ['max' => date('Y-m-d')]) }}

        {{-- Gender --}}
        <label for="gender" class="form-required">{{ __('Gender') }}</label>
        {{ Form::select('gender', ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'], null, ['required']) }}

        {{-- Branch --}}
        <label for="branch_id" class="form-required">{{ __('Church Branch') }}</label>
        {{ Form::select('branch_id', ['' => __('Select Branch')] + $branches->toArray(), null, ['required']) }}

        {{-- Department --}}
        <label for="department_id" class="form-required">{{ __('Department') }}</label>
        {{ Form::select('department_id', ['' => __('Select Department (Optional)')] + $departments->toArray(), null, []) }}

        {{-- Designation --}}
        <label for="designation_id" class="form-required">{{ __('Designation') }}</label>
        {{ Form::select('designation_id', ['' => __('Select Designation (Optional)')] + $designations->toArray(), null, []) }}

        {{-- Date of Joining --}}
        <label for="doj" class="form-required">{{ __('Church Date of Joining') }}</label>
        {{ Form::date('doj', null, ['max' => date('Y-m-d')]) }}

        {{-- Address --}}
        <label for="address" class="form-required">{{ __('Address') }}</label>
        {{ Form::textarea('address', null, ['rows' => 2, 'placeholder' => __('Enter Address')]) }}

        {{-- Emergency Contact --}}
        <label for="emergency_contact" class="form-required">{{ __('Emergency Contact Name') }}</label>
        {{ Form::text('emergency_contact', null, ['required', 'placeholder' => __('Enter Emergency Contact Name')]) }}

        <label for="emergency_phone" class="form-required">{{ __('Emergency Contact Phone Number') }}</label>
        {{ Form::text('emergency_phone', null, ['required', 'placeholder' => __('Enter Emergency Contact Phone Number')]) }}

        {{-- Documents --}}
        <label for="documents">{{ __('Upload Document (Optional)') }}</label>
        {{ Form::file('documents') }}

        {{-- Hidden Status --}}
        {{ Form::hidden('is_active', 0) }}

        <button type="submit">{{ __('Register') }}</button>

    {{ Form::close() }}
</div>
@endsection

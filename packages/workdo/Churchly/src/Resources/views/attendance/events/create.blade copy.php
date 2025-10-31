@extends('layouts.main')

@section('page-title', __('Create Event'))

@section('content')
<div class="card shadow-sm p-4">
    <form method="POST" action="{{ route('churchly.events.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('Title') }}</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('Description') }}</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('Date') }}</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('Start Time') }}</label>
                <input type="time" name="start_time" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('End Time') }}</label>
                <input type="time" name="end_time" class="form-control">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('Event Type') }}</label>
            <select name="event_type" class="form-control" required>
                <option value="service">Service</option>
                <option value="meeting">Meeting</option>
                <option value="discipleship">Discipleship</option>
                <option value="special_event">Special Event</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">{{ __('Save Event') }}</button>
    </form>
</div>
@endsection

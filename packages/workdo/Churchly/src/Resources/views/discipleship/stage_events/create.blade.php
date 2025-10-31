@extends('layouts.main')

@section('page-title', __('Link Events to Discipleship Stage'))

@section('content')
<div class="card shadow-sm p-4">
    <form method="POST" action="{{ route('churchly.discipleship.stage_events.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('Select Stage') }}</label>
            <select name="stage_id" class="form-control" required>
                @foreach($stages as $stage)
                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Select Event') }}</label>
            <select name="event_id" class="form-control" required>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }} ({{ $event->date }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ __('Link Event') }}</button>
    </form>
</div>
@endsection

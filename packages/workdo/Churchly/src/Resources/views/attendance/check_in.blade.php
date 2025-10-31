@extends('layouts.guest')

@section('content')
<div class="card shadow-sm p-4 text-center">
    <h4>{{ $attendanceEvent->event->title }}</h4>
    <p>{{ __('Welcome! Please confirm your presence.') }}</p>

    <form action="{{ route('churchly.attendance.onlineCheckIn', $attendanceEvent->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success btn-lg">✅ I Am Here</button>
    </form>

    @if($attendanceEvent->online_platform === 'zoom')
        <p class="mt-3">Join Zoom Meeting: <a href="{{ $attendanceEvent->meeting_link }}" target="_blank">Click Here</a></p>
    @elseif($attendanceEvent->online_platform === 'youtube')
        <iframe width="560" height="315" 
            src="{{ $attendanceEvent->meeting_link }}" 
            frameborder="0" allowfullscreen></iframe>
    @endif
</div>
@endsection

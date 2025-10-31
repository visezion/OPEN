@extends('layouts.main')

@section('page-title', __('Communication Log'))

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0">{{ __('Log Communication') }}</h6></div>
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.care.communications.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ __('Member') }}</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">{{ __('Select member') }}</option>
                            @foreach($members as $id => $name)
                                <option value="{{ $id }}" {{ old('member_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Channel') }}</label>
                        <select name="channel" class="form-select" required>
                            @foreach(['email','sms','call','visit','other'] as $channel)
                                <option value="{{ $channel }}" {{ old('channel') == $channel ? 'selected' : '' }}>{{ ucfirst($channel) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Subject') }}</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Sent at') }}</label>
                        <input type="datetime-local" name="sent_at" class="form-control" value="{{ old('sent_at') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Summary / Notes') }}</label>
                        <textarea name="body" rows="3" class="form-control">{{ old('body') }}</textarea>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary">{{ __('Save Communication') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Member') }}</th>
                            <th>{{ __('Channel') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Sent') }}</th>
                            <th>{{ __('Sender') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($communications as $communication)
                            <tr>
                                <td>{{ optional($communication->member)->name ?? '-' }}</td>
                                <td class="text-uppercase">{{ $communication->channel }}</td>
                                <td>{{ $communication->subject ?? '—' }}</td>
                                <td class="small text-muted">{{ optional($communication->sent_at ?? $communication->created_at)->format('Y-m-d H:i') }}</td>
                                <td>{{ optional($communication->sender)->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">{{ __('No communications found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $communications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

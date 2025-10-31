@extends('layouts.main')

@section('page-title', __('Pastoral Notes'))

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header"><h6 class="mb-0">{{ __('Quick Add Note') }}</h6></div>
            <div class="card-body">
                <form method="POST" action="{{ route('churchly.care.notes.store') }}">
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
                        <label class="form-label">{{ __('Title') }}</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="{{ __('Optional subject line') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Confidential Note') }}</label>
                        <textarea name="body" rows="4" class="form-control" required>{{ old('body') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Visibility') }}</label>
                        <select name="visibility" class="form-select" required>
                            @foreach(['staff','pastoral','leaders','private'] as $option)
                                <option value="{{ $option }}" {{ old('visibility') == $option ? 'selected' : '' }}>{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="requires_attention" value="1" id="note-attention" {{ old('requires_attention') ? 'checked' : '' }}>
                        <label class="form-check-label" for="note-attention">{{ __('Flag for pastoral attention') }}</label>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary">{{ __('Save Note') }}</button>
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
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Visibility') }}</th>
                            <th>{{ __('When') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            <tr>
                                <td>{{ optional($note->member)->name ?? '-' }}</td>
                                <td>{{ $note->title ?? __('Note') }}</td>
                                <td><span class="badge bg-secondary text-uppercase">{{ $note->visibility }}</span></td>
                                <td class="small text-muted">{{ $note->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">{{ __('No notes found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $notes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

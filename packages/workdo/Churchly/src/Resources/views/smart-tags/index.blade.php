@extends('layouts.main')

@section('page-title', __('Smart Tags'))
@section('page-breadcrumb', __('Smart Tags Automation'))

@section('page-action')
    <a href="{{ route('churchly.smart-tags.create') }}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i> {{ __('Create Tag') }}
    </a>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Members matched') }}</th>
                    <th>{{ __('Last run') }}</th>
                    <th class="text-end">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($smartTags as $tag)
                    <tr>
                        <td>
                            <strong>{{ $tag->name }}</strong>
                            @if($tag->description)
                                <div class="small text-muted">{{ $tag->description }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $tag->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $tag->is_active ? __('Active') : __('Disabled') }}</span>
                        </td>
                        <td>{{ $tag->members_count }}</td>
                        <td class="small text-muted">{{ $tag->last_run_at ? $tag->last_run_at->diffForHumans() : __('Never') }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('churchly.smart-tags.run', $tag->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary" type="submit">
                                    <i class="ti ti-refresh"></i> {{ __('Run') }}
                                </button>
                            </form>
                            <a href="{{ route('churchly.smart-tags.edit', $tag->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-pencil"></i> {{ __('Edit') }}
                            </a>
                            <form method="POST" action="{{ route('churchly.smart-tags.destroy', $tag->id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Delete this tag?') }}')" type="submit">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">{{ __('No smart tags defined yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $smartTags->links() }}
    </div>
</div>
@endsection

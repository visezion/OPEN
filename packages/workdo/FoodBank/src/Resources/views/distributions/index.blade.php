@extends('layouts.main')

@section('page-title', __('Distributions'))
@section('page-action')
    <a href="{{ route('foodbank.distributions.create') }}" class="btn btn-primary">{{ __('Log distribution') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Request') }}</th>
                        <th>{{ __('Item') }}</th>
                        <th>{{ __('Method') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-end">{{ __('Scheduled') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{ $record->request->requester_name }}</td>
                            <td>{{ optional($record->inventory)->item_name }}</td>
                            <td>{{ ucfirst($record->method) }}</td>
                            <td>{{ $record->quantity_distributed }}</td>
                            <td>{{ ucfirst($record->status) }}</td>
                            <td class="text-end">{{ optional($record->scheduled_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $records->links() }}
        </div>
    </div>
@endsection

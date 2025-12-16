@extends('layouts.main')

@section('page-title', __('Inventory'))
@section('page-action')
    <a href="{{ route('foodbank.inventory.create') }}" class="btn btn-primary">{{ __('Log inventory') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>{{ __('Item') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Pickup') }}</th>
                        <th>{{ __('Delivery') }}</th>
                        <th class="text-end">{{ __('Received') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->quantity }} {{ $item->unit }}</td>
                            <td>{{ $item->pickup_location }}</td>
                            <td>{{ $item->delivery_details }}</td>
                            <td class="text-end">{{ optional($item->received_at)->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $items->links() }}
        </div>
    </div>
@endsection

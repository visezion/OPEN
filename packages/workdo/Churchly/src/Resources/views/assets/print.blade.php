<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ __('Asset inventory print') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <h2>{{ __('Asset inventory snapshot') }}</h2>
    <p>{{ __('Generated at') }} {{ now()->format('F j, Y H:i') }}</p>
    @if(!empty($filters['category']) || !empty($filters['branch_id']) || !empty($filters['department_id']) || !empty($filters['status']))
        <p class="text-muted">
            {{ __('Filters applied') }}:
            @if($filters['category']) {{ __('Category') }}: {{ $filters['category'] }}; @endif
            @if($filters['branch_id']) {{ __('Branch') }}: {{ $filters['branch_id'] }}; @endif
            @if($filters['department_id']) {{ __('Department') }}: {{ $filters['department_id'] }}; @endif
            @if($filters['status']) {{ __('Status') }}: {{ $statusOptions[$filters['status']] ?? $filters['status'] }}; @endif
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>{{ __('Asset') }}</th>
                <th>{{ __('Category') }}</th>
                <th>{{ __('Branch') }}</th>
                <th>{{ __('Quantity') }}</th>
                <th>{{ __('Available') }}</th>
                <th>{{ __('Status') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
                <tr>
                    <td>{{ $asset->asset_name }}</td>
                    <td>{{ $asset->category ?? __('General') }}</td>
                    <td>{{ optional($asset->branch)->name ?? __('Headquarters') }}</td>
                    <td>{{ $asset->quantity }}</td>
                    <td>{{ $asset->available_quantity }}</td>
                    <td>{{ $statusOptions[$asset->status] ?? ucfirst($asset->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

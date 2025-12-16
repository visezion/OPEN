<?php

namespace Workdo\Churchly\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetInventoryExport implements FromCollection, WithHeadings
{
    protected Collection $assets;

    public function __construct(Collection $assets)
    {
        $this->assets = $assets;
    }

    public function collection()
    {
        return $this->assets->map(function ($asset) {
            return [
                $asset->asset_name,
                $asset->asset_code,
                $asset->asset_tag,
                $asset->category,
                optional($asset->branch)->name ?? __('Headquarters'),
                optional($asset->department)->name ?? __('General'),
                ucfirst($asset->status),
                $asset->quantity,
                $asset->available_quantity,
                optional($asset->assignedTo)->name ?? __('Unassigned'),
                $asset->condition,
                $asset->location,
                optional($asset->updated_at)->format('Y-m-d H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            __('Asset'),
            __('Code'),
            __('Tag'),
            __('Category'),
            __('Branch'),
            __('Department'),
            __('Status'),
            __('Quantity'),
            __('Available'),
            __('Assigned to'),
            __('Condition'),
            __('Location'),
            __('Updated At'),
        ];
    }
}

<?php

namespace Workdo\Churchly\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Workdo\Churchly\Entities\MaintenanceSchedule;

class MaintenanceScheduleExport implements FromCollection, WithHeadings, WithMapping
{
    protected Collection $schedules;

    public function __construct(Collection $schedules)
    {
        $this->schedules = $schedules;
    }

    public function collection(): Collection
    {
        return $this->schedules;
    }

    public function headings(): array
    {
        return [
            'Asset',
            'Asset Code',
            'Category',
            'Branch',
            'Department',
            'Priority',
            'Next Due',
            'Status',
            'Assigned to',
        ];
    }

    public function map($schedule): array
    {
        assert($schedule instanceof MaintenanceSchedule);

        return [
            $schedule->asset_name,
            $schedule->asset_code,
            $schedule->category,
            optional($schedule->branch)->name,
            optional($schedule->department)->name,
            ucfirst($schedule->priority),
            optional($schedule->next_due_date)->toDateString(),
            ucfirst($schedule->status),
            optional($schedule->assignedTo)->name,
        ];
    }
}

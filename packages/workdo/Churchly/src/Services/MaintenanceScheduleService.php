<?php

namespace Workdo\Churchly\Services;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Workdo\Churchly\Entities\MaintenanceSchedule;

class MaintenanceScheduleService
{
    public static function nextDueDateFromSchedule(MaintenanceSchedule $schedule): ?Carbon
    {
        $reference = $schedule->last_completed_at
            ? Carbon::parse($schedule->last_completed_at)
            : ($schedule->next_due_date
                ? Carbon::parse($schedule->next_due_date)
                : Carbon::parse($schedule->start_date));

        return self::calculateNextDueDate(
            $schedule->frequency_type,
            $schedule->frequency_value,
            $reference,
            $schedule->end_date
        );
    }

    public static function initialNextDueDate(string $frequencyType, ?int $frequencyValue, CarbonInterface $startDate, ?string $endDate = null): Carbon
    {
        return self::calculateNextDueDate($frequencyType, $frequencyValue, $startDate, $endDate);
    }

    public static function calculateNextDueDate(string $frequencyType, ?int $frequencyValue, CarbonInterface $base, ?string $endDate = null): Carbon
    {
        $value = max(1, (int) ($frequencyValue ?? 1));
        $next = match ($frequencyType) {
            'one_time' => $base->copy(),
            'daily' => $base->copy()->addDays($value),
            'weekly' => $base->copy()->addWeeks($value),
            'monthly' => $base->copy()->addMonths($value),
            'quarterly' => $base->copy()->addMonths(3 * $value),
            'yearly' => $base->copy()->addYears($value),
            default => $base->copy()->addDays($value),
        };

        if ($endDate) {
            $limit = Carbon::parse($endDate);
            if ($next->greaterThan($limit)) {
                return $limit;
            }
        }

        return $next;
    }
}

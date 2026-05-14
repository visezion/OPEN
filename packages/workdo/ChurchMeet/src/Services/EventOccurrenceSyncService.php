<?php

namespace Workdo\ChurchMeet\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Workdo\ChurchMeet\Entities\AttendanceEvent;
use Workdo\ChurchMeet\Entities\Event;
use Workdo\ChurchMeet\Entities\EventOccurrence;

class EventOccurrenceSyncService
{
    public function sync(Event $event, array $attendanceTemplate = []): Collection
    {
        $schedule = $this->buildSchedule($event);
        $existingOccurrences = $event->occurrences()
            ->with(['attendanceEvent.records'])
            ->orderBy('sequence')
            ->get()
            ->keyBy('sequence');

        $syncedAttendanceEvents = collect();

        foreach ($schedule as $sequence => $occurrenceData) {
            $sequenceNumber = $sequence + 1;
            $occurrence = $existingOccurrences->get($sequenceNumber);

            if (!$occurrence) {
                $occurrence = new EventOccurrence([
                    'workspace_id' => $event->workspace_id,
                    'event_id' => $event->id,
                    'sequence' => $sequenceNumber,
                    'created_by' => $attendanceTemplate['created_by'] ?? $event->created_by,
                ]);
            }

            if ($this->canRescheduleOccurrence($occurrence)) {
                $occurrence->starts_at = $occurrenceData['starts_at'];
                $occurrence->ends_at = $occurrenceData['ends_at'];
                $occurrence->is_cancelled = false;
            }

            $occurrence->workspace_id = $occurrence->workspace_id ?: $event->workspace_id;
            $occurrence->event_id = $event->id;
            $occurrence->sequence = $sequenceNumber;
            $occurrence->created_by = $occurrence->created_by ?: ($attendanceTemplate['created_by'] ?? $event->created_by);
            $occurrence->save();

            $attendanceEvent = $this->syncAttendanceEvent($event, $occurrence, $attendanceTemplate);
            $syncedAttendanceEvents->push($attendanceEvent);
        }

        $this->retireExtraOccurrences($event, $schedule->count());

        return $syncedAttendanceEvents;
    }

    public function buildSchedule(Event $event): Collection
    {
        $startAt = $event->start_time
            ? ($event->start_time instanceof Carbon ? $event->start_time->copy() : Carbon::parse($event->start_time))
            : null;
        $endAt = $event->end_time
            ? ($event->end_time instanceof Carbon ? $event->end_time->copy() : Carbon::parse($event->end_time))
            : null;
        $recurrence = (string) ($event->recurrence ?: 'none');

        if (!$startAt || $recurrence === 'none') {
            return collect([[
                'starts_at' => $startAt,
                'ends_at' => $endAt,
            ]]);
        }

        $occurrenceCount = (int) ($event->recurrence_count ?: 0);
        $recurrenceUntil = $event->recurrence_until
            ? ($event->recurrence_until instanceof Carbon ? $event->recurrence_until->copy() : Carbon::parse($event->recurrence_until))
            : null;

        if ($occurrenceCount <= 0 && !$recurrenceUntil) {
            $occurrenceCount = match ($recurrence) {
                'daily' => 30,
                'weekly' => 26,
                'monthly' => 12,
                default => 1,
            };
        }

        $schedule = collect();
        $nextStartAt = $startAt->copy();
        $nextEndAt = $endAt?->copy();
        $generated = 0;

        while (true) {
            if ($recurrenceUntil && $nextStartAt->greaterThan($recurrenceUntil)) {
                break;
            }

            $schedule->push([
                'starts_at' => $nextStartAt->copy(),
                'ends_at' => $nextEndAt?->copy(),
            ]);

            $generated++;

            if ($occurrenceCount > 0 && $generated >= $occurrenceCount) {
                break;
            }

            [$nextStartAt, $nextEndAt] = $this->incrementOccurrence($recurrence, $nextStartAt, $nextEndAt);
        }

        return $schedule->values();
    }

    protected function incrementOccurrence(string $recurrence, Carbon $startAt, ?Carbon $endAt): array
    {
        $nextStartAt = $startAt->copy();
        $nextEndAt = $endAt?->copy();

        match ($recurrence) {
            'daily' => $nextStartAt->addDay(),
            'weekly' => $nextStartAt->addWeek(),
            'monthly' => $nextStartAt->addMonth(),
            default => null,
        };

        if ($nextEndAt) {
            match ($recurrence) {
                'daily' => $nextEndAt->addDay(),
                'weekly' => $nextEndAt->addWeek(),
                'monthly' => $nextEndAt->addMonth(),
                default => null,
            };
        }

        return [$nextStartAt, $nextEndAt];
    }

    protected function syncAttendanceEvent(Event $event, EventOccurrence $occurrence, array $template): AttendanceEvent
    {
        $attendanceEvent = $occurrence->attendanceEvent ?: AttendanceEvent::firstOrNew([
            'workspace_id' => $event->workspace_id,
            'event_id' => $event->id,
            'occurrence_id' => $occurrence->id,
        ]);

        $attendanceEvent->workspace_id = $event->workspace_id;
        $attendanceEvent->event_id = $event->id;
        $attendanceEvent->occurrence_id = $occurrence->id;
        $attendanceEvent->branch_id = $template['branch_id'] ?? $attendanceEvent->branch_id;
        $attendanceEvent->department_id = $template['department_id'] ?? $attendanceEvent->department_id;
        $attendanceEvent->mode = $template['mode'] ?? $attendanceEvent->mode ?? 'onsite';
        $attendanceEvent->enabled_methods = $template['enabled_methods'] ?? $attendanceEvent->enabled_methods ?? [];
        $attendanceEvent->online_platform = $template['online_platform'] ?? $attendanceEvent->online_platform;
        $attendanceEvent->meeting_link = $template['meeting_link'] ?? $attendanceEvent->meeting_link;
        $attendanceEvent->meeting_id = $template['meeting_id'] ?? $attendanceEvent->meeting_id;
        $attendanceEvent->meeting_passcode = $template['meeting_passcode'] ?? $attendanceEvent->meeting_passcode;
        $attendanceEvent->auto_log_attendance = $template['auto_log_attendance'] ?? $attendanceEvent->auto_log_attendance ?? false;
        $attendanceEvent->created_by = $attendanceEvent->created_by ?: ($template['created_by'] ?? $event->created_by);

        if ($this->canRescheduleAttendanceEvent($attendanceEvent)) {
            $attendanceEvent->checkin_start_at = $occurrence->starts_at;
            $attendanceEvent->checkin_end_at = $occurrence->ends_at;
        }

        $attendanceEvent->save();

        return $attendanceEvent->fresh(['event', 'occurrence', 'records']);
    }

    protected function retireExtraOccurrences(Event $event, int $activeCount): void
    {
        $event->occurrences()
            ->with(['attendanceEvent.records'])
            ->where('sequence', '>', $activeCount)
            ->get()
            ->each(function (EventOccurrence $occurrence) {
                $attendanceEvent = $occurrence->attendanceEvent;
                $hasRecords = $attendanceEvent && $attendanceEvent->records->isNotEmpty();

                if ($hasRecords) {
                    $occurrence->is_cancelled = true;
                    $occurrence->save();

                    return;
                }

                if ($attendanceEvent) {
                    $attendanceEvent->delete();
                }

                $occurrence->delete();
            });
    }

    protected function canRescheduleOccurrence(EventOccurrence $occurrence): bool
    {
        if (!$occurrence->exists) {
            return true;
        }

        if ($occurrence->attendanceEvent && $occurrence->attendanceEvent->records->isNotEmpty()) {
            return false;
        }

        if ($occurrence->starts_at && $occurrence->starts_at->isPast()) {
            return false;
        }

        return true;
    }

    protected function canRescheduleAttendanceEvent(AttendanceEvent $attendanceEvent): bool
    {
        if (!$attendanceEvent->exists) {
            return true;
        }

        if ($attendanceEvent->relationLoaded('records') && $attendanceEvent->records->isNotEmpty()) {
            return false;
        }

        if ($attendanceEvent->records()->exists()) {
            return false;
        }

        if ($attendanceEvent->checkin_start_at && $attendanceEvent->checkin_start_at->isPast()) {
            return false;
        }

        return true;
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('church_events', 'recurrence_until')) {
            Schema::table('church_events', function (Blueprint $table) {
                $table->dateTime('recurrence_until')->nullable()->after('recurrence');
            });
        }

        if (!Schema::hasColumn('church_events', 'recurrence_count')) {
            Schema::table('church_events', function (Blueprint $table) {
                $table->unsignedInteger('recurrence_count')->nullable()->after('recurrence_until');
            });
        }

        if (!Schema::hasTable('church_event_occurrences')) {
            Schema::create('church_event_occurrences', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workspace_id')->nullable()->index();
                $table->unsignedBigInteger('event_id')->index();
                $table->unsignedInteger('sequence')->default(1);
                $table->dateTime('starts_at')->nullable()->index();
                $table->dateTime('ends_at')->nullable();
                $table->boolean('is_cancelled')->default(false);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();

                $table->unique(['event_id', 'sequence'], 'church_event_occurrence_event_sequence_unique');
            });
        }

        if (!Schema::hasColumn('attendance_events', 'occurrence_id')) {
            Schema::table('attendance_events', function (Blueprint $table) {
                $table->unsignedBigInteger('occurrence_id')->nullable()->after('event_id');
                $table->index('occurrence_id');
            });
        }

        $this->backfillOccurrences();
    }

    public function down(): void
    {
        if (Schema::hasColumn('attendance_events', 'occurrence_id')) {
            Schema::table('attendance_events', function (Blueprint $table) {
                $table->dropIndex(['occurrence_id']);
                $table->dropColumn('occurrence_id');
            });
        }

        Schema::dropIfExists('church_event_occurrences');

        if (Schema::hasColumn('church_events', 'recurrence_count')) {
            Schema::table('church_events', function (Blueprint $table) {
                $table->dropColumn('recurrence_count');
            });
        }

        if (Schema::hasColumn('church_events', 'recurrence_until')) {
            Schema::table('church_events', function (Blueprint $table) {
                $table->dropColumn('recurrence_until');
            });
        }
    }

    protected function backfillOccurrences(): void
    {
        if (!Schema::hasTable('church_events') || !Schema::hasTable('attendance_events')) {
            return;
        }

        DB::table('church_events')
            ->orderBy('id')
            ->chunkById(100, function ($events) {
                foreach ($events as $event) {
                    $existingOccurrenceIds = DB::table('church_event_occurrences')
                        ->where('event_id', $event->id)
                        ->pluck('id')
                        ->all();

                    if (!empty($existingOccurrenceIds)) {
                        $firstOccurrenceId = $existingOccurrenceIds[0];

                        DB::table('attendance_events')
                            ->where('event_id', $event->id)
                            ->whereNull('occurrence_id')
                            ->update(['occurrence_id' => $firstOccurrenceId]);

                        continue;
                    }

                    $attendanceEvents = DB::table('attendance_events')
                        ->where('event_id', $event->id)
                        ->orderByRaw('CASE WHEN checkin_start_at IS NULL THEN 1 ELSE 0 END')
                        ->orderBy('checkin_start_at')
                        ->orderBy('id')
                        ->get();

                    if ($attendanceEvents->isEmpty()) {
                        DB::table('church_event_occurrences')->insert([
                            'workspace_id' => $event->workspace_id,
                            'event_id' => $event->id,
                            'sequence' => 1,
                            'starts_at' => $event->start_time,
                            'ends_at' => $event->end_time,
                            'is_cancelled' => false,
                            'created_by' => $event->created_by,
                            'created_at' => $event->created_at ?? now(),
                            'updated_at' => $event->updated_at ?? now(),
                        ]);

                        continue;
                    }

                    foreach ($attendanceEvents as $index => $attendanceEvent) {
                        $occurrenceId = DB::table('church_event_occurrences')->insertGetId([
                            'workspace_id' => $attendanceEvent->workspace_id ?: $event->workspace_id,
                            'event_id' => $event->id,
                            'sequence' => $index + 1,
                            'starts_at' => $attendanceEvent->checkin_start_at ?: $event->start_time,
                            'ends_at' => $attendanceEvent->checkin_end_at ?: $event->end_time,
                            'is_cancelled' => false,
                            'created_by' => $attendanceEvent->created_by ?: $event->created_by,
                            'created_at' => $attendanceEvent->created_at ?? $event->created_at ?? now(),
                            'updated_at' => $attendanceEvent->updated_at ?? $event->updated_at ?? now(),
                        ]);

                        DB::table('attendance_events')
                            ->where('id', $attendanceEvent->id)
                            ->update(['occurrence_id' => $occurrenceId]);
                    }
                }
            });
    }
};

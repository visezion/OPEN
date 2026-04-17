<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('church_feedback', function (Blueprint $table) {
            if (!Schema::hasColumn('church_feedback', 'record_kind')) {
                $table->string('record_kind', 40)->default('legacy')->after('attachment');
            }

            if (!Schema::hasColumn('church_feedback', 'week_ending_date')) {
                $table->date('week_ending_date')->nullable()->after('email');
            }

            if (!Schema::hasColumn('church_feedback', 'report_payload')) {
                $table->json('report_payload')->nullable()->after('record_kind');
            }

            if (!Schema::hasColumn('church_feedback', 'attendance_summary')) {
                $table->json('attendance_summary')->nullable()->after('report_payload');
            }

            if (!Schema::hasColumn('church_feedback', 'attendance_event_id')) {
                $table->unsignedBigInteger('attendance_event_id')->nullable()->after('department_id');
                $table->foreign('attendance_event_id')
                    ->references('id')
                    ->on('attendance_events')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('church_feedback', function (Blueprint $table) {
            if (Schema::hasColumn('church_feedback', 'attendance_event_id')) {
                $table->dropForeign(['attendance_event_id']);
                $table->dropColumn('attendance_event_id');
            }

            foreach (['attendance_summary', 'report_payload', 'week_ending_date', 'record_kind'] as $column) {
                if (Schema::hasColumn('church_feedback', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

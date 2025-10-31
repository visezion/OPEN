<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('attendance_events', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance_events','checkin_start_at')) {
                $table->dateTime('checkin_start_at')->nullable()->after('meeting_passcode');
            }
            if (!Schema::hasColumn('attendance_events','checkin_end_at')) {
                $table->dateTime('checkin_end_at')->nullable()->after('checkin_start_at');
            }
        });
    }
    public function down(): void
    {
        Schema::table('attendance_events', function (Blueprint $table) {
            if (Schema::hasColumn('attendance_events','checkin_end_at')) $table->dropColumn('checkin_end_at');
            if (Schema::hasColumn('attendance_events','checkin_start_at')) $table->dropColumn('checkin_start_at');
        });
    }
};
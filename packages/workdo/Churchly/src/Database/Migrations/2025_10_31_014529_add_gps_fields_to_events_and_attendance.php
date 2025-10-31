<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('church_events', function (Blueprint $table) {
            if (!Schema::hasColumn('church_events','latitude')) {
                $table->decimal('latitude',10,6)->nullable()->after('venue');
            }
            if (!Schema::hasColumn('church_events','longitude')) {
                $table->decimal('longitude',10,6)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('church_events','radius_meters')) {
                $table->integer('radius_meters')->default(100)->after('longitude');
            }
        });
        Schema::table('attendance_records', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance_records','check_in_lat')) {
                $table->decimal('check_in_lat',10,6)->nullable()->after('check_in_time');
            }
            if (!Schema::hasColumn('attendance_records','check_in_lng')) {
                $table->decimal('check_in_lng',10,6)->nullable()->after('check_in_lat');
            }
            if (!Schema::hasColumn('attendance_records','distance_from_event')) {
                $table->float('distance_from_event')->nullable()->after('check_in_lng');
            }
        });
        // Extend enum for device_used if MySQL
        try {
            DB::statement("ALTER TABLE attendance_records MODIFY device_used ENUM('manual','qr','kiosk','app','face_ai','zoom','youtube','online','gps','web_gps') DEFAULT 'manual'");
        } catch (\Throwable $e) { /* ignore if not MySQL or already altered */ }
    }
    public function down(): void
    {
        Schema::table('attendance_records', function (Blueprint $table) {
            if (Schema::hasColumn('attendance_records','check_in_lat')) $table->dropColumn('check_in_lat');
            if (Schema::hasColumn('attendance_records','check_in_lng')) $table->dropColumn('check_in_lng');
            if (Schema::hasColumn('attendance_records','distance_from_event')) $table->dropColumn('distance_from_event');
        });
        Schema::table('church_events', function (Blueprint $table) {
            if (Schema::hasColumn('church_events','radius_meters')) $table->dropColumn('radius_meters');
            if (Schema::hasColumn('church_events','longitude')) $table->dropColumn('longitude');
            if (Schema::hasColumn('church_events','latitude')) $table->dropColumn('latitude');
        });
    }
};
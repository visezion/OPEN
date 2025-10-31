<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('workspace_id');
        $table->unsignedBigInteger('attendance_event_id');
        $table->unsignedBigInteger('member_id');
        $table->enum('status', ['present', 'absent', 'late', 'excused'])->default('absent');
        $table->timestamp('check_in_time')->nullable();
        $table->timestamp('check_out_time')->nullable();
        $table->enum('device_used', ['manual', 'qr', 'kiosk', 'app', 'face_ai','zoom','youtube'])->default('manual');
        $table->integer('streak_count')->default(0);
        $table->integer('xp_points')->default(0);
        $table->unsignedBigInteger('reviewed_by')->nullable();
        $table->timestamps();

        $table->foreign('attendance_event_id')->references('id')->on('attendance_events')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};

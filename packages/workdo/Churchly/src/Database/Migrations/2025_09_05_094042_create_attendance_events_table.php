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
        Schema::create('attendance_events', function (Blueprint $table) {
            $table->id();

            // 🔹 Workspace & organization scope
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            // 🔹 Linked event (fix foreign key)
            $table->unsignedBigInteger('event_id');

            // 🔹 Mode and configuration
            $table->enum('mode', ['onsite', 'online', 'hybrid'])->default('onsite');
            $table->json('enabled_methods')->nullable(); 
            // Example: ["manual","qr","kiosk","face_ai","zoom","youtube"]

            $table->string('online_platform')->nullable(); // zoom, youtube, facebook, custom
            $table->string('meeting_link')->nullable();
            $table->string('meeting_id')->nullable(); // for Zoom
            $table->string('meeting_passcode')->nullable();

            // 🔹 Features
            $table->boolean('auto_log_attendance')->default(false);
            $table->string('qr_code')->nullable();
            $table->boolean('face_ai_enabled')->default(false);

            // 🔹 Audit
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            // 🔹 Foreign key relationships
            $table->foreign('workspace_id')
                  ->references('id')
                  ->on('work_spaces')
                  ->cascadeOnDelete();

            $table->foreign('event_id')
                  ->references('id')
                  ->on('church_events') // ✅ FIXED from 'events' → 'church_events'
                  ->cascadeOnDelete();

            $table->foreign('branch_id')
                  ->references('id')
                  ->on('church_branches')
                  ->nullOnDelete();

            $table->foreign('department_id')
                  ->references('id')
                  ->on('church_departments')
                  ->nullOnDelete();

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_events');
    }
};

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
        Schema::create('church_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_member_id')->nullable()->constrained('church_members')->nullOnDelete();
            $table->string('full_name');
            $table->string('preferred_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 50)->nullable();
            $table->enum('status', ['active', 'inactive', 'paused'])->default('active');
            $table->date('joined_at')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('church_volunteer_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
            $table->unique(['workspace', 'name']);
        });

        Schema::create('church_volunteer_skill_map', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('church_volunteers')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('church_volunteer_skills')->cascadeOnDelete();
            $table->enum('proficiency', ['beginner', 'intermediate', 'advanced', 'expert'])->default('intermediate');
            $table->timestamps();
            $table->unique(['volunteer_id', 'skill_id']);
        });

        Schema::create('church_volunteer_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('church_volunteers')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('church_departments')->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->unique(['volunteer_id', 'department_id']);
        });

        Schema::create('church_volunteer_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('church_volunteers')->cascadeOnDelete();
            $table->string('title');
            $table->string('provider')->nullable();
            $table->date('completed_on')->nullable();
            $table->date('valid_until')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'expired'])->default('completed');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('church_volunteer_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('church_volunteers')->cascadeOnDelete();
            $table->enum('day_of_week', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'flexible'])->default('flexible');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            $table->string('timezone')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('church_volunteer_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('volunteer_id')->constrained('church_volunteers')->cascadeOnDelete();
            $table->enum('assignment_type', ['event', 'attendance_event', 'worship_team', 'service_role'])->default('event');
            $table->unsignedBigInteger('assignment_id')->nullable();
            $table->string('assignment_label')->nullable();
            $table->string('role')->nullable();
            $table->dateTime('scheduled_for')->nullable();
            $table->enum('status', ['planned', 'confirmed', 'completed', 'cancelled'])->default('planned');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('workspace')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->timestamps();

            $table->index(['assignment_type', 'assignment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_volunteer_assignments');
        Schema::dropIfExists('church_volunteer_availabilities');
        Schema::dropIfExists('church_volunteer_trainings');
        Schema::dropIfExists('church_volunteer_departments');
        Schema::dropIfExists('church_volunteer_skill_map');
        Schema::dropIfExists('church_volunteer_skills');
        Schema::dropIfExists('church_volunteers');
    }
};

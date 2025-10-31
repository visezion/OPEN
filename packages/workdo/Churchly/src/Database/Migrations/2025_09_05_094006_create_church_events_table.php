<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_events', function (Blueprint $table) {
            $table->id();

            // 🔗 Foreign keys
            $table->unsignedBigInteger('workspace_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->unsignedBigInteger('assistant_id')->nullable();

            $table->foreign('workspace_id')
                ->references('id')->on('work_spaces')->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('id')->on('users')->cascadeOnDelete();

            $table->foreign('lead_id')
                ->references('id')->on('church_members')->nullOnDelete();

            $table->foreign('assistant_id')
                ->references('id')->on('church_members')->nullOnDelete();

            // 📋 Core Event Details
            $table->string('title');
            $table->text('description')->nullable();
             $table->text('reviewer_comments')->nullable();
            $table->enum('event_type', [
                'service',
                'meeting',
                'rehearsal',
                'training',
                'outreach',
                'other'
            ])->default('service');

            $table->datetime('start_time')->nullable();
            $table->datetime('end_time')->nullable();
            $table->enum('recurrence', ['none', 'daily', 'weekly', 'monthly'])->default('none');
            $table->string('venue')->nullable();

            // 🟢 Workflow & Progress
            $table->enum('status', ['draft', 'review', 'approved', 'published', 'revision_required', 'resubmitted'])->default('draft');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('published_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();

            // 📎 Extra Data
            $table->json('attendance_methods')->nullable();
            $table->json('attachments')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_events');
    }
};

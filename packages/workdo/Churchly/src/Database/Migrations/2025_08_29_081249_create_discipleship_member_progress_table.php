<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discipleship_member_progress', function (Blueprint $table) {
            $table->id();

            // 🔗 Relations
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('stage_id')->index();
            $table->unsignedBigInteger('requirement_id')->index();

            // 📊 Status Tracking
            $table->enum('status', ['pending', 'in_review', 'approved', 'completed'])->default('pending');
            $table->string('evidence')->nullable(); // file path or notes
            $table->unsignedBigInteger('reviewed_by')->nullable();

            // 📅 Timestamps
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // 🔐 Multi-tenant
            $table->unsignedBigInteger('workspace')->index();

            // 🏆 Gamification
            $table->integer('points')->default(0); // points earned for this requirement
            $table->boolean('badge_awarded')->default(false); // whether a badge was awarded
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipleship_member_progress');
    }
};

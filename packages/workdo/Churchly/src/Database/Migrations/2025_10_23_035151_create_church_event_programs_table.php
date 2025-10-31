<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_event_programs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->integer('order_no')->default(1);
            $table->string('program_item');
            $table->integer('duration')->default(0);
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->text('note')->nullable();

            // 🟢 Workflow & Progress Fields
            $table->enum('status', ['draft', 'review', 'approved', 'published'])->default('draft');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('event_id')->references('id')->on('church_events')->onDelete('cascade');
            $table->foreign('leader_id')->references('id')->on('church_members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_event_programs');
    }
};

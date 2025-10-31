<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_event_reviewer_comments', function (Blueprint $table) {
            $table->id();

            // 🔗 Foreign Keys
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('role')->nullable(); // reviewer, approver, creator, etc.

            $table->foreign('event_id')
                ->references('id')->on('church_events')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();

            // 💬 Comment Content
            $table->text('comment');
            $table->timestamp('commented_at')->useCurrent();

            // 🕒 System timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_event_reviewer_comments');
    }
};

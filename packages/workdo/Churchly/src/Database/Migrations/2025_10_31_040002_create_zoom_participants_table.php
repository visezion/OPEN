<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zoom_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('meeting_id')->nullable();
            $table->string('meeting_uuid')->nullable();
            $table->unsignedBigInteger('attendance_event_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_name')->nullable();
            $table->string('zoom_user_id')->nullable();
            $table->timestamp('join_time')->nullable();
            $table->timestamp('leave_time')->nullable();
            $table->integer('duration')->nullable();
            $table->longText('raw_json')->nullable();
            $table->timestamps();
            $table->index(['workspace_id','meeting_id']);
            $table->index(['attendance_event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zoom_participants');
    }
};


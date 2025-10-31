<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('youtube_video_id');
            $table->string('channel_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('duration')->nullable(); // ISO 8601, e.g., PT1H2M3S
            $table->string('live_broadcast_content')->nullable(); // none, upcoming, live, completed
            $table->timestamp('published_at')->nullable();
            $table->longText('raw_json')->nullable();
            $table->timestamps();
            $table->unique(['workspace_id','youtube_video_id']);
            $table->index(['workspace_id','published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
    }
};


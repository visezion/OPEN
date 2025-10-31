<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('youtube_sync_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('channel_id')->nullable();
            $table->string('playlist_id')->nullable();
            $table->enum('mode', ['all','live'])->default('all');
            $table->integer('interval_minutes')->default(60); // 5..1440
            $table->string('api_key')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->index(['workspace_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_sync_settings');
    }
};


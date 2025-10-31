<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zoom_sync_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('account_id')->nullable();
            $table->string('client_id')->nullable();
            $table->string('client_secret')->nullable();
            $table->text('oauth_access_token')->nullable();
            $table->text('oauth_refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('interval_minutes')->default(15); // 5..1440
            $table->timestamp('last_synced_at')->nullable();
            $table->string('webhook_secret')->nullable();
            $table->timestamps();
            $table->index(['workspace_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zoom_sync_settings');
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asset_notification_settings')) {
            return;
        }

        Schema::create('asset_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->json('notification_methods')->nullable();
            $table->time('notification_time')->nullable();
            $table->unsignedTinyInteger('low_stock_threshold')->default(5);
            $table->unsignedTinyInteger('inspection_reminder_days')->default(7);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_notification_settings');
    }
};

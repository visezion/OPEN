<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasTable('maintenance_settings')) {
            return;
        }

        Schema::create('maintenance_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->json('notification_methods')->nullable();
            $table->time('notification_time')->nullable();
            $table->unsignedTinyInteger('reminder_before_days')->default(2);
            $table->string('default_category')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_settings');
    }
};

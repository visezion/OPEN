<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_app_publish_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->boolean('android_store_connected')->default(false);
            $table->boolean('ios_store_connected')->default(false);
            $table->json('google_play_json')->nullable();
            $table->json('app_store_connect_json')->nullable();
            $table->enum('release_channel',['multi_tenant','white_label'])->default('multi_tenant');
            $table->string('current_version',20)->nullable();
            $table->json('store_links')->nullable();
            $table->timestamps();

            $table->unique('workspace_id');
            $table->foreign('workspace_id')->references('id')->on('work_spaces')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_app_publish_settings');
    }
};

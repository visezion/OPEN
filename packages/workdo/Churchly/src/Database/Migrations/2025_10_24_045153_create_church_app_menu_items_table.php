<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_app_menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('title',100);
            $table->string('feature_key',100)->nullable();
            $table->string('icon_name',100)->nullable();
            $table->enum('target_type',['feature','url','screen'])->default('feature');
            $table->string('target_value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();

            $table->index(['workspace_id','sort_order']);
            $table->foreign('workspace_id')->references('id')->on('work_spaces')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_app_menu_items');
    }
};

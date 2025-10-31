<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('church_app_features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id');
            $table->string('feature_key',100);
            $table->boolean('enabled')->default(true);
            $table->json('config')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['workspace_id','feature_key']);
            $table->foreign('workspace_id')->references('id')->on('work_spaces')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_app_features');
    }
};

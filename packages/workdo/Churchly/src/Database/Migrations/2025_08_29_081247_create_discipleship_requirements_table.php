<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discipleship_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stage_id')->index();
            $table->string('type'); // attendance, quiz, upload, mentor_approval, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->integer('points')->default(0);
            $table->boolean('auto_complete')->default(false);
            $table->boolean('requires_approval')->default(false);
            $table->unsignedBigInteger('workspace')->index();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipleship_requirements');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discipleship_mentorships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mentor_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->enum('status', ['active','completed'])->default('active');
            $table->unsignedBigInteger('workspace')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipleship_mentorships');
    }
};

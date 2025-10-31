<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discipleship_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace')->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipleship_stages');
    }
};

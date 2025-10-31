<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discipleship_stage_events', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('stage_id');
        $table->unsignedBigInteger('event_id'); // link to events table
        $table->timestamps();

        $table->foreign('stage_id')->references('id')->on('discipleship_stages')->onDelete('cascade');
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipleship_stage_events');
    }
};

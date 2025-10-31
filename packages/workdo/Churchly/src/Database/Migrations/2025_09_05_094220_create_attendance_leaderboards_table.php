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
        Schema::create('attendance_leaderboards', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('workspace_id');
        $table->unsignedBigInteger('member_id');
        $table->integer('month');
        $table->integer('year');
        $table->integer('attendance_count')->default(0);
        $table->integer('streak_longest')->default(0);
        $table->integer('rank')->default(0);
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_leaderboards');
    }
};

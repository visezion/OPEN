<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('church_activity_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id')->references('id')->on('church_members')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->string('activity_type');
            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->json('metadata')->nullable();
            $table->string('status')->default('completed');

            $table->string('ip_address')->nullable();
            $table->string('device')->nullable();
            $table->string('location')->nullable();

            $table->unsignedBigInteger('workspace')->nullable();
            $table->foreign('workspace')->references('id')->on('work_spaces')->onDelete('cascade');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('church_activity_logs');
    }
};

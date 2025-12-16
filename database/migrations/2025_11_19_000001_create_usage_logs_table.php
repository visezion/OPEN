<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usage_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('workspace_id')->nullable()->index();
            $table->string('route', 255)->nullable()->index();
            $table->text('url');
            $table->text('user_agent')->nullable();
            $table->string('controller', 255)->nullable();
            $table->string('method', 10);
            $table->decimal('execution_time', 10, 5)->nullable()->default(0);
            $table->string('ip', 45)->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usage_logs');
    }
};

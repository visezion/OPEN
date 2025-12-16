<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('function_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status', 50);
            $table->decimal('execution_time', 10, 5)->nullable();
            $table->json('parameters')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('function_logs');
    }
};

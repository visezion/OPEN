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
        // migration file
    Schema::create('sms_gateways', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('workspace_id');
        $table->string('driver'); // e.g. twilio, zender
        $table->string('name');
        $table->string('api_key')->nullable();
        $table->string('api_secret')->nullable();
        $table->string('url')->nullable(); // for Zender or others
        $table->string('from')->nullable();
        $table->json('extra')->nullable();
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_gateways');
    }
};

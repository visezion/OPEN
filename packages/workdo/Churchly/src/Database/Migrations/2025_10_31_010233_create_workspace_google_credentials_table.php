<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workspace_google_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('redirect_uri');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->unique(['workspace_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('workspace_google_credentials');
    }
};
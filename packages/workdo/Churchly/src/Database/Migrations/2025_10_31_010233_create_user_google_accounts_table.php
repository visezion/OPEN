<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_google_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('workspace_id')->nullable()->index();
            $table->string('google_id')->index();
            $table->string('email')->index();
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->text('scopes')->nullable();
            $table->timestamps();
            $table->unique(['user_id','google_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('user_google_accounts');
    }
};
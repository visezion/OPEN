<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void {
 Schema::create('site_themes', function (Blueprint $table) {
  $table->id();
  $table->unsignedBigInteger('workspace_id')->index();
  $table->string('primary_color')->nullable();
  $table->string('secondary_color')->nullable();
  $table->string('font_family')->nullable();
  $table->string('logo_path')->nullable();
  $table->string('favicon_path')->nullable();
  $table->text('custom_css')->nullable();
  $table->timestamps();
  $table->unique(['workspace_id']);
 });
} public function down(): void { Schema::dropIfExists('site_themes'); } };
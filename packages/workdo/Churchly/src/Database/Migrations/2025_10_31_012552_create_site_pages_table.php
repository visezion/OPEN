<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void {
 Schema::create('site_pages', function (Blueprint $table) {
  $table->id();
  $table->unsignedBigInteger('workspace_id')->index();
  $table->string('slug')->index();
  $table->string('title');
  $table->json('meta')->nullable();
  $table->boolean('is_home')->default(false);
  $table->boolean('is_published')->default(true);
  $table->integer('sort_order')->default(0);
  $table->timestamps();
  $table->unique(['workspace_id','slug']);
 });
} public function down(): void { Schema::dropIfExists('site_pages'); } };
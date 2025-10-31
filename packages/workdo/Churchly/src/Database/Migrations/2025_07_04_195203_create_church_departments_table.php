<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('church_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('church_branches')->onDelete('cascade');
            $table->string('name');
            $table->unsignedBigInteger('workspace')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_departments');
    }
};

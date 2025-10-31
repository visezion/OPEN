<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discipleship_approvers', function (Blueprint $table) {
            $table->id();

            // Who is the approver (pastor/admin/mentor user account)
            $table->unsignedBigInteger('user_id')->index();

            // Scope of approval: branch, department, or stage
            $table->enum('scope', ['branch','department','stage'])->index();

            // Reference to branch_id, department_id, or stage_id
            $table->unsignedBigInteger('reference_id')->index();

            // Multi-tenant
            $table->unsignedBigInteger('workspace')->index();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discipleship_approvers');
    }
};

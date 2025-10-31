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
        Schema::create('church_feedback', function (Blueprint $table) {
            $table->id();

            // Feedback details
            $table->string('title')->nullable();
            $table->text('message');
            $table->enum('type', ['internal', 'public']);
            $table->enum('category', ['suggestion', 'complaint', 'praise', 'other'])->default('other');
            $table->boolean('is_anonymous')->default(false);
            $table->string('name')->nullable();
            $table->string('email')->nullable();

            // Review & response
            $table->enum('status', ['pending', 'reviewed', 'resolved'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('attachment')->nullable();

            // Relational fields
            $table->unsignedBigInteger('submitted_by')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->unsignedBigInteger('workspace_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('submitted_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('workspace_id')->references('id')->on('work_spaces')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('church_branches')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('church_departments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_feedback');
    }
};

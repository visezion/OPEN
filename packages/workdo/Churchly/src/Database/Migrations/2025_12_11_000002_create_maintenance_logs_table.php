<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('maintenance_logs')) {
            Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->date('due_date');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('performed_by')->nullable();
            $table->unsignedBigInteger('reported_by')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('cost_incurred', 12, 2)->nullable();
            $table->string('attachments')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('schedule_id')->references('id')->on('maintenance_schedules')->cascadeOnDelete();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_logs');
    }
};

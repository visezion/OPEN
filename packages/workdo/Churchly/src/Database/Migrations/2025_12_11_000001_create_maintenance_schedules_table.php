<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('maintenance_schedules')) {
            Schema::create('maintenance_schedules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('workspace_id')->index();
                $table->unsignedBigInteger('branch_id')->nullable()->index();
                $table->unsignedBigInteger('department_id')->nullable()->index();
                $table->string('asset_name');
                $table->string('asset_code')->nullable();
                $table->string('location')->nullable();
                $table->string('category');
                $table->string('priority')->default('medium');
                $table->string('frequency_type');
                $table->unsignedInteger('frequency_value')->nullable();
                $table->date('start_date');
                $table->date('end_date')->nullable();
                $table->date('next_due_date');
                $table->dateTime('last_completed_at')->nullable();
                $table->unsignedInteger('estimated_duration_minutes')->nullable();
                $table->decimal('estimated_cost', 12, 2)->nullable();
                $table->string('status')->default('active');
                $table->unsignedBigInteger('assigned_to')->nullable();
                $table->unsignedBigInteger('created_by');
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->unique(['workspace_id', 'asset_code']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_schedules');
    }
};

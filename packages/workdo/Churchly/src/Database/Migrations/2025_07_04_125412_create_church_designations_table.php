<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('church_designations')) {
            Schema::create('church_designations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->integer('branch_id')->nullable();
                $table->integer('department_id');
                $table->unsignedBigInteger('workspace');
                $table->unsignedBigInteger('created_by');
                $table->timestamps();
            });

            Log::info('✅ Table "church_designations" created successfully via migration.');
        } else {
            Log::warning('⚠️ Migration skipped: Table "church_designations" already exists.');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('church_designations')) {
            Schema::dropIfExists('church_designations');
            Log::info('✅ Table "church_designations" dropped successfully via migration rollback.');
        } else {
            Log::warning('⚠️ Rollback skipped: Table "church_designations" does not exist.');
        }
    }
};

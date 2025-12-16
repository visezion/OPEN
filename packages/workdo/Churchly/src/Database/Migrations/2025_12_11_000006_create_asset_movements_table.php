<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asset_movements')) {
            return;
        }

        Schema::create('asset_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->foreignId('asset_inventory_id')->constrained('asset_inventories')->cascadeOnDelete();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->unsignedBigInteger('from_branch_id')->nullable()->index();
            $table->unsignedBigInteger('from_department_id')->nullable()->index();
            $table->unsignedBigInteger('to_branch_id')->nullable()->index();
            $table->unsignedBigInteger('to_department_id')->nullable()->index();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('moved_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('recorded_by')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};

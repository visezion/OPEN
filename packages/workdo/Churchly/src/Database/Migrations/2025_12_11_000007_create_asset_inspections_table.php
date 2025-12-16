<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('asset_inspections')) {
            return;
        }

        Schema::create('asset_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->foreignId('asset_inventory_id')->constrained('asset_inventories')->cascadeOnDelete();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->unsignedBigInteger('inspector_id')->nullable();
            $table->text('findings')->nullable();
            $table->string('status')->default('ok');
            $table->decimal('cost_incurred', 12, 2)->nullable();
            $table->dateTime('inspected_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('next_inspection_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_inspections');
    }
};

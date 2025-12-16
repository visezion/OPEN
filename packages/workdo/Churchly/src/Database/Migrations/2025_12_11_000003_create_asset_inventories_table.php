<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('asset_inventories')) {
            Schema::create('asset_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->string('asset_name');
            $table->string('asset_code')->nullable();
            $table->string('asset_tag')->nullable();
            $table->string('category')->nullable();
            $table->string('asset_type')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('location')->nullable();
            $table->string('condition')->nullable();
            $table->date('acquired_at')->nullable();
            $table->date('warranty_expires_at')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('available_quantity')->default(0);
            $table->string('status')->default('operational');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('notes')->nullable();
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('asset_inventories');
    }
};

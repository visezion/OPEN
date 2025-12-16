<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foodbank_inventory', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('unit')->default('pcs');
            $table->date('received_at')->nullable();
            $table->unsignedBigInteger('donor_id')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('delivery_details')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foodbank_inventory');
    }
};

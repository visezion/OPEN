<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foodbank_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workspace_id')->index();
            $table->foreignId('request_id')->constrained('foodbank_requests')->cascadeOnDelete();
            $table->foreignId('inventory_id')->nullable()->constrained('foodbank_inventory')->nullOnDelete();
            $table->integer('quantity_distributed')->default(0);
            $table->enum('method', ['pickup', 'delivery'])->default('pickup');
            $table->text('delivery_address')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['pending', 'complete', 'cancelled'])->default('pending');
            $table->unsignedBigInteger('handled_by')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foodbank_distributions');
    }
};

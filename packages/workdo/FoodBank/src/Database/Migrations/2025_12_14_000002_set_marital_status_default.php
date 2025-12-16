<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'other'])
                ->default('single')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->enum('marital_status', ['single', 'married', 'other'])
                ->default('single')
                ->nullable(false)
                ->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foodbank_public_tokens', function (Blueprint $table) {
            $table->softDeletes()->after('updated_by');
        });
    }

    public function down(): void
    {
        Schema::table('foodbank_public_tokens', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

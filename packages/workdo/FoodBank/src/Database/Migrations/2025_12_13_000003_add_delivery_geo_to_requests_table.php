<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->string('delivery_map')->nullable()->after('delivery_preference');
            $table->decimal('delivery_lat', 10, 6)->nullable()->after('delivery_map');
            $table->decimal('delivery_lng', 10, 6)->nullable()->after('delivery_lat');
        });
    }

    public function down(): void
    {
        Schema::table('foodbank_requests', function (Blueprint $table) {
            $table->dropColumn(['delivery_map', 'delivery_lat', 'delivery_lng']);
        });
    }
};

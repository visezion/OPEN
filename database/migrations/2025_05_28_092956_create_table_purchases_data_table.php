<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('vendors') || !Schema::hasTable('purchases')) {
            return;
        }

        $rows = DB::table('purchases')
            ->select('purchases.id', 'vendors.id as vendor_id')
            ->join('vendors', 'purchases.user_id', '=', 'vendors.user_id')
            ->whereNull('purchases.vender_id')
            ->get();

        foreach ($rows as $row) {
            DB::table('purchases')
                ->where('id', $row->id)
                ->update(['vender_id' => $row->vendor_id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: data migration only.
    }
};

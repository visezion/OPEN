<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('church_members') && !Schema::hasColumn('church_members', 'qr_code')) {
            Schema::table('church_members', function (Blueprint $table) {
                $table->string('qr_code')->nullable()->after('membership_status');
            });
        }
    }

    public function down(): void
    {
        Schema::table('church_members', function (Blueprint $table) {
            if (Schema::hasColumn('church_members', 'qr_code')) {
                $table->dropColumn('qr_code');
            }
        });
    }
};

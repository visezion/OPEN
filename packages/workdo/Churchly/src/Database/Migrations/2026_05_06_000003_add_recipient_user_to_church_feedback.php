<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('church_feedback') || Schema::hasColumn('church_feedback', 'recipient_user_id')) {
            return;
        }

        Schema::table('church_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('recipient_user_id')->nullable()->after('department_id');
            $table->foreign('recipient_user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('church_feedback') || !Schema::hasColumn('church_feedback', 'recipient_user_id')) {
            return;
        }

        Schema::table('church_feedback', function (Blueprint $table) {
            $table->dropForeign(['recipient_user_id']);
            $table->dropColumn('recipient_user_id');
        });
    }
};

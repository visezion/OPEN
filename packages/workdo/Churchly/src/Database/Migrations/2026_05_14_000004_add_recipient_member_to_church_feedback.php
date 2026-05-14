<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('church_feedback')) {
            return;
        }

        if (!Schema::hasColumn('church_feedback', 'recipient_member_id')) {
            Schema::table('church_feedback', function (Blueprint $table) {
                $table->unsignedBigInteger('recipient_member_id')->nullable()->after('recipient_user_id');
            });
        }

        DB::table('church_feedback as feedback')
            ->join('church_members as member', function ($join) {
                $join->on('member.user_id', '=', 'feedback.recipient_user_id')
                    ->whereColumn('member.workspace', 'feedback.workspace_id');
            })
            ->whereNull('feedback.recipient_member_id')
            ->update([
                'feedback.recipient_member_id' => DB::raw('member.id'),
            ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('church_feedback') || !Schema::hasColumn('church_feedback', 'recipient_member_id')) {
            return;
        }

        Schema::table('church_feedback', function (Blueprint $table) {
            $table->dropColumn('recipient_member_id');
        });
    }
};

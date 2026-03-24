<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('zoom_sync_settings', 'host_user_id')) {
                $table->string('host_user_id')->nullable()->after('client_secret');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'meeting_sdk_key')) {
                $table->string('meeting_sdk_key')->nullable()->after('host_user_id');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'meeting_sdk_secret')) {
                $table->string('meeting_sdk_secret')->nullable()->after('meeting_sdk_key');
            }
        });

        Schema::table('attendance_events', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance_events', 'host_start_url')) {
                $table->text('host_start_url')->nullable()->after('meeting_link');
            }

            if (!Schema::hasColumn('attendance_events', 'zoom_join_url')) {
                $table->text('zoom_join_url')->nullable()->after('host_start_url');
            }

            if (!Schema::hasColumn('attendance_events', 'zoom_meeting_uuid')) {
                $table->string('zoom_meeting_uuid')->nullable()->after('meeting_passcode');
            }

            if (!Schema::hasColumn('attendance_events', 'zoom_created_at')) {
                $table->timestamp('zoom_created_at')->nullable()->after('zoom_meeting_uuid');
            }

            if (!Schema::hasColumn('attendance_events', 'zoom_created_by')) {
                $table->unsignedBigInteger('zoom_created_by')->nullable()->after('zoom_created_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendance_events', function (Blueprint $table) {
            $columns = [
                'host_start_url',
                'zoom_join_url',
                'zoom_meeting_uuid',
                'zoom_created_at',
                'zoom_created_by',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('attendance_events', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            $columns = [
                'host_user_id',
                'meeting_sdk_key',
                'meeting_sdk_secret',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('zoom_sync_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('zoom_sync_settings', 'preferred_platform')) {
                $table->string('preferred_platform')->nullable()->after('workspace_id');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'jitsi_enabled')) {
                $table->boolean('jitsi_enabled')->default(true)->after('preferred_platform');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'jitsi_server_domain')) {
                $table->string('jitsi_server_domain')->nullable()->after('jitsi_enabled');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'jitsi_room_prefix')) {
                $table->string('jitsi_room_prefix')->nullable()->after('jitsi_server_domain');
            }
        });
    }

    public function down(): void
    {
        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            foreach (['jitsi_room_prefix', 'jitsi_server_domain', 'jitsi_enabled', 'preferred_platform'] as $column) {
                if (Schema::hasColumn('zoom_sync_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

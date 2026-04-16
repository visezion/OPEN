<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_enabled')) {
                $table->boolean('livekit_enabled')->default(false)->after('jitsi_room_prefix');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_server_url')) {
                $table->string('livekit_server_url')->nullable()->after('livekit_enabled');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_api_key')) {
                $table->string('livekit_api_key')->nullable()->after('livekit_server_url');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_api_secret')) {
                $table->string('livekit_api_secret')->nullable()->after('livekit_api_key');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_room_prefix')) {
                $table->string('livekit_room_prefix')->nullable()->after('livekit_api_secret');
            }

            if (!Schema::hasColumn('zoom_sync_settings', 'livekit_token_ttl_minutes')) {
                $table->unsignedInteger('livekit_token_ttl_minutes')->default(120)->after('livekit_room_prefix');
            }
        });
    }

    public function down(): void
    {
        Schema::table('zoom_sync_settings', function (Blueprint $table) {
            foreach ([
                'livekit_token_ttl_minutes',
                'livekit_room_prefix',
                'livekit_api_secret',
                'livekit_api_key',
                'livekit_server_url',
                'livekit_enabled',
            ] as $column) {
                if (Schema::hasColumn('zoom_sync_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

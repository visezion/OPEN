<?php

namespace Workdo\Churchly\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\YouTubeSyncSetting;
use Workdo\Churchly\Services\YouTubeSyncService;

class YouTubeSyncCommand extends Command
{
    protected $signature = 'churchly:youtube-sync {--workspace=}';
    protected $description = 'Sync YouTube videos for active workspaces based on schedule';

    public function handle(YouTubeSyncService $service): int
    {
        $workspace = $this->option('workspace');
        $settings = YouTubeSyncSetting::query()
            ->when($workspace, fn($q)=>$q->where('workspace_id', $workspace))
            ->where('active', true)
            ->get();

        $now = now();
        $synced = 0;
        foreach ($settings as $s) {
            $due = !$s->last_synced_at || $s->last_synced_at->addMinutes(max(5, (int)$s->interval_minutes)) <= $now;
            if (!$due) continue;
            $this->info("Syncing workspace {$s->workspace_id}...");
            $added = $service->sync($s);
            $s->last_synced_at = $now;
            $s->save();
            $synced += $added;
        }
        $this->info("Done. Updated/checked {$synced} videos.");
        return self::SUCCESS;
    }
}


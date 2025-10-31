<?php

namespace Workdo\Churchly\Console\Commands;

use Illuminate\Console\Command;
use Workdo\Churchly\Entities\ZoomSyncSetting;
use Workdo\Churchly\Services\ZoomSyncService;

class ZoomSyncCommand extends Command
{
    protected $signature = 'churchly:zoom-sync {--workspace=}';
    protected $description = 'Sync Zoom participants to attendance records per workspace';

    public function handle(ZoomSyncService $service): int
    {
        $workspace = $this->option('workspace');
        $settings = ZoomSyncSetting::query()
            ->when($workspace, fn($q)=>$q->where('workspace_id',$workspace))
            ->where('active', true)->get();
        $now = now();
        $total = 0;
        foreach ($settings as $s) {
            $due = !$s->last_synced_at || $s->last_synced_at->addMinutes(max(5,(int)$s->interval_minutes)) <= $now;
            if (!$due) continue;
            $this->info("Sync workspace {$s->workspace_id}...");
            $total += $service->syncDue($s);
            $s->last_synced_at = $now;
            $s->save();
        }
        $this->info("Zoom sync completed. Rows processed: {$total}");
        return self::SUCCESS;
    }
}


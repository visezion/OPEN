<?php

namespace Workdo\Churchly\Services;

use Illuminate\Support\Str;
use Workdo\Churchly\Entities\AssetInventory;

class AssetInventoryService
{
    public static function generateAssetCode(int $workspaceId): string
    {
        $count = AssetInventory::where('workspace_id', $workspaceId)->count();
        $suffix = strtoupper(Str::random(4));
        return sprintf('AST-%s-%s', $suffix, $count + 1);
    }
}

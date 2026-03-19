<?php

namespace Workdo\Churchly\Helpers;

use App\Models\WorkSpace;

class ChurchHelper
{
    public static function getWorkspaceIdBySlug($slug)
    {
        return WorkSpace::where('slug', $slug)->value('id');
    }

    public static function getWorkspaceCreator($workspaceId)
    {
        return WorkSpace::find($workspaceId)?->created_by ?? 1;
    }

    public static function getDefaultWorkSpace()
    {
        return auth()->check() ? auth()->user()->workspace_id : WorkSpace::first()?->id;
    }

    public static function getActiveWorkSpaceSlug()
    {
        if (auth()->check()) {
            $workspace = auth()->user()->getActiveWorkspace;
            return $workspace ? $workspace->slug : null;
        }

        return WorkSpace::first()?->slug;
    }

    public static function getWorkspaceByCreator()
    {
        if (!auth()->check()) {
            return null;
        }

        $userId = auth()->id();
        $creatorId = \App\Models\User::find($userId)->active_workspace;
        $workspace = \App\Models\WorkSpace::where('id', $creatorId)->first();

        if (!$workspace) {
            return null;
        }

        return [
            'id'   => $workspace->id,
            'name' => $workspace->name,
            'slug' => $workspace->slug,
        ];
    }



}

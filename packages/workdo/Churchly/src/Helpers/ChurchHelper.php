<?php

namespace Workdo\Churchly\Helpers;

use App\Models\Workspace;

class ChurchHelper
{
    public static function getWorkspaceIdBySlug($slug)
    {
        return Workspace::where('slug', $slug)->value('id');
    }

    public static function getWorkspaceCreator($workspaceId)
    {
        return Workspace::find($workspaceId)?->created_by ?? 1;
    }

    public static function getDefaultWorkSpace()
    {
        return auth()->check() ? auth()->user()->workspace_id : Workspace::first()?->id;
    }

    public static function getActiveWorkSpaceSlug()
    {
        if (auth()->check()) {
            $workspace = auth()->user()->getActiveWorkspace;
            return $workspace ? $workspace->slug : null;
        }

        return Workspace::first()?->slug;
    }

    public static function getWorkspaceByCreator()
    {
        if (!auth()->check()) {
            return null;
        }

        $userId = auth()->id();
        $creatorId = \App\Models\User::find($userId)->active_workspace;
        $workspace = \App\Models\Workspace::where('id', $creatorId)->first();

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

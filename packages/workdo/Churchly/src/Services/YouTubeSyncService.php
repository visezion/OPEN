<?php

namespace Workdo\Churchly\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\{YouTubeSyncSetting, YouTubeVideo};

class YouTubeSyncService
{
    public function sync(YouTubeSyncSetting $setting): int
    {
        $apiKey = $setting->api_key ?: config('services.youtube.key');
        if (!$apiKey) {
            Log::channel('daily')->warning('[YouTubeSync] Missing API key for workspace '.$setting->workspace_id);
            return 0;
        }

        $channelId = $setting->channel_id;
        $playlistId = $setting->playlist_id;
        $mode = $setting->mode; // all|live

        try {
            $items = [];
            if ($mode === 'live') {
                // Live videos only
                $params = [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'eventType' => 'live',
                    'type' => 'video',
                    'maxResults' => 25,
                    'order' => 'date',
                    'key' => $apiKey,
                ];
                $resp = Http::get('https://www.googleapis.com/youtube/v3/search', $params);
                $resp->throw();
                $items = $resp->json('items') ?: [];
                $videoIds = collect($items)->pluck('id.videoId')->filter()->values()->all();
                $detailMap = $this->fetchDetails($videoIds, $apiKey);
                $count = $this->upsertVideos($setting->workspace_id, $items, $detailMap);
            } else {
                // All recent videos from channel via search
                $params = [
                    'part' => 'snippet',
                    'channelId' => $channelId,
                    'type' => 'video',
                    'maxResults' => 25,
                    'order' => 'date',
                    'key' => $apiKey,
                ];
                $resp = Http::get('https://www.googleapis.com/youtube/v3/search', $params);
                $resp->throw();
                $items = $resp->json('items') ?: [];
                $videoIds = collect($items)->pluck('id.videoId')->filter()->values()->all();
                $detailMap = $this->fetchDetails($videoIds, $apiKey);
                $count = $this->upsertVideos($setting->workspace_id, $items, $detailMap);
            }

            return $count;
        } catch (\Throwable $e) {
            Log::error('[YouTubeSync] error: '.$e->getMessage(), ['workspace'=>$setting->workspace_id]);
            return 0;
        }
    }

    protected function fetchDetails(array $videoIds, string $apiKey): array
    {
        if (empty($videoIds)) return [];
        $resp = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'contentDetails,liveStreamingDetails',
            'id' => implode(',', $videoIds),
            'key' => $apiKey,
        ]);
        if (!$resp->ok()) return [];
        $map = [];
        foreach ($resp->json('items') ?? [] as $it) {
            $map[$it['id']] = $it;
        }
        return $map;
    }

    protected function upsertVideos(int $workspaceId, array $searchItems, array $details): int
    {
        $count = 0;
        foreach ($searchItems as $item) {
            $vid = $item['id']['videoId'] ?? null;
            if (!$vid) continue;
            $snip = $item['snippet'] ?? [];
            $det = $details[$vid] ?? [];
            $duration = $det['contentDetails']['duration'] ?? null;
            $liveContent = $snip['liveBroadcastContent'] ?? ($det['snippet']['liveBroadcastContent'] ?? null);
            $thumb = $snip['thumbnails']['high']['url'] ?? ($snip['thumbnails']['default']['url'] ?? null);
            YouTubeVideo::updateOrCreate([
                'workspace_id' => $workspaceId,
                'youtube_video_id' => $vid,
            ], [
                'channel_id' => $snip['channelId'] ?? null,
                'title' => $snip['title'] ?? '',
                'description' => $snip['description'] ?? null,
                'thumbnail_url' => $thumb,
                'duration' => $duration,
                'live_broadcast_content' => $liveContent,
                'published_at' => isset($snip['publishedAt']) ? \Carbon\Carbon::parse($snip['publishedAt']) : null,
                'raw_json' => json_encode(['search'=>$item,'details'=>$det]),
            ]);
            $count++;
        }
        return $count;
    }
}


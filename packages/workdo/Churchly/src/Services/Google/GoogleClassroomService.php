<?php

namespace Workdo\Churchly\Services\Google;

use Illuminate\Support\Facades\Http;
use Workdo\Churchly\Entities\UserGoogleAccount;

class GoogleClassroomService
{
    public static function ensureAccessToken(UserGoogleAccount $acct): ?string
    {
        if (!$acct->expires_at || $acct->expires_at->isPast()) {
            if (!$acct->refresh_token) return null;
            $resp = GoogleOAuth::refreshAccessToken($acct->workspace_id ?? getActiveWorkSpace(), $acct->refresh_token);
            if (!$resp) return null;
            $acct->access_token = $resp['access_token'];
            if (!empty($resp['expires_in'])) $acct->expires_at = now()->addSeconds((int)$resp['expires_in']);
            $acct->save();
        }
        return $acct->access_token;
    }

    public static function listCourses(string $accessToken): array
    {
        $resp = Http::withToken($accessToken)->get('https://classroom.googleapis.com/v1/courses');
        return $resp->ok() ? ($resp->json()['courses'] ?? []) : [];
    }

    public static function listStudents(string $accessToken, string $courseId): array
    {
        $resp = Http::withToken($accessToken)->get("https://classroom.googleapis.com/v1/courses/{$courseId}/students");
        return $resp->ok() ? ($resp->json()['students'] ?? []) : [];
    }

    public static function listTeachers(string $accessToken, string $courseId): array
    {
        $resp = Http::withToken($accessToken)->get("https://classroom.googleapis.com/v1/courses/{$courseId}/teachers");
        return $resp->ok() ? ($resp->json()['teachers'] ?? []) : [];
    }
}
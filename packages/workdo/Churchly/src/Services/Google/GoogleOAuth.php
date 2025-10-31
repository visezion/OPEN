<?php

namespace Workdo\Churchly\Services\Google;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Workdo\Churchly\Entities\{WorkspaceGoogleCredential, UserGoogleAccount};

class GoogleOAuth
{
    public const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    public const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    public const USERINFO_URL = 'https://openidconnect.googleapis.com/v1/userinfo';

    public static function scopes(): array
    {
        return [
            'openid','profile','email',
            'https://www.googleapis.com/auth/classroom.courses.readonly',
            'https://www.googleapis.com/auth/classroom.rosters',
            // future: drive, calendar
        ];
    }

    public static function getCredentials(int $workspaceId): array
    {
        $row = WorkspaceGoogleCredential::where('workspace_id',$workspaceId)->where('active',true)->first();
        return [
            'client_id' => $row->client_id ?? env('GOOGLE_CLIENT_ID'),
            'client_secret' => $row->client_secret ?? env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => $row->redirect_uri ?? env('GOOGLE_REDIRECT_URI'),
        ];
    }

    public static function buildAuthUrl(int $workspaceId, string $state): string
    {
        $creds = self::getCredentials($workspaceId);
        $params = [
            'client_id' => $creds['client_id'],
            'redirect_uri' => $creds['redirect_uri'],
            'response_type' => 'code',
            'scope' => implode(' ', self::scopes()),
            'access_type' => 'offline',
            'include_granted_scopes' => 'true',
            'state' => $state,
            'prompt' => 'consent',
        ];
        return self::AUTH_URL.'?'.http_build_query($params);
    }

    public static function exchangeCode(int $workspaceId, string $code): array
    {
        $creds = self::getCredentials($workspaceId);
        $resp = Http::asForm()->post(self::TOKEN_URL, [
            'code' => $code,
            'client_id' => $creds['client_id'],
            'client_secret' => $creds['client_secret'],
            'redirect_uri' => $creds['redirect_uri'],
            'grant_type' => 'authorization_code',
        ]);
        if (!$resp->ok()) {
            self::log('token_exchange_error', $resp->json());
            throw new \RuntimeException('Failed exchanging code for token');
        }
        return $resp->json();
    }

    public static function refreshAccessToken(int $workspaceId, string $refreshToken): ?array
    {
        $creds = self::getCredentials($workspaceId);
        $resp = Http::asForm()->post(self::TOKEN_URL, [
            'refresh_token' => $refreshToken,
            'client_id' => $creds['client_id'],
            'client_secret' => $creds['client_secret'],
            'grant_type' => 'refresh_token',
        ]);
        if ($resp->ok()) return $resp->json();
        self::log('token_refresh_error', $resp->json());
        return null;
    }

    public static function userInfo(string $accessToken): array
    {
        $resp = Http::withToken($accessToken)->get(self::USERINFO_URL);
        if (!$resp->ok()) throw new \RuntimeException('Failed to fetch user info');
        return $resp->json();
    }

    public static function verifyIdToken(string $idToken): array
    {
        $resp = Http::get('https://oauth2.googleapis.com/tokeninfo', ['id_token'=>$idToken]);
        if (!$resp->ok()) throw new \RuntimeException('Invalid ID token');
        return $resp->json();
    }

    public static function log(string $label, $data): void
    {
        try { file_put_contents(storage_path('logs/google.log'), date('c')." [${label}] ".json_encode($data)."\n", FILE_APPEND); } catch (\Throwable $e) { Log::error("google_log_write_error: ".$e->getMessage()); }
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClearLegacyCookies
{
    /**
     * Clear stale cookies from old path-scoped deployments (e.g. /OPEN).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $domain = config('session.domain');
        $activePath = config('session.path', '/');
        $activeSessionCookie = config('session.cookie');
        $protectedCookies = ['XSRF-TOKEN', $activeSessionCookie];
        $legacyPaths = ['/OPEN', '/open', '/'];
        $legacyCookies = array_filter(array_unique([
            'XSRF-TOKEN',
            'openzion_open_session',
            'openzion_open_session_v2',
            $activeSessionCookie,
        ]));
        // Never delete the currently active session cookie on alternate paths.
        $legacyCookies = array_values(array_filter(
            $legacyCookies,
            static fn (string $cookieName): bool => $cookieName !== $activeSessionCookie
        ));

        foreach ($legacyPaths as $path) {
            foreach ($legacyCookies as $cookieName) {
                if ($path === $activePath && in_array($cookieName, $protectedCookies, true)) {
                    continue;
                }
                $response->headers->setCookie(cookie()->forget($cookieName, $path, $domain));
            }
        }

        return $response;
    }
}

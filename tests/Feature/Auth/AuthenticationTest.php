<?php

namespace Tests\Feature\Auth;

use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_route_contract_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('login');

        $this->assertNotNull($route);
        $this->assertSame('login/{lang?}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('guest', $route->gatherMiddleware());
        $this->assertContains('domain-check', $route->gatherMiddleware());
    }

    public function test_login_submit_route_is_defined_as_post(): void
    {
        $route = $this->findRoute('POST', 'login');

        $this->assertNotNull($route);
    }

    public function test_logout_route_is_named_and_uses_post(): void
    {
        $route = Route::getRoutes()->getByName('logout');

        $this->assertNotNull($route);
        $this->assertSame('logout', $route->uri());
        $this->assertContains('POST', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
    }

    private function findRoute(string $method, string $uri): ?LaravelRoute
    {
        $method = strtoupper($method);
        foreach (Route::getRoutes() as $route) {
            if (in_array($method, $route->methods(), true) && $route->uri() === $uri) {
                return $route;
            }
        }

        return null;
    }
}

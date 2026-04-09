<?php

namespace Tests\Feature\Auth;

use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration_route_contract_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('register');

        $this->assertNotNull($route);
        $this->assertSame('register/{lang?}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('guest', $route->gatherMiddleware());
        $this->assertContains('domain-check', $route->gatherMiddleware());
    }

    public function test_registration_submit_route_is_defined_as_post(): void
    {
        $route = $this->findRoute('POST', 'register');

        $this->assertNotNull($route);
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

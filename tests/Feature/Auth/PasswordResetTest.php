<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_password_reset_request_route_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('password.request');

        $this->assertNotNull($route);
        $this->assertSame('forgot-password/{lang?}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('guest', $route->gatherMiddleware());
        $this->assertContains('domain-check', $route->gatherMiddleware());
    }

    public function test_password_reset_post_routes_are_defined(): void
    {
        $emailRoute = Route::getRoutes()->getByName('password.email');
        $storeRoute = Route::getRoutes()->getByName('password.store');

        $this->assertNotNull($emailRoute);
        $this->assertNotNull($storeRoute);
        $this->assertSame('forgot-password', $emailRoute->uri());
        $this->assertSame('reset-password', $storeRoute->uri());
        $this->assertContains('POST', $emailRoute->methods());
        $this->assertContains('POST', $storeRoute->methods());
    }

    public function test_password_reset_token_route_is_defined_as_get(): void
    {
        $route = Route::getRoutes()->getByName('password.reset');

        $this->assertNotNull($route);
        $this->assertSame('reset-password/{token}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('guest', $route->gatherMiddleware());
    }
}

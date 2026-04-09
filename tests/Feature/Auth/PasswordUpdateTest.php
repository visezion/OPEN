<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    public function test_password_update_route_is_defined_as_put(): void
    {
        $route = Route::getRoutes()->getByName('password.update');

        $this->assertNotNull($route);
        $this->assertSame('password', $route->uri());
        $this->assertContains('PUT', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
    }

    public function test_application_profile_password_change_route_is_defined_as_post(): void
    {
        $route = Route::getRoutes()->getByName('update.password');

        $this->assertNotNull($route);
        $this->assertSame('change-password', $route->uri());
        $this->assertContains('POST', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('verified', $route->gatherMiddleware());
    }
}

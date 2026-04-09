<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_profile_route_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('profile');

        $this->assertNotNull($route);
        $this->assertSame('profile', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('verified', $route->gatherMiddleware());
    }

    public function test_profile_update_route_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('edit.profile');

        $this->assertNotNull($route);
        $this->assertSame('edit-profile', $route->uri());
        $this->assertContains('POST', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('verified', $route->gatherMiddleware());
    }

    public function test_user_reset_password_route_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('users.reset');

        $this->assertNotNull($route);
        $this->assertSame('user-reset-password/{id}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('POST', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('verified', $route->gatherMiddleware());
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    public function test_password_confirmation_get_route_is_defined(): void
    {
        $route = Route::getRoutes()->getByName('password.confirm');

        $this->assertNotNull($route);
        $this->assertSame('confirm-password', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
    }

    public function test_password_confirmation_post_route_is_defined(): void
    {
        $route = collect(Route::getRoutes())->first(function ($route) {
            return in_array('POST', $route->methods(), true) && $route->uri() === 'confirm-password';
        });

        $this->assertNotNull($route);
        $this->assertContains('auth', $route->gatherMiddleware());
    }
}

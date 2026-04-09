<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    public function test_email_verification_notice_route_matches_application_structure(): void
    {
        $route = Route::getRoutes()->getByName('verification.notice');

        $this->assertNotNull($route);
        $this->assertSame('verify-email/{lang?}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('domain-check', $route->gatherMiddleware());
    }

    public function test_email_verification_link_route_is_signed_and_throttled(): void
    {
        $route = Route::getRoutes()->getByName('verification.verify');

        $this->assertNotNull($route);
        $this->assertSame('verify-email/{id}/{hash}', $route->uri());
        $this->assertContains('GET', $route->methods());
        $this->assertContains('auth', $route->gatherMiddleware());
        $this->assertContains('signed', $route->gatherMiddleware());
        $this->assertContains('throttle:6,1', $route->gatherMiddleware());
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_landing_route_is_defined(): void
    {
        $route = Route::getRoutes()->getByName('home.landing');

        $this->assertNotNull($route);
        $this->assertSame('/', $route->uri());
        $this->assertContains('GET', $route->methods());
    }
}

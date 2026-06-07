<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class PasswordResetConfigurationTest extends TestCase
{
    public function test_password_brokers_use_the_reset_token_table(): void
    {
        $this->assertSame('password_reset_tokens', config('auth.passwords.users.table'));
        $this->assertSame('password_reset_tokens', config('auth.passwords.customers.table'));
        $this->assertSame('password_reset_tokens', config('auth.passwords.holiday.table'));
    }

    public function test_auth_layout_exposes_the_csrf_meta_token_for_keepalive_refresh(): void
    {
        $layout = file_get_contents(resource_path('views/layouts/auth.blade.php'));

        $this->assertIsString($layout);
        $this->assertStringContainsString('<meta name="csrf-token" content="{{ csrf_token() }}">', $layout);
        $this->assertStringContainsString("@include('partials.csrf-keepalive')", $layout);
    }
}

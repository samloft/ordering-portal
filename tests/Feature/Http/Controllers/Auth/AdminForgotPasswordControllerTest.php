<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Auth\AdminForgotPasswordController
 */
class AdminForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show_link_request_form_returns_an_ok_response(): void
    {
        $response = $this->get(route('cms.forgot-password'));

        $response->assertOk();
        $response->assertViewIs('authentication.passwords.email');
    }
}

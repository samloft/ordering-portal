<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Auth\AdminController
 */
class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function login_returns_an_ok_response(): void
    {
        factory(Admin::class)->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('cms.login.submit'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect((route('cms.index')));
    }

    /**
     * @test
     */
    public function logout_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.logout'));

        $response->assertRedirect('/cms');
    }

    /**
     * @test
     */
    public function show_login_form_returns_an_ok_response(): void
    {
        $response = $this->get(route('cms.login'));

        $response->assertOk();
        $response->assertViewIs('authentication.login');
    }
}

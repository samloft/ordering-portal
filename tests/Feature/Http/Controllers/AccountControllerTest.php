<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('account'));

        $response->assertOk();
        $response->assertViewIs('account.index');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->post(route('account.store'), [
            'name' => 'Test User',
            'mobile' => '12345',
            'password' => null,
            'password_confirmation' => null,
        ]);

        $response->assertStatus(302);
    }
}

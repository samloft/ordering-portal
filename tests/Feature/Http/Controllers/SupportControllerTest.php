<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SupportController
 */
class SupportControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('support.data'));

        $response->assertOk();
        $response->assertViewIs('support.index');
        $response->assertViewHas('support');
    }
}

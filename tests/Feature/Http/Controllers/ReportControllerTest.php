<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReportController
 */
class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('reports'));

        $response->assertOk();
        $response->assertViewIs('reports.index');
    }
}

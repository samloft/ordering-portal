<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UploadController
 */
class UploadControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('upload'));

        $response->assertOk();
        $response->assertViewIs('upload.index');
        $response->assertViewHas('config');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $response = $this->actingAs($user)->get(route('upload-completed'));

        $response->assertOk();
        $response->assertViewIs('upload.completed');
        $response->assertViewHas('upload');
    }
}

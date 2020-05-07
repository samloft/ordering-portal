<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\AdminController
 */
class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $admin = factory(Admin::class)->create();
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->delete(route('cms.admin-users.destroy', ['id' => $user->id]));

        $response->assertOk();
        $this->assertDeleted($user);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.admin-users'));

        $response->assertOk();
        $response->assertViewIs('admin-users.index');
        $response->assertViewHas('users');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        Mail::fake();

        $response = $this->actingAs($user, 'admin')->post(route('cms.admin-users.store'), [
            'name' => 'Example user',
            'email' => 'example@example.com',
        ]);

        $response->assertCreated();
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->patch(route('cms.admin-users.update', ['id' => $admin->id]), [
            'name' => 'New name',
        ]);

        $response->assertOk();
    }
}

<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\UserController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $site_user = factory(User::class)->create();

        $response = $this->actingAs($user, 'admin')->delete(route('cms.site-users.destroy', ['id' => $site_user->id]));

        $response->assertOk();
        $this->assertDeleted($site_user);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.site-users'));

        $response->assertOk();
        $response->assertViewIs('site-users.index');
        $response->assertViewHas('site_users');
    }

    /**
     * @test
     */
    public function password_reset_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $site_user = factory(User::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.site-users.password-reset'), [
            'email' => $site_user->email,
        ]);

        $response->assertOk();
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();
        $customer = factory(Customer::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.site-users.store'), [
            'name' => 'Test User',
            'email' => 'example@example.com',
            'customer_code' => $customer->code,
        ]);

        $response->assertCreated();
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $site_user = factory(User::class)->create();

        $response = $this->actingAs($user, 'admin')->patch(route('cms.site-users.update', ['id' => $site_user->id]), [
            'name' => 'Updated Name',
        ]);

        $response->assertRedirect();
    }
}

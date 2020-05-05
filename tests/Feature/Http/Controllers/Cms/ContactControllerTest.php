<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\ContactController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $contact = factory(Contact::class)->create();

        $response = $this->actingAs($user, 'admin')->delete(route('cms.contacts.delete', [$contact]));

        $response->assertOk();
        $this->assertDeleted($contact);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.contacts'));

        $response->assertOk();
        $response->assertViewIs('contacts.index');
        $response->assertViewHas('contacts');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.contacts.store'), [
            'name' => 'Test Contact',
            'email' => 'example@example.com',
        ]);

        $response->assertOk();
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $contact = factory(Contact::class)->create();

        $response = $this->actingAs($user, 'admin')->patch(route('cms.contacts.update', [$contact]), [
                'name' => 'Updated Contact',
            ]);

        $response->assertRedirect();
    }
}

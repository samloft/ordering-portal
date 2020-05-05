<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        factory(Contact::class)->create();

        $response = $this->actingAs($user)->get(route('contact'));

        $response->assertOk();
        $response->assertViewIs('contact.index');
        $response->assertViewHas('contacts');
        $response->assertViewHas('map');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $contact = factory(Contact::class)->create();

        $response = $this->actingAs($user)->post(route('contact.email'), [
            'to' => $contact->email,
            'name' => $contact->name,
            'email' => $user->email,
            'message' => 'Testing',
        ]);

        $response->assertRedirect();
    }
}

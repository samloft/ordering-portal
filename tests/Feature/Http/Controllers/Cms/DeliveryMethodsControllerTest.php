<?php

namespace Tests\Feature\Http\Controllers\Cms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\DeliveryMethodsController
 */
class DeliveryMethodsControllerTest extends TestCase
{
    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $delivery_method = factory(\App\Models\DeliveryMethod::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user, 'admin')->delete(route('cms.delivery-methods.delete', ['deliveryMethod' => $delivery_method->deliveryMethod]));

        $response->assertOk();
        $this->assertDeleted($cms);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.delivery-methods'));

        $response->assertOk();
        $response->assertViewIs('delivery-methods.index');
        $response->assertViewHas('delivery_methods');
        $response->assertViewHas('collection_messages');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.delivery-methods.store'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_collection_message_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.collection-messages.store'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    // test cases...
}
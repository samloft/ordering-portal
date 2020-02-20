<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class BasketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_customer_can_empty_the_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new BasketFactory())->create();

        $this->post(route('basket.empty'));

        foreach ($products as $product) {
            $this->assertDatabaseMissing('basket', [
                'customer_code' => $user->customer->code,
                'user_id' => $user->id,
                'product' => $product->code,
                'reference' => 'test-basket',
            ]);
        }
    }
}

<?php

namespace Tests\Feature;

use App\Models\DeliveryMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\BasketFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_that_cannot_order_cannot_checkout(): void
    {
        $user = (new UserFactory())->withCustomer()->create([
            'can_order' => false,
        ]);

        $this->signIn($user);

        (new BasketFactory())->create();

        $this->get(route('checkout'))->assertRedirect(route('basket'));
    }

    /**
     * @test
     */
    public function a_user_cannot_checkout_with_no_product_lines(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->get(route('checkout'))->assertRedirect(route('basket'));
    }

    /**
     * @test
     */
    public function a_user_must_provide_a_delivery_address(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        (new BasketFactory())->create();

        $shipping = factory(DeliveryMethod::class, 1)->create()->first();

        $this->post(route('checkout.order', [
            'reference' => 'test',
            'name' => $user->name,
            'shipping' => $shipping->code,
            'terms' => 'on',
        ]))->assertRedirect();
    }
}

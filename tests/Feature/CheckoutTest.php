<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Basket;
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
    public function a_user_cannot_checkout_without_a_valid_delivery_method(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        factory(Basket::class, 5)->create()->first();

        (new BasketFactory())->create();

        $this->post(route('checkout.order', [
            'reference' => 'test',
            'name' => $user->name,
            'shipping' => 'ABC',
            'terms' => 'on',
        ]))->assertSessionHasErrors('shipping');
    }

    /**
     * @test
     */
    public function a_user_must_accept_terms(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        factory(Basket::class, 5)->create()->first();

        (new BasketFactory())->create();

        $this->post(route('checkout.order', [
            'reference' => 'test',
            'name' => $user->name,
            'shipping' => 'ABC',
        ]))->assertSessionHasErrors('terms');
    }

    /**
     * @test
     */
    public function a_user_must_provide_a_delivery_address(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        factory(Basket::class, 5)->create()->first();

        (new BasketFactory())->create();

        $this->post(route('checkout.order', [
            'reference' => 'test',
            'name' => $user->name,
            'shipping' => 'ABC',
        ]))->assertSessionHasErrors('terms');

        $address = factory(Address::class, 1)->create()->first();

        session([
            'address' => [
                'address_id' => $address->id,
                'address_details' => [
                    'company_name' => $address->company_name,
                    'address_2' => $address->address_line_2,
                    'address_3' => $address->address_line_3,
                    'address_4' => $address->address_line_4,
                    'address_5' => $address->address_line_5,
                    'postcode' => $address->post_code,
                ],
            ],
        ]);

        $shipping = factory(DeliveryMethod::class, 1)->create()->first();

        $this->post(route('checkout.order', [
            'reference' => 'test',
            'name' => $user->name,
            'shipping' => $shipping->code,
            'terms' => 'on'
        ]))->assertSee('Order Completed');
    }
}

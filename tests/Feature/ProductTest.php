<?php

namespace Tests\Feature;

use App\Models\CustomerDiscount;
use App\Models\ExpectedStock;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that a customer can see a product on their price list.
     *
     * @test
     */
    public function a_customer_can_see_products_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->get($product->path())->assertSee($product->description);
    }

    /**
     * Check a customer cannot see a product not on their price list.
     *
     * @test
     */
    public function a_customer_cannot_see_products_not_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => 'ABC123',
            'product' => $product->code,
        ]);

        $this->get($product->path())->assertDontSee($product->description);
    }

    /**
     * @test
     */
    public function a_customer_can_search_for_a_product_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->get(route('products.search', ['query' => $product->code]))->assertSee($product->code)->assertSee($product->description);
    }

    /**
     * @test
     */
    public function a_customer_cannot_search_for_a_product_on_their_price_list(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => 'ABC123',
            'product' => $product->code,
        ]);

        $this->get(route('products.search', ['query' => $product->code]))->assertDontSee($product->description);
    }

    /**
     * @test
     */
    public function expected_stock_table_is_shown_if_entries_for_product(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        factory(ExpectedStock::class)->create([
            'product' => $product->code,
            'quantity' => 1000,
        ]);

        $this->get(route('products.show', ['product' => $product->code]))->assertSee('Expected Stock');
    }

    /**
     * @test
     */
    public function expected_stock_table_is_hidden_if_no_entries_for_product(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->get(route('products.show', ['product' => $product->code]))->assertDontSee('Expected Stock');
    }

    /**
     * @test
     */
    public function discount_not_shown_if_customer_has_no_discount(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        factory(CustomerDiscount::class)->create([
            'customer_code' => $user->customer->code,
            'percent' => 0,
        ]);

        $this->get(route('products.show', ['product' => $product->code]))->assertDontSee('Discount');
    }

    /**
     * @test
     */
    public function discount_shown_if_customer_has_discount(): void
    {
        $user = (new UserFactory())->withCustomer()->withDiscount(2)->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $this->get(route('products.show', ['product' => $product->code]))->assertSee('Discount')
        ->assertSee('2.0%');
    }
}

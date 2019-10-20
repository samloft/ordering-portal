<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use Tests\Setup\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that a user can see a category if it contains a product on their price list.
     *
     * @test
     */
    public function a_user_can_see_a_category_if_it_has_products_on_price_list(): void
    {
        $user = (new UserFactory)->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => $user->customer->code,
            'product' => $product->code,
        ]);

        $category = factory(Category::class)->create([
            'product' => $product->code,
        ]);

        $this->get('/products')->assertSee(strtoupper($category->level_1));
    }

    /**
     * Check that a user cannot see a category if it contains products not on their price list.
     *
     * @test
     */
    public function a_user_cannot_see_a_category_if_no_products_on_price_list(): void
    {
        $user = (new UserFactory)->withCustomer()->create();

        $this->signIn($user);

        $product = factory(Product::class)->create();

        factory(Price::class)->create([
            'customer_code' => 'ABC123',
            'product' => $product->code,
        ]);

        $category = factory(Category::class)->create([
            'product' => $product->code,
        ]);

        $this->get('/products')->assertDontSee(strtoupper($category->level_1));
    }
}

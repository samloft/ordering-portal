<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\Setup\ProductFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class OrderUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_csv_file_needs_valid_contents(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->post(route('upload-validate', ['csv_file' => $file = UploadedFile::fake()->createwithContent('test.csv', 'PRODUCT, 200')]))->assertStatus(302)->assertSessionHasErrors('csv_file');
    }

    /**
     * @test
     */
    public function a_valid_csv_file_works(): void
    {
        $this->withoutExceptionHandling();

        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new ProductFactory())->withPrices($user->customer->code)->create();

        $this->post(route('upload-validate'), ['csv_file' => $file = UploadedFile::fake()->createwithContent('test.csv', $products->first()->code.',200')])->assertStatus(200);
    }

    /**
     * @test
     */
    public function uploaded_products_get_added_to_basket(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new ProductFactory())->withPrices($user->customer->code)->create();

        $this->post(route('upload-validate'), ['csv_file' => $file = UploadedFile::fake()->createwithContent('test.csv', $products->first()->code.',200')]);

        $this->get(route('upload-completed'));

        $this->assertDatabaseHas('basket', [
            'user_id' => $user->id,
            'customer_code' => $user->customer->code,
            'product' => $products->first()->code,
            'quantity' => 200,
        ]);
    }

    /**
     * @test
     */
    public function upload_with_prices_shows_price_match(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $products = (new ProductFactory())->withPrices($user->customer->code)->create();

        $this->post(route('upload-validate'), ['csv_file' => $file = UploadedFile::fake()->createwithContent('test.csv', $products->first()->code.',200,2.24')])->assertStatus(200)->assertSee('Passed Price');
    }
}

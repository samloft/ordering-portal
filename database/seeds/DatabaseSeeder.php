<?php

use App\Models\Address;
use App\Models\CmsUser;
use App\Models\ExpectedStock;
use App\Models\OrderTracking\Header;
use App\Models\OrderTracking\Lines;
use App\Models\User;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Price;
use App\Models\Product;
use App\Models\Stock;
use App\Models\UserCustomer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         //$this->call(CountriesTableSeeder::class);

        $user = factory(User::class)->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password'),
            'customer_code' => 'SCO100'
        ]);

        factory(Customer::class)->create(['code' => 'SCO100']);
        factory(Customer::class)->create(['code' => 'SCO200']);

        factory(UserCustomer::class)->create(['user_id' => $user->id, 'customer_code' => 'SCO200']);

        factory(Address::class, 10)->create(['user_id' => $user->id, 'customer_code' => 'SCO100']);
        factory(Address::class, 10)->create(['user_id' => $user->id, 'customer_code' => 'SCO200']);

        factory(Product::class, 500)->create()->each(static function ($product) {
            factory(Price::class)->create(['product' => $product->code]);
            factory(Category::class)->create(['product' => $product->code]);
            factory(Stock::class)->create(['product' => $product->code]);
            factory(ExpectedStock::class)->create(['product' => $product->code]);
        });

        factory(CmsUser::class)->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password')
        ]);

        factory(Header::class, 200)->create()->each(static function ($order) {
            factory(Lines::class)->create([
                'order_no' => $order->order_no
            ]);
        });
    }
}

<?php

namespace Tests\Setup;

use App\Models\Basket;

class BasketFactory
{
    /**
     * @param $customer
     *
     * @return mixed
     */
    public function create($customer = null)
    {
        $products = (new ProductFactory())->withPrices(auth()->user()->customer->code)->create();

        foreach ($products as $product) {
            factory(Basket::class)->create([
                'user_id' => auth()->id(),
                'customer_code' => $customer ?? auth()->user()->customer->code,
                'product' => $product->code,
            ]);
        }

        return $products;
    }
}

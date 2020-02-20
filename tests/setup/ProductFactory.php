<?php

namespace Tests\Setup;

use App\Models\Price;
use App\Models\Product;

class ProductFactory
{
    protected $customer;

    protected $prices = false;

    /**
     * @param null $customer
     *
     * @return $this
     */
    public function withPrices($customer = null): self
    {
        $this->customer = $customer;
        $this->prices = true;

        return $this;
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function create($attributes = [])
    {
        $products = factory(Product::class, 10)->create($attributes);

        if ($this->prices) {
            foreach ($products as $product) {
                factory(Price::class)->create([
                    'customer_code' => $this->customer,
                    'product' => $product->code,
                ]);
            }
        }

        return $products;
    }
}

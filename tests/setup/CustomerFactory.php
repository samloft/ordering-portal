<?php

namespace Tests\Setup;

use App\Models\Customer;

class CustomerFactory
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = [])
    {
        return factory(Customer::class)->create($attributes);
    }
}

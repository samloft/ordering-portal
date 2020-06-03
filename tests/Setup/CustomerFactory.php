<?php

namespace Tests\Setup;

use App\Models\Customer;

class CustomerFactory
{
    protected $count = 0;

    public function __construct($count = 1)
    {
        $this->count = $count;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        return factory(Customer::class, $this->count)->create($attributes);
    }
}

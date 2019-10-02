<?php

namespace Tests\Setup;

use App\Models\User;
use App\Models\Customer;

class UserFactory
{
    protected $customer = 0;

    /**
     * @return $this
     */
    public function withCustomer(): self
    {
        $this->customer = 1;

        return $this;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create($attributes = [])
    {
        $user = factory(User::class)->create($attributes);

        factory(Customer::class, $this->customer)->create([
            'customer_code' => $user->customer_code,
        ]);

        return $user;
    }
}

<?php

namespace Tests\Setup;

use App\Models\Customer;
use App\Models\CustomerDiscount;
use App\Models\User;
use App\Models\UserCustomer;

class UserFactory
{
    protected $customer = 0;

    protected $user_customers;

    protected $discount = false;

    /**
     * @return $this
     */
    public function withCustomer(): self
    {
        $this->customer = 1;

        return $this;
    }

    public function withUserCustomers($count = 0): self
    {
        $this->user_customers = $count;

        return $this;
    }

    public function withDiscount($discount = 0)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes = [])
    {
        $user = factory(User::class)->create($attributes);

        factory(Customer::class, $this->customer)->create([
            'code' => $user->customer_code,
        ]);

        if ($this->user_customers) {
            for ($count = 1; $count <= $this->user_customers; $count++) {
                $customer = factory(Customer::class)->create([
                    'code' => str_random(8),
                ]);

                factory(UserCustomer::class)->create([
                    'user_id' => $user->id,
                    'customer_code' => $customer->code,
                ]);
            }
        }

        if ($this->discount) {
            factory(CustomerDiscount::class)->create([
                'customer_code' => $user->customer_code,
                'percent' => $this->discount,
            ]);
        }

        return $user;
    }
}

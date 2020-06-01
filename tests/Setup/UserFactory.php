<?php

namespace Tests\Setup;

use App\Models\Customer;
use App\Models\CustomerDiscount;
use App\Models\User;
use App\Models\UserCustomer;

class UserFactory
{
    protected $customer = 0;

    protected $customer_attributes;

    protected $user_customers;

    protected $discount = false;

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function withCustomer($attributes = []): self
    {
        $this->customer = 1;

        $this->customer_attributes = $attributes;

        return $this;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function withUserCustomers($count = 0): self
    {
        $this->user_customers = $count;

        return $this;
    }

    /**
     * @param int $discount
     *
     * @return $this
     */
    public function withDiscount($discount = 0): self
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

        factory(Customer::class, $this->customer)->create($this->customer_attributes ?: [
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

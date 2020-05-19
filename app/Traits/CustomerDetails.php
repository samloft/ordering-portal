<?php

namespace App\Traits;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Session;

trait CustomerDetails
{
    /** @var Customer */
    protected $current_customer;

    /**
     * @return \App\Models\Customer|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getCustomerAttribute()
    {
        if ($this->current_customer) {
            return $this->current_customer;
        }

        return $this->current_customer = Customer::where('code', Session::get('temp_customer') ?: auth()->user()->customer_code)->first();
    }
}

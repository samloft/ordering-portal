<?php

namespace App\Traits;

use App\Models\Customer;
use Session;
use Auth;

trait CustomerDetails
{
    /** @var Customer */
    protected $current_customer;

    /**
     * @return \App\Models\Customer|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getCustomerAttribute()
    {
        if ($current_customer = $this->current_customer) {
            return $current_customer;
        }

        if (Session::get('temp_customer')) {
            return $this->current_customer = Customer::where('code', Session::get('temp_customer'))->first();
        }

        return $this->current_customer = Customer::where('code', Auth::user()->customer_code)->first();
    }
}

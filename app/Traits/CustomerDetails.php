<?php

namespace App\Traits;

use App\Models\Customer;
use Session;
use Auth;

trait CustomerDetails
{
    /** @var Customer */
    protected $currentCustomer;

    public function getCustomerAttribute()
    {
        if ($currentCustomer = $this->currentCustomer) {
            return $currentCustomer;
        }

        if (Session::get('temp_customer')) {
            return $this->currentCustomer = Customer::where('customer_code', Session::get('temp_customer'))->first();
        }

        return $this->currentCustomer = Customer::where('customer_code', Auth::user()->customer_code)->first();
    }
}

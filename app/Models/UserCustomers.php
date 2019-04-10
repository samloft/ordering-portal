<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class UserCustomers extends Model
{
    /**
     * Check that a user has access to a customer.
     *
     * @param $customer_code
     * @return mixed
     */
    public static function check($customer_code)
    {
        return (new UserCustomers)->where('customer_code', $customer_code)
            ->where('user_id', Auth::user()->id)->first();
    }
}

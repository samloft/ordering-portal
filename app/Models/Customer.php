<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @mixin Eloquent
 */
class Customer extends Model
{
    protected $primaryKey = 'customer_code';
    public $incrementing = false;

    /**
     * Get customer details for the given customer code.
     *
     * @param $customer_code
     * @return Builder|Model|object|null
     */
    public static function show($customer_code)
    {
        return (new Customer)->where('customer_code', $customer_code)->first();
    }
}

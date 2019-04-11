<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Request;

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

    /**
     * Autocomplete for customer input.
     *
     * @param $customer_search
     * @return Customer
     */
    public static function autocomplete($customer_search)
    {
        if (Auth::user()->admin) {
            return (new Customer)->select(['customer_code', 'customer_name'])
                ->whereRaw('UPPER(customer_code) like \'' . $customer_search . '%\'')
                ->orderBy('customer_code', 'asc')
                ->limit(10)
                ->get();
        }

        return response()->json('Access Denied', 500);
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\Addresses
 *
 * @mixin Eloquent
 */
class AccountSummary extends Model
{
    protected $table = 'account_summary';

    /**
     * Get all the outstanding orders for a customers account.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        return (new AccountSummary)->where('customer_code', Auth::user()->customer->customer_code)
            ->orderBy('due_date', 'desc')->orderBy('item_no', 'desc')
            ->get();
    }

    /**
     * Get the summary values for a customers account.
     *
     * @return AccountSummary[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function summary()
    {
        return (new AccountSummary)->selectRaw('SUM(unall_curr_amount) AS price, age')
            ->where('customer_code', Auth::user()->customer->customer_code)
            ->groupBy('age')
            ->get();
    }
}

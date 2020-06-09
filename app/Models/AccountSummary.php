<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * App\Models\AccountSummary.
 *
 * @mixin Eloquent
 * @property string $customer_code
 * @property string $item_no
 * @property string $reference
 * @property \Illuminate\Support\Carbon $dated
 * @property \Illuminate\Support\Carbon $due_date
 * @property float $unall_curr_amount
 * @property string $age
 */
class AccountSummary extends Model
{
    protected $table = 'account_summary';

    public $timestamps = false;

    /**
     * Get all the outstanding orders for a customers account.
     * Limited to 320 due to slowness in DomPDF.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        return self::where('customer_code', auth()->user()->customer->code)->orderBy('due_date', 'desc')
            ->orderBy('item_no', 'desc')->limit(320)->get();
    }

    /**
     * Get the summary values for a customers account.
     *
     * @return AccountSummary[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Builder[]|Collection
     */
    public static function summary()
    {
        return self::selectRaw('SUM(unall_curr_amount) AS price, age')
            ->where('customer_code', auth()->user()->customer->code)->groupBy('age')->get();
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Customer.
 *
 * @mixin Eloquent
 */
class Customer extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(CustomerDiscount::class, 'code', 'customer_code');
    }

    /**
     * Get customer details for the given customer code.
     *
     * @param $customer_code
     *
     * @return Builder|Model|object|null
     */
    public static function show($customer_code)
    {
        return self::where('code', $customer_code)->first();
    }

    /**
     * Autocomplete for customer input.
     *
     * @param $customer_search
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Support\Collection
     */
    public static function autocomplete($customer_search)
    {
        if (auth()->user()->admin) {
            return self::select([
                'code',
                'name',
            ])->whereRaw('UPPER(code) like \''.$customer_search.'%\'')->orderBy('code')->limit(10)->get();
        }

        return response()->json('Access Denied', 401);
    }
}

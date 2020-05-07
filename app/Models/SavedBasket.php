<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SavedBasket.
 *
 * @mixin \Eloquent
 * @property string $customer_code
 * @property int $user_id
 * @property string $reference
 * @property string $product
 * @property int $quantity
 * @property \Illuminate\Support\Carbon $created_at
 */
class SavedBasket extends Model
{
    public $timestamps = [];

    /**
     * Return the results for the customers saved baskets, with optional search.
     *
     * @param $search
     * @param $request
     *
     * @return mixed
     */
    public static function list($search, $request)
    {
        if ($search) {
            return self::select([
                'reference',
                'created_at',
            ])->where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->id())->where(static function ($query
            ) use ($request) {
                if ($request['reference']) {
                    $query->where('reference', 'like', '%'.$request['reference'].'%');
                }

                if ($request['date_from']) {
                    $date_from = Carbon::createFromFormat('d/m/Y', $request['date_from'])->format('Y-m-d');

                    $query->where('created_at', '>=', $date_from);
                }

                if ($request['date_to']) {
                    $date_to = Carbon::createFromFormat('d/m/Y', $request['date_to'])->format('Y-m-d');

                    $query->where('created_at', '<=', $date_to);
                }
            })->groupBy(['reference', 'created_at'])->paginate(10);
        }

        return self::select([
            'reference',
            'created_at',
        ])->where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->id())->groupBy([
            'reference',
            'created_at',
        ])->paginate(10);
    }

    /**
     * Get the items for a saved basket by ID.
     *
     * @param $reference
     *
     * @return mixed
     */
    public static function show($reference)
    {
        return self::select([
            'saved_baskets.product',
            'name',
            'quantity',
            'reference',
            'prices.price',
            'created_at',
        ])->where('saved_baskets.customer_code', auth()->user()->customer->code)->where('user_id', auth()->id())->where('reference', $reference)
            ->leftJoin('products', 'products.code', 'saved_baskets.product')->leftJoin('prices', static function (
                $join
            ) {
                $join->on('prices.product', 'saved_baskets.product');
                $join->where('prices.customer_code', auth()->user()->customer->code);
            })->get();
    }

    /**
     * Add the array of items as a saved basket.
     *
     * @param $items
     *
     * @return bool
     */
    public static function store($items): bool
    {
        return self::insert($items);
    }

    /**
     * Delete the saved basket by reference.
     *
     * @param $reference
     *
     * @return int
     */
    public static function destroy($reference): int
    {
        return self::where('customer_code', auth()->user()->customer->code)->where('user_id', auth()->id())
            ->where('reference', $reference)->delete();
    }
}

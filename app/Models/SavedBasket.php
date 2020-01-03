<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SavedBasket.
 *
 * @mixin Eloquent
 */
class SavedBasket extends Model
{
    public $incrementing = false;
    public $timestamps = [];

    /**
     * Return the results for the customers saved baskets.
     *
     * @param $search
     * @param $request
     *
     * @return mixed
     */
    public static function list($search, $request)
    {
        if ($search) {
            return self::select(['id', 'reference', 'created_at'])
                ->where('customer_code', auth()->user()->customer->code)
                ->when($request, static function ($query) use ($request) {
                    if ($request->reference) {
                        $query->where('reference', 'like', '%'.$request->reference.'%');
                    }

                    if ($request->date_from) {
                        $date_from = Carbon::createFromFormat('d/m/Y', $request->date_from)->format('Y-m-d');

                        $query->where('created_at', '>=', $date_from);
                    }

                    if ($request->date_to) {
                        $date_to = Carbon::createFromFormat('d/m/Y', $request->date_to)->format('Y-m-d');

                        $query->where('created_at', '<=', $date_to);
                    }
                })
                ->groupBy(['id', 'reference', 'created_at'])
                ->paginate(10);
        }

        return self::select(['id', 'reference', 'created_at'])
            ->where('customer_code', auth()->user()->customer->code)
            ->groupBy(['id', 'reference', 'created_at'])
            ->paginate(10);
    }

    /**
     * Get the items for a saved basket by ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function show($id)
    {
        return self::select(['saved_baskets.product', 'name', 'quantity', 'id', 'reference', 'prices.price', 'created_at'])
            ->where('saved_baskets.customer_code', auth()->user()->customer->code)
            ->where('id', $id)
            ->leftJoin('products', 'products.code', 'saved_baskets.product')
            ->leftJoin('prices', static function ($join) {
                $join->on('prices.product', 'saved_baskets.product');
                $join->where('prices.customer_code', auth()->user()->customer->code);
            })
            ->get();
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
     * @param $id
     *
     * @return int
     */
    public static function destroy($id): int
    {
        return self::where('customer_code', auth()->user()->customer->code)
            ->where('id', $id)
            ->delete();
    }
}

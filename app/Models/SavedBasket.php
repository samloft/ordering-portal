<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Models\Products
 *
 * @mixin Eloquent
 */
class SavedBasket extends Model
{
    protected $table = 'saved_basket';
    public $incrementing = false;
    public $timestamps = [];

    /**
     * Return the results for the customers saved baskets.
     *
     * @param $search
     * @param $request
     * @return mixed
     */
    public static function list($search, $request)
    {
        if ($search) {
            return (new SavedBasket)->select('id', 'reference', 'created_at')
                ->where('customer_code', Auth::user()->customer->customer_code)
                ->when($request, function ($query) use ($request) {
                    if ($request->reference) {
                        $query->where('reference', 'like', '%' . $request->reference . '%');
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

        return (new SavedBasket)->select('id', 'reference', 'created_at')
            ->where('customer_code', Auth::user()->customer->customer_code)
            ->groupBy(['id', 'reference', 'created_at'])
            ->paginate(10);
    }

    /**
     * Get the items for a saved basket by ID.
     *
     * @param $id
     * @return mixed
     */
    public static function show($id)
    {
        return (new SavedBasket)->select('saved_basket.product', 'name', 'quantity', 'id', 'reference', 'prices.price', 'created_at')
            ->where('saved_basket.customer_code', Auth::user()->customer->customer_code)
            ->where('id', $id)
            ->leftJoin('products', 'products.product', 'saved_basket.product')
            ->leftJoin('prices', function ($join) {
                $join->on('prices.product', 'saved_basket.product');
                $join->where('prices.customer_code', Auth::user()->customer->customer_code);
            })
            ->get();
    }

    /**
     * Add the array of items as a saved basket.
     *
     * @param $items
     * @return bool
     */
    public static function store($items)
    {
        return (new SavedBasket)->insert($items);
    }

    /**
     * Delete the saved basket by reference.
     *
     * @param $id
     * @return int
     */
    public static function destroy($id)
    {
        return (new SavedBasket)->where('customer_code', Auth::user()->customer->customer_code)
            ->where('id', $id)
            ->delete();
    }
}

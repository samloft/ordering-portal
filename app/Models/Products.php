<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

/**
 * App\Models\Products
 *
 * @mixin \Eloquent
 */
class Products extends Model
{
    protected $table = 'products';

    /**
     * @return HasMany
     */
    public function prices()
    {
        return $this->belongsTo(Prices::class, 'product', 'product')->where('customer_code', Auth::user()->customer->customer_code);
    }

    /**
     * @return BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'product', 'product');
    }

    /**
     * @return BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'product', 'product');
    }

    /**
     * Return all products for the given categories.
     *
     * @param $categories
     * @return mixed
     */
    public static function list($categories)
    {
        $products = (new Products)->whereHas('prices')
            ->whereHas('categories', function ($query) use ($categories) {
                $query->where('cat1_level1', ($categories['level_1']))
                    ->where('cat1_level2', $categories['level_2'])
                    ->where('cat1_level3', $categories['level_3']);
            })
            ->join('prices', 'products.product', '=', 'prices.product')
            ->join('stock_levels', 'products.product', '=', 'stock_levels.product')
            ->where('prices.customer_code', Auth::user()->customer->customer_code)
            ->paginate(10);

        return $products;
    }

    /**
     * Get data for the given product code.
     *
     * @param $product_code
     * @return mixed
     */
    public static function show($product_code)
    {
        return (new Products)->select(['products.product', 'name', 'description', 'uom', 'price', 'quantity', 'order_multiples'])
            ->whereHas('prices')
            ->where('products.product', $product_code)
            ->leftJoin('prices', 'prices.product', 'products.product')
            ->leftJoin('stock_levels', 'stock_levels.product', 'products.product')
            ->first();
    }

    /**
     * Take the search parameter and search on multiple columns.
     *
     * @param $search_term
     * @return mixed
     */
    public static function search($search_term)
    {
        return (new Products)->whereHas('prices')
            ->where(function ($query) use ($search_term) {
                $query->whereRaw('upper(products.product) LIKE \'%' . strtoupper($search_term) . '%\'')
                    ->orWhereRaw('upper(name) LIKE \'%' . strtoupper($search_term) . '%\'')
                    ->orWhereRaw('upper(description) LIKE \'%' . strtoupper($search_term) . '%\'');
            })->join('prices', 'products.product', '=', 'prices.product')
            ->join('stock_levels', 'products.product', '=', 'stock_levels.product')
            ->where('prices.customer_code', Auth::user()->customer->customer_code)
            ->paginate(10);
    }

    /**
     * Autocomplete for quick-buy input.
     *
     * @param $search
     * @return Products
     */
    public static function autocomplete($search)
    {
        return (new Products)->select('product')
            ->whereHas('prices')
            ->whereRaw('UPPER(product) like \'' . $search . '%\'')
            ->orderBy('product', 'asc')
            ->limit(10)
            ->get();
    }

    /**
     * Take a list of products and return the first image that exists.
     *
     * @param $products
     * @return array
     */
    public static function checkImage($products)
    {
        $products = explode(',', $products);

        foreach ($products as $product) {
            $product = str_replace(['%2B', '+'], ' ', encodeUrl($product)) . '.png';

            $exists = $exists = Storage::disk('public')->exists('product_images/' . $product);

            if ($exists) {
                return [
                    'found' => true,
                    'image' => '/product_images/' . $product
                ];
            }
        }

        return [
            'found' => false,
            'image' => '/images/no-image.png'
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prices(): BelongsTo
    {
        return $this->belongsTo(Prices::class, 'product', 'product')->where('customer_code', auth()->user()->customer->customer);
    }

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'product', 'product');
    }

    /**
     * @return BelongsTo
     */
    public function stock(): BelongsTo
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
        $products = self::whereHas('prices')->whereHas('categories', static function ($query) use ($categories) {
            $query->where('cat1_level1', ($categories['level_1']))->where('cat1_level2', $categories['level_2'])->where('cat1_level3', $categories['level_3']);
        })->join('prices', 'products.product', '=', 'prices.product')->join('stock_levels', 'products.product', '=', 'stock_levels.product')->where('prices.customer_code', auth()->user()->customer->code)->paginate(10);

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
        return self::select([
            'products.product',
            'name',
            'description',
            'uom',
            'price',
            'quantity',
            'order_multiples',
        ])->whereHas('prices')->where('products.product', $product_code)->leftJoin('prices', 'prices.product', 'products.product')->leftJoin('stock_levels', 'stock_levels.product', 'products.product')->first();
    }

    /**
     * Take the search parameter and search on multiple columns.
     *
     * @param $search_term
     * @return mixed
     */
    public static function search($search_term)
    {
        return self::whereHas('prices')->where(static function ($query) use ($search_term) {
            $query->whereRaw('upper(products.product) LIKE \'%'.strtoupper($search_term).'%\'')->orWhereRaw('upper(name) LIKE \'%'.strtoupper($search_term).'%\'')->orWhereRaw('upper(description) LIKE \'%'.strtoupper($search_term).'%\'');
        })->join('prices', 'products.product', '=', 'prices.product')->join('stock_levels', 'products.product', '=', 'stock_levels.product')->where('prices.customer_code', auth()->user()->customer->code)->paginate(10);
    }

    /**
     * Autocomplete for quick-buy input.
     *
     * @param $search
     * @return Products
     */
    public static function autocomplete($search): Products
    {
        return self::select('product')->whereHas('prices')->whereRaw('UPPER(product) like \''.$search.'%\'')->orderBy('product', 'asc')->limit(10)->get();
    }

    /**
     * @param $product
     * @return \Illuminate\Http\JsonResponse
     */
    public static function details($product): JsonResponse
    {
        $product_details = self::where('product', $product)->first();

        if ($product_details) {
            $image_check = self::checkImage($product_details->product);

            return response()->json([
                'product_code' => $product_details->product,
                'description' => $product_details->name,
                'image_file' => $image_check['found'] ? asset($image_check['image']) : null,
            ]);
        }

        return response()->json([
            'message' => 'Product not found',
        ], 404);
    }

    /**
     * Take a list of products and return the first image that exists.
     *
     * @param $products
     * @return array
     */
    public static function checkImage($products): array
    {
        $products = explode(',', $products);

        foreach ($products as $product) {
            $product = str_replace(['%2B', '+'], ' ', encodeUrl($product)).'.png';

            $exists = $exists = Storage::disk('public')->exists('product_images/'.$product);

            if ($exists) {
                return [
                    'found' => true,
                    'image' => '/product_images/'.$product,
                ];
            }
        }

        return [
            'found' => false,
            'image' => '/images/no-image.png',
        ];
    }
}

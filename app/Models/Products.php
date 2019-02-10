<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Models\Products
 *
 * @mixin \Eloquent
 */
class Products extends Model
{
    protected $table = 'products';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->belongsTo(Prices::class, 'product', 'product')->where('customer_code', Auth::user()->customer_code);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo(Categories::class, 'product', 'product');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'product', 'product');
    }

    /**
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
            })->paginate(10);

        return $products;
    }

    /**
     * @param $product_code
     * @return mixed
     */
    public static function show($product_code)
    {
        return (new Products)->whereHas('prices')->where('product', $product_code)->first();
    }

    /**
     * @param $search_term
     * @return mixed
     */
    public static function search($search_term)
    {
        return (new Products)->whereHas('prices')
            ->where(function ($query) use ($search_term) {
                $query->whereRaw('upper(product) LIKE \'%' . strtoupper($search_term) . '%\'')
                    ->orWhereRaw('upper(name) LIKE \'%' . strtoupper($search_term) . '%\'')
                    ->orWhereRaw('upper(description) LIKE \'%' . strtoupper($search_term) . '%\'');
            })->paginate(10);
    }

    /**
     * @param $search
     * @return Products
     */
    public static function autocomplete($search)
    {
        return (new Products)->select('product')
            ->whereHas('prices')
            ->whereRaw('UPPER(product) like \'' .  $search . '%\'')
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
            $external_link = 'https://scolmoreonline.com/product_images/' . $product . '.png';

            if (@getimagesize($external_link)) {
                return [
                    'found' => true,
                    'image' => $external_link
                ];
            }
        }

        return [
            'found' => false,
            'image' => 'https://scolmoreonline.com/assets/images/no-image.png'
        ];
    }
}

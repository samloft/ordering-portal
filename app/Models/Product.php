<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Storage;

/**
 * App\Models\Product.
 *
 * @mixin \Eloquent
 *
 * @property string $code
 * @property string $type
 * @property string $name
 * @property string $uom
 * @property float $trade_price
 * @property int $order_multiples
 * @property string $description
 * @property string $note
 * @property string $link1
 * @property string $link2
 * @property string $link3
 * @property int $not_sold
 * @property int $stock
 * @property string $vat_flag
 * @property int $packaging
 * @property int $obsolete
 * @property string $product_barcode
 * @property string $inner_barcode
 * @property string $outer_barcode
 * @property float $gross_weight
 * @property float $net_weight
 * @property int $length
 * @property int $width
 * @property int $height
 * @property string $luckins_code
 *
 */
class Product extends Model
{
    protected $table = 'products';

    public $timestamps = false;

    /**
     * Get the products URL path.
     *
     * @return string
     */
    public function path(): string
    {
        return '/products/view/'.encodeUrl($this->code);
    }

    /**
     * Check to see if an image exists for a product, if not
     * return a default "Image Soon" image.
     *
     * @param bool $blank
     *
     * @return string
     */
    public function image($blank = false): string
    {
        // Products that have a forward slash in them need to have the image files with a ^ instead.
        $image = str_replace('/', '^', $this->code).'.png';

        if (Storage::disk('public')->exists('product_images/'.$image)) {
            return asset('/product_images/'.$image);
        }

        // If $blank is passed, it means we dont want any image returned.
        if ($blank) {
            return '';
        }

        return asset('images/no-image.png');
    }

    /**
     * Get the price for the product based on the current logged in users customer code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function prices(): BelongsTo
    {
        return $this->belongsTo(Price::class, 'code', 'product')->where('customer_code', auth()->user()->customer->code);
    }

    /**
     * Get the categories that a product belongs to.
     *
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'code', 'product');
    }

    /**
     * Get the expected stock for the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expectedStock(): HasMany
    {
        return $this->hasMany(ExpectedStock::class, 'product', 'code')->orderBy('due_date', 'asc');
    }

    /**
     * Return all products for the given categories.
     *
     * @param $categories
     *
     * @return mixed
     */
    public static function list($categories)
    {
        return self::whereHas('prices')->whereHas('categories', static function ($query) use ($categories) {
            $query->where('level_1', $categories['level_1'])->where('level_2', $categories['level_2'])->where('level_3', $categories['level_3']);
        })->with('prices')->paginate(10);
    }

    /**
     * Get data for the given product code, with it's price information and expected stock.
     *
     * @param $product_code
     *
     * @return mixed
     */
    public static function show($product_code)
    {
        return self::where('code', $product_code)->whereHas('prices')->with('prices')->with('expectedStock')->first();
    }

    /**
     * Take the search parameter and search on multiple columns.
     *
     * @param $search_term
     *
     * @return mixed
     */
    public static function search($search_term)
    {
        return self::where(static function ($query) use ($search_term) {
            $query->whereRaw('upper(products.code) LIKE \'%'.strtoupper($search_term).'%\'')->orWhereRaw('upper(name) LIKE \'%'.strtoupper($search_term).'%\'')->orWhereRaw('upper(description) LIKE \'%'.strtoupper($search_term).'%\'');
        })->whereHas('prices')->with('prices')->paginate(10);
    }

    /**
     * Autocomplete for quick-buy input.
     *
     * @param $search
     *
     * @return mixed
     */
    public static function autocomplete($search)
    {
        return self::select('code')->whereHas('prices')->whereRaw('UPPER(code) like \''.strtoupper($search).'%\'')->orderBy('code', 'asc')->limit(10)->get();
    }

    /**
     * Take a list of products and return the first image that exists.
     *
     * @param $products
     *
     * @return array
     */
    public static function checkImage($products): array
    {
        $products = explode(',', $products);

        foreach ($products as $product) {
            $product = str_replace(['%2B', '+'], ' ', encodeUrl($product)).'.png';

            $exists = Storage::disk('public')->exists('product_images/'.$product);

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

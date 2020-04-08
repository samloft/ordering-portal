<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * App\Models\Customer.
 *
 * @mixin Eloquent
 *
 * @property string $code
 * @property string $name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $country
 * @property string $post_code
 * @property string $invoice_name
 * @property string $invoice_address_line_1
 * @property string $invoice_address_line_2
 * @property string $invoice_city
 * @property string $invoice_postcode
 * @property string $vat_flag
 * @property string $currency
 * @property string $buying_group
 * @property string $price_list
 * @property string $discount_code
 */
class Customer extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    /**
     * Check to see if the customer has a discount override.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(CustomerDiscount::class, 'code', 'customer_code');
    }

    /**
     * Check to see if the customer has any promotions available to them.
     *
     * @return array
     */
    public function hasPromotions(): array
    {
        return Promotion::customer(auth()->user()->customer);
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

    /**
     * Get all possible buying groups.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function buyingGroups(): Collection
    {
        return self::select('buying_group')->where('buying_group', '!=', '')->groupBy('buying_group')->pluck('buying_group');
    }

    /**
     * Get all possible price lists.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function priceLists(): Collection
    {
        return self::select('price_list')->where('price_list', '!=', '')->groupBy('price_list')->pluck('price_list');
    }

    /**
     * Get all possible discount codes.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function discountCodes(): Collection
    {
        return self::select('discount_code')->where('discount_code', '!=', '')->groupBy('discount_code')->pluck('discount_code');
    }
}

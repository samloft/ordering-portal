<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Basket
 *
 * @mixin \Eloquent
 */
class Basket extends Model
{
    protected $table = 'basket';
    public $timestamps = false;

    /**
     * Return product relationship on product code from basket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productDetails()
    {
        return $this->belongsTo(Products::class, 'product', 'product');
    }

    public function prices()
    {
        return $this->belongsTo(Prices::class, 'product', 'product')->where('prices.customer_code', Auth::user()->customer_code);
    }

    /**
     * Return all basket lines based on customer code
     *
     * @return Basket[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        $lines = (new Basket)->selectRaw('basket.product as product, basket.customer_code as customer_code, 
                                                    basket.quantity as quantity, price, break1, price1, break2, price2, 
                                                    break3, price3, name, uom, not_sold, stock_levels.quantity as stock_level')
            ->where('basket.customer_code', Auth::user()->customer_code)
            ->join('prices', 'basket.product', '=', 'prices.product')
            ->where('prices.customer_code', Auth::user()->customer_code)
            ->join('products', 'basket.product', '=', 'products.product')
            ->join('stock_levels', 'basket.product', '=', 'stock_levels.product')
            ->get();

        $goods_total = 0;
        $product_lines = [];

        foreach ($lines as $line) {
            $goods_total = $goods_total + (discount($line->price) * $line->quantity);

            if (Storage::disk('public')->exists('product_images/' . $line->product . '.png')) {
                $image = asset('product_images/' . $line->product . '.png');
            } else {
                $image = asset('images/no-image.png');
            }

            $product_lines[] = [
                'product' => $line->product,
                'name' => $line->name,
                'uom' => $line->uom,
                'stock' => $line->stock_level,
                'image' => $image,
                'quantity' => $line->quantity,
                'price' => currency(discount($line->price) * $line->quantity, 2),
                'unit_price' => currency(discount($line->price), 4),
            ];
        }

        $small_order_charge = static::smallOrderCharge($goods_total);

        return [
            'summary' => [
                'goods_total' => currency($goods_total, 2),
                'shipping' => currency(0, 2),
                'sub_total' => currency($goods_total, 2),
                'small_order_charge' => currency($small_order_charge, 2),
                'vat' => currency(vatAmount($goods_total + $small_order_charge), 2),
                'total' => currency(vatIncluded($goods_total + $small_order_charge), 2)
            ],
            'lines' => $product_lines
        ];
    }

    /**
     * Return summary details based on users current basket.
     *
     * @return array
     */
    public static function summary()
    {
        $summary = (new Basket)->selectRaw('SUM(prices.price * basket.quantity) as goods_total, COUNT(basket.product) as line_count')
            ->join('prices', 'basket.product', '=', 'prices.product')
            ->where('prices.customer_code', Auth::user()->customer_code)
            ->where('basket.customer_code', Auth::user()->customer_code)
            ->first();

        return [
            'lines' => $summary->line_count,
            'goods_total' => currency($summary->goods_total, 2)
        ];
    }

    /**
     * Add array of order lines into customers basket.
     *
     * @param $order_lines
     * @return mixed
     */
    public static function store($order_lines)
    {
        $user_id = Auth::user()->id;
        $customer_code = Auth::user()->customer_code;

        foreach ($order_lines as $line) {
            // Check that the customer can buy the product.
            $customer_can_buy = Products::show($line['product']);

            if ($customer_can_buy) {
                $product = static::exists($line['product']);
                $line['user_id'] = $user_id;
                $line['customer_code'] = $customer_code;

                if ($product) {
                    $basket_quantity = $product->quantity;

                    (new basket)->where('product', $line['product'])->update(['quantity' => $basket_quantity + $line['quantity']]);
                } else {
                    (new Basket)->insert($line);
                }
            }
        }

        return true;
    }

    /**
     * Checks if a product already exists in the customers basket.
     *
     * @param $product_code
     * @return Basket|Model|object|null
     */
    public static function exists($product_code)
    {
        return (new Basket)->where('customer_code', Auth::user()->customer_code)->where('product', $product_code)->first();
    }

    /**
     * Remove all items from the basket for the logged in customer.
     *
     * @return bool|int|null
     * @throws \Exception
     */
    public static function clear()
    {
        return (new Basket)->where('customer_code', Auth::user()->customer_code)->delete();
    }

    /**
     * Check if the value of the order reaches the limit of the small
     * order charge, if not return the charge else return 0.
     *
     * @param $value
     * @return int
     */
    public static function smallOrderCharge($value)
    {
        $small_order_limit = 200;
        $small_order_charge = 10;

        return $value > $small_order_limit ? 0 : $small_order_charge;
    }
}

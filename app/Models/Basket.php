<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        $lines = (new Basket)->where('basket.customer_code', Auth::user()->customer_code)
            ->join('prices', 'basket.product', '=', 'prices.product')
            ->where('prices.customer_code', Auth::user()->customer_code)
            ->join('products', 'basket.product', '=', 'products.product')
            ->get();

        $goods_total = 0;
        $product_lines = [];

        foreach ($lines as $line) {
            $goods_total = $goods_total + ($line->price * $line->quantity);

            $product_lines[] = [
                'product' => $line->product,
                'name' => $line->name,
                'uom' => $line->uom,
                'image' => 'https://scolmoreonline.com/product_images/' . $line->product . '.png',
                'quantity' => $line->quantity,
                'price' => currency($line->price * $line->quantity, 2),
                'unit_price' => currency($line->price, 4),
            ];
        }

        return [
            'summary' => [
                'goods_total' => currency($goods_total, 2),
                'vat' => currency((20 / 100) * $goods_total, 2),
                'total' => currency($goods_total * (1 + 20 / 100), 2)
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
        foreach ($order_lines as $line) {
            $product = static::exists($line['product']);

            if ($product) {
                $basket_quantity = $product->quantity;

                (new basket)->where('product', $line['product'])->update(['quantity' => $basket_quantity + $line['quantity']]);
            } else {
                (new Basket)->insert($line);
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
}

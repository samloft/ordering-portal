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

    /**
     * Return all basket lines based on customer code
     *
     * @return Basket[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function show()
    {
        $lines = (new Basket)->where('customer_code', Auth::user()->customer_code)->with('productDetails')->get();

        $line_count = 0;
        $goods_total = 0;

        $product_lines = [];

        foreach ($lines as $line) {
            $line_count++;
            $goods_total = $goods_total + ($line->productDetails->prices->price * $line->quantity);

            $product_lines[] = [
                'product' => $line->productDetails->product,
                'name' => $line->productDetails->name,
                'image' => 'https://scolmoreonline.com/product_images/' . $line->productDetails->product . '.png',
                'quantity' => $line->quantity,
                'price' => currency($line->productDetails->prices->price * $line->quantity)
            ];
        }

        return [
            'summary' => [
                'line_count' => $line_count,
                'goods_total' => number_format($goods_total, 2, '.', ',')
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
        $lines = static::show();

        return [
            'lines' => $lines['summary']['line_count'],
            'goods_total' => currency() . $lines['summary']['goods_total']
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

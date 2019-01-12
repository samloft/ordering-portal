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
        $lines = (new Basket)->where('customer_code', Auth::user()->customer_code)->get();

        $line_count = 0;
        $goods_total = 0;

        foreach ($lines as $line) {
            $line_count++;
            $goods_total = $goods_total + ($line->productDetails->prices->price * $line->quantity);
        }

        return [
            'summary' => [
                'line_count' => $line_count,
                'goods_total' => number_format($goods_total, 2, '.', ',')
            ],
            'lines' => $lines
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

        $line_count = 0;
        $goods_total = 0;

        foreach ($lines as $line) {
            $line_count++;
            $goods_total = $goods_total + ($line->productDetails->prices->price * $line->quantity);
        }

        return [
            'lines' => $line_count,
            'goods_total' => number_format($goods_total, 2, '.', ',')
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
        return (new Basket)->insert($order_lines);
    }
}

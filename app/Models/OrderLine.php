<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderLine.
 *
 * @mixin \Eloquent
 *
 * @property string $order_number
 * @property string $product
 * @property string $description
 * @property int $quantity
 * @property string $stock_type
 * @property float $price
 * @property float $total
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class OrderLine extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
}

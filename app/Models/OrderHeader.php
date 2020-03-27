<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderHeader.
 *
 * @mixin \Eloquent
 *
 * @property string $order_number
 * @property string $customer_code
 * @property int $user_id
 * @property string $reference
 * @property string $notes
 * @property string $name
 * @property string $telephone
 * @property string $mobile
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $address_line_3
 * @property string $address_line_4
 * @property string $address_line_5
 * @property string $delivery_method
 * @property string $delivery_code
 * @property float $delivery_cost
 * @property float $small_order_charge
 * @property float $value
 * @property int $imported
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $deleted_at
 */
class OrderHeader extends Model
{
    protected $table = 'order_header';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * Return all the line for the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_no', 'order_no');
    }
}

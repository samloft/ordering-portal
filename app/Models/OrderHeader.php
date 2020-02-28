<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\OrderHeader.
 *
 * @mixin Eloquent
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_no', 'order_no');
    }
}

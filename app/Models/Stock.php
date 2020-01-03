<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stock.
 *
 * @mixin \Eloquent
 */
class Stock extends Model
{
    protected $table = 'stock_levels';

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @mixin \Eloquent
 */
class Customer extends Model
{
    protected $primaryKey = 'customer_code';
    public $incrementing = false;
}

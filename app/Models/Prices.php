<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    protected $primaryKey = 'product';
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function product()
//    {
//        return $this->belongsTo(Products::class, 'product', 'product');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
//    public function categories()
//    {
//        return $this->belongsToMany(Categories::class, 'product', 'product');
//    }
}

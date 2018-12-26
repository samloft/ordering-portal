<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
     * @return mixed
     */
    public static function show()
    {
        return (new Countries)->get();
    }
}

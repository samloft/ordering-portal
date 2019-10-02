<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\Admin
 *
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    protected $guard = 'admin';
    protected $table = 'cms_users';
    protected $hidden = ['password', 'remember_token'];

    /**
     * @param null $pagination_limit
     * @return \App\Models\Admin[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public static function show($pagination_limit = null)
    {
        if ($pagination_limit) {
            return self::paginate($pagination_limit);
        }

        return self::get();
    }
}

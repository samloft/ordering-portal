<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
     * Return all the admin users with optional search parameters.
     *
     * @param null $search
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function show($search = null): LengthAwarePaginator
    {
        return self::where(static function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%'.$search.'%');
                $query->orWhere('email', 'like', '%'.$search.'%');
            }
        })->orderBy('name')->paginate(10);
    }
}

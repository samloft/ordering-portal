<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    protected $guard = 'admin';
    protected $table = 'cms_users';
    protected $hidden = ['password', 'remember_token'];

    public static function show($pagination_limit = null)
    {
        if ($pagination_limit) {
            return (new Admin)->paginate($pagination_limit);
        }

        return (new Admin)->get();
    }
}

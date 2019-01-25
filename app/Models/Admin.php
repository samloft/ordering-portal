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
}

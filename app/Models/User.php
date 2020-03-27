<?php

namespace App\Models;

use App\Traits\CustomerDetails;
use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User.
 *
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;
    use CustomerDetails;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that are guarded from mass assignment.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
    ];

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'customer_code', 'customer_code');
    }

    /**
     * Return all the customers as user has access too.
     *
     * @return HasMany
     */
    public function customers(): HasMany
    {
        return $this->hasMany(UserCustomer::class);
    }

    /**
     * Return all the users/customers.
     *
     * @param $search
     *
     * @return LengthAwarePaginator
     */
    public static function listAll($search): LengthAwarePaginator
    {
        return self::where(static function (Eloquent $query) use ($search) {
            if ($search) {
                $query->where('name', 'like', '%'.$search.'%');
                $query->orWhere('email', 'like', '%'.$search.'%');
                $query->orWhere('customer_code', 'like', '%'.$search.'%');
            }
        })->orderBy('name')->with('customers')->paginate(10);
    }

    /**
     * Return a count of all the current users.
     *
     * @return int
     */
    public static function countAll(): int
    {
        return self::count();
    }

    /**
     * Return user details with any extra customers.
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public static function show($id)
    {
        return self::where('id', $id)->with('customers')->first();
    }
}

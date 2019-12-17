<?php

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;
use App\Traits\CustomerDetails;
use Illuminate\Support\Collection;

/**
 * App\Models\User
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
    protected $fillable = [
        'first_name',
        'last_name',
        'telephone',
        'evening_telephone',
        'fax',
        'mobile',
    ];

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
     * Create/update a site user.
     *
     * @param $user_details
     * @return mixed
     */
    public static function store($user_details)
    {
        $user_details['customer_code'] = strtoupper($user_details['customer_code']);

        if ($user_details['id']) {
            if ($user_details['password']) {
                $user_details['password'] = Hash::make($user_details['password']);
            } else {
                $user_details = array_filter($user_details);
            }

            return self::where('id', $user_details['id'])->update($user_details);
        }

        $user_details['password'] = Hash::make($user_details['password']);
        $user_details['created_at'] = date('Y-m-d H:i:s');

        return self::insert($user_details);
    }

    /**
     * Return all the users/customers.
     *
     * @param $search
     * @return LengthAwarePaginator
     */
    public static function listAll($search): LengthAwarePaginator
    {
        return self::where(static function ($query) use ($search) {
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public static function show($id)
    {
        return self::where('id', $id)->with('customers')->first();
    }

    /**
     * Delete the given user by ID.
     *
     * @param array|Collection|int $id
     * @return int|mixed
     */
    public static function destroy($id)
    {
        return self::where('id', $id)->delete();
    }
}

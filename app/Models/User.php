<?php

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Hash;
use App\Traits\CustomerDetails;
use Illuminate\Support\Collection;

/**
 * App\User
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
        'first_name', 'last_name', 'telephone', 'evening_telephone', 'fax', 'mobile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Addresses::class, 'customer_code', 'customer_code');
    }

    /**
     * Return all the customers as user has access too.
     *
     * @return HasMany
     */
    public function customers()
    {
        return $this->hasMany(UserCustomers::class);
    }

//    public function customer()
//    {
//        if (Session::get('temp_customer')) {
//            $customer = (new Customer)->where('customer_code', Session::get('temp_customer'))->first()->toArray();
//
//            Auth::user()->customer = $customer;
//
//            return Auth::user()->customer = $customer;
//        }
//
//        return $this->belongsTo(Customer::class, 'customer_code', 'customer_code');
//    }

//    public function getCustomerAttribute()
//    {
//        if (Session::get('temp_customer')) {
//            if (empty(Auth::user()->customer) || Auth::user()->customer->customer_code != Session::get('temp_customer')) {
//                $customer = (new Customer)->where('customer_code', Session::get('temp_customer'))->first();
//
//                return Auth::user()->customer = $customer;
//            }
//
//            return Auth::user()->customer;
//        }
//
//            $customer = $this->belongsTo(Customer::class, 'customer_code', 'customer_code')->first();
//
//            return Auth::user()->customer = $customer;
//
//    }

    /**
     * @param $user_details
     * @return mixed
     */
    public static function store($user_details)
    {
        $user = User::find(Auth::id());
        $user->update($user_details);

        return $user->wasChanged();
    }

    /**
     * @param $password
     * @return mixed
     */
    public static function changePassword($password)
    {
        $user = User::find(Auth::id());

        $user->password = Hash::make($password);
        $user->password_updated = date('Y-m-d H:i:s');
        $user->save();

        return $user->wasChanged();
    }

    /**
     * Return all the users/customers.
     *
     * @param $search
     * @return LengthAwarePaginator
     */
    public static function listAll($search): LengthAwarePaginator
    {
        if ($search) {
            return (new User)
                ->where('username', 'like', '%' . $search . '%')
                ->orWhere('first_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('customer_code', 'like', '%' . $search . '%')
                ->orderBy('username', 'asc')
                ->paginate(10);
        }

        return (new User)->orderBy('username', 'asc')->paginate(10);
    }

    /**
     * Return a count of all the current users.
     *
     * @return int
     */
    public static function countAll()
    {
        return (new User)->count();
    }
}

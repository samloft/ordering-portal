<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * App\User
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_code', 'customer_code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Addresses::class, 'customer_code', 'customer_code');
    }

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
}

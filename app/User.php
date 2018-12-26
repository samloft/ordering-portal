<?php

namespace App;

use App\Models\Addresses;
use App\Models\Customer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * @param $details
     * @return mixed
     */
    public static function store($details)
    {
        $user_id = Auth::id();

        return (new User)->where('id', $user_id)->update($details);
    }

    /**
     * @param $password
     * @return mixed
     */
    public static function changePassword($password)
    {
        $user_id = Auth::id();

        $new_password = [
            'password' => Hash::make($password),
            'password_updated' => date('Y-m-d H:i:s')
        ];

        return (new User)->where('id', $user_id)->update($new_password);
    }
}

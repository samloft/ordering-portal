<?php

namespace App\Models;

use App\Traits\CustomerDetails;
use Eloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\User.
 *
 * @mixin Eloquent
 *
 * @property int $id
 * @property string $customer_code
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon $password_updated
 * @property string $remember_token
 * @property string $name
 * @property string $telephone
 * @property string $mobile
 * @property int $admin
 * @property int $can_order
 * @property stirng $api_token
 * @property bool $terms_accepted
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class User extends Authenticatable
{
    use Notifiable;
    use CustomerDetails;
    use LogsActivity;

    protected static $logAttributes = [
        'id',
        'customer_code',
        'email',
        'name',
        'telephone',
        'mobile',
        'admin',
        'can_order',
    ];

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
     * Accept terms and condition for the current logged in user.
     *
     * @return bool
     */
    public function acceptTerms(): bool
    {
        $user = self::findOrFail(auth()->id());

        return $user->update([
            'terms_accepted' => true,
        ]);
    }

    /**
     * Return the delivery addresses for the current user.
     *
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
     * Return all the users/customers with optional search parameters.
     *
     * @param $search
     *
     * @return LengthAwarePaginator
     */
    public static function list($search): LengthAwarePaginator
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

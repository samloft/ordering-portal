<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Admin.
 *
 * @mixin \Eloquent
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Admin extends Authenticatable
{
    use Notifiable;
    use LogsActivity;

    protected static $logAttributes = ['id', 'name', 'email'];

    protected $guard = 'admin';

    protected $table = 'cms_users';

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

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}

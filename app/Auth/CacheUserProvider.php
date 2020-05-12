<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheUserProvider
 *
 * @package App\Auth
 */
class CacheUserProvider extends EloquentUserProvider
{
    /**
     * CacheUserProvider constructor.
     *
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * @param mixed $identifier
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier): ?Authenticatable
    {
        return Cache::get('user.'.$identifier) ?? parent::retrieveById($identifier);
    }
}

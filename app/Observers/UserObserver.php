<?php

namespace App\Observers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cache;

/**
 * User observer
 */
class UserObserver
{
    /**
     * @param User $user
     */
    public function saved(User $user): void
    {
        Cache::put("user.{$user->id}", $user, 60);
    }

    /**
     * @param User $user
     */
    public function deleted(User $user): void
    {
        Cache::forget("user.{$user->id}");
    }

    /**
     * @param User $user
     */
    public function restored(User $user): void
    {
        Cache::put("user.{$user->id}", $user, 60);
    }

    /**
     * @param User $user
     */
    public function retrieved(User $user): void
    {
        Cache::add("user.{$user->id}", $user, 60);
    }
}

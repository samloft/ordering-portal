<?php

namespace Tests;

use JMac\Testing\Traits\AdditionalAssertions;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdditionalAssertions;

    /**
     * Create a user & sign them in.
     *
     * @param null $user
     *
     * @return mixed|null
     */
    protected function signIn($user = null)
    {
        $user = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    /**
     * Create a admin & sign them in.
     *
     * @param null $user
     *
     * @return mixed|null
     */
    protected function adminSignIn($user = null)
    {
        $user = $user ?: factory(Admin::class)->create();

        $this->actingAs($user, 'admin');

        return $user;
    }
}

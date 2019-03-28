<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * Checks the login form can be viewed.
     */
    public function test_user_can_view_login_form()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * Check that a user can login with the correct credentials.
     */
    public function test_user_can_authenticate_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'user-for-testing')
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Make sure users can no longer access the login form once they are
     * authenticated.
     */
    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    /**
     * Check that a user cannot authenticate with incorrect credentials.
     */
    public function test_user_cannot_authenticate_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'user-for-testing')
        ]);

        $response = $this->from('/login')->post('/login', [
            'username' => $user->username,
            'password' => 'invalid-password'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('username');

        $this->assertTrue(session()->hasOldInput('username'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /**
     * Check that the "Remember Me" functionality correctly creates a cookie.
     */
    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'user-for-testing')
        ]);

        $response = $this->post('/login', [
            'username' => $user->username,
            'password' => $password,
            'remember' => 'on'
        ]);

        $response->assertRedirect('/');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }
}

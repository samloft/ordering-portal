<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Setup\UserFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Check that nobody can access registration.
     *
     * @test
     */
    public function a_user_cannot_register(): void
    {
        $response = $this->get('register');

        $response->assertStatus(404);

        $response = $this->post('register');

        $response->assertStatus(404);
    }

    /**
     * If a user has a customer code that does not have a matching record
     * in the customers table, the user should be logged out with an error message.
     *
     * @test
     */
    public function a_user_cannot_login_with_an_invalid_customer(): void
    {
        $user = (new UserFactory)->create();

        $this->signIn($user);

        $this->get('/')->assertRedirect('/login');
    }

    /**
     * If a user has a customer code that is a valid customer, check that
     * the user is authenticated.
     *
     * @test
     */
    public function a_user_can_login_with_a_valid_customer(): void
    {
        $user = (new UserFactory)->withCustomer()->create();

        $this->signIn($user);

        $this->assertAuthenticatedAs($user);

        $this->get('/')->assertSee('Basket');
    }

    /**
     * Check that the "Remember Me" functionality works correctly & creates the required cookie.
     *
     * @test
     */
    public function a_user_can_remember_login(): void
    {
        $user = (new UserFactory)->withCustomer()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect('/')->assertCookie(auth()->guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Check that a user can use forgot password and gets an email with a link.
     *
     * @test
     */
    public function a_user_can_use_forgot_password(): void
    {
        $this->get('/password/reset')->assertSuccessful();

        Notification::fake();

        $user = (new UserFactory)->create();

        $this->post('/password/email', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}

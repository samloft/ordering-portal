<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /**
     * Checks the forgot password form can be viewed.
     */
    public function test_user_can_view_forgot_password_form()
    {
        $response = $this->get('/password/reset');

        $response->assertSuccessful();
    }

    /**
     * Make sure user receives an email with a password reset link.
     */
    public function test_user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $this->post('/password/email', [
            'username' => $user->username,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }
}

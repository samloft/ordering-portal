<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

test('login returns an ok response', function () {
    $this->get(route('cms.login'))->assertOk();
});

test('can login', function () {
    $admin = factory(Admin::class)->create([
        'password' => bcrypt('password'),
    ]);

    $this->followingRedirects()->post(route('cms.login.submit'), [
        'email' => $admin->email,
        'password' => 'password',
    ])->assertOk()->assertSee('Dashboard');
});

test('incorrect login shows error and keeps email and remember inputs', function () {
    $this->followingRedirects()->from(route('cms.login'))->post(route('cms.login.submit'), [
        'email' => 'no@exists.com',
        'password' => 'password',
        'remember' => true,
    ])->assertSee('Error!')->assertSee('no@exists.com')->assertSee('checked');
});

test('forgot password displays an ok response', function () {
    $this->get(route('cms.forgot-password'))->assertOk();
});

test('can request forgot password', function () {
    Mail::fake();

    $admin = factory(Admin::class)->create();

    $this->post(route('cms.password-email'), [
        'email' => $admin->email,
    ])->assertRedirect()->assertSessionHas('status');

    $this->assertDatabaseHas('password_resets', [
        'email' => $admin->email,
    ]);
});

test('password reset returns ok response', function () {
    $admin = factory(Admin::class)->create();

    $token = Password::broker()->createToken($admin);

    $this->get(route('cms.password.reset', ['token' => $token]))->assertSuccessful()->assertSee('Reset Password')
        ->assertSee($token);
});

test('password can be reset', function () {
    $admin = factory(Admin::class)->create();

    $token = Password::broker()->createToken($admin);

    $this->followingRedirects()->from(route('cms.password.reset', ['token' => $token]))
        ->post(route('cms.password.update'), [
            'token' => $token,
            'email' => $admin->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertSuccessful();

    $admin->refresh();

    $this->assertTrue(Hash::check('newpassword', $admin->password));
});

test('can logout', function () {
    $admin = factory(Admin::class)->create();

    $this->actingAs($admin, 'admin')->followingRedirects()->post(route('cms.logout'))->assertOk()->assertSee('Login');
});

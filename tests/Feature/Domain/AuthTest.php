<?php

use App\Models\Customer;
use App\Models\User;
use Tests\Setup\UserFactory;

test('returns an ok response', function () {
    $this->get('login')->assertStatus(200);
});

test('logging in redirects to root', function () {
    $user = factory(User::class)->create([
        'password' => bcrypt('password'),
    ]);

    factory(Customer::class)->create([
        'code' => $user->customer_code,
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect('/');
});

test('redirected to login if not logged in', function () {
    $this->followingRedirects()->get(route('products'))->assertSee('login');
});

test('can login with a valid customer account', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/')->assertStatus(200)->assertSee('Basket');
});

test('cannot login with no valid customer record', function () {
    $user = (new UserFactory())->create();

    actingAs($user);

    $response = $this->followingRedirects()->get('/');

    $response->assertSee('Error');
    $response->assertSee('This account does not have a customer assigned');
});

test('terms must be accepted', function () {
    $user = (new UserFactory())->withCustomer()->create([
        'terms_accepted' => false,
    ]);

    actingAs($user);

    $this->followingRedirects()->get('products')->assertSee('we require you to accept our terms');
});

test('terms page no longer displayed if accepted', function () {
    $user = (new UserFactory())->withCustomer()->create([
        'terms_accepted' => false,
    ]);

    actingAs($user);

    $this->post('terms');

    $this->assertDatabaseHas('users', ['terms_accepted' => true]);
});

test('register returns a not found response', function () {
    $response = $this->get('register');

    $response->assertSee('Page not found')->assertStatus(200);
});

test('register cannot be posted too', function () {
    $response = $this->post('register', [
        'name' => 'Example User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(405);
});

test('forgot password displays an ok response', function () {
    $this->get('/password/reset')->assertOk();
});

test('can request forgot password', function () {
    Mail::fake();

    $user = factory(User::class)->create();

    $this->post('password/email', [
        'email' => $user->email,
    ])->assertRedirect()->assertSessionHas('status');

    $this->assertDatabaseHas('password_resets', [
        'email' => $user->email,
    ]);
});

test('password reset returns ok response', function () {
    $user = factory(User::class)->create();

    $token = Password::broker()->createToken($user);

    $this->get('/password/reset/'.$token)->assertSuccessful()->assertSee('Reset Password')->assertSee($token);
});

test('password can be reset', function () {
    $user = (new UserFactory())->withCustomer()->create([
        'terms_accepted' => true,
    ]);

    $token = Password::broker()->createToken($user);

    $this->followingRedirects()->from('/password/reset')->post('/password/reset', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ])->assertSuccessful();

    $user->refresh();

    $this->assertTrue(Hash::check('newpassword', $user->password));
});

test('redirected to root if trying to access login when logged in', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/login')->assertRedirect('/');
});

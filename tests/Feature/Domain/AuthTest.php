<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

test('returns an ok response', function () {
    $this->get('login')->assertStatus(200);
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

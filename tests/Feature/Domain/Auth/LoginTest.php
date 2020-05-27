<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

test('user can login with a valid customer account', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/')->assertStatus(200)->assertSee('Basket');
});

test('user cannot login if the customer record does not exist', function () {
    $user = (new UserFactory())->create();

    actingAs($user);

    $response = $this->followingRedirects()->get('/');

    $response->assertSee('Error');
    $response->assertSee('This account does not have a customer assigned');
});

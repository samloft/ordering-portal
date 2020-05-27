<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('register page cannot be viewed', function () {
    $response = $this->get('register');

    $response->assertSee('Page not found');
});

test('register cannot be posted too', function () {
    $response = $this->post('register', [
        'name' => 'Example User',
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(405);
});

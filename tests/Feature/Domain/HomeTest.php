<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

test('home page can be viewed', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/')->assertStatus(200);
});

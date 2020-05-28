<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;

uses(RefreshDatabase::class);

test('returns an ok response', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('products')->assertStatus(200);
});

<?php

use Tests\Setup\UserFactory;

test('returns an ok response', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('products')->assertStatus(200);
});

<?php

use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns ok response', function () {
    $this->get(route('reports'))->assertOk();
});

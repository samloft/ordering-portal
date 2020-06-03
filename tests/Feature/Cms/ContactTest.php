<?php

use App\Models\Admin;
use App\Models\Contact;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.contacts'))->assertOk();
});

test('can be created', function () {
    $contact = [
        'name' => 'New Contact',
        'email' => 'example@example.com',
    ];

    $this->post(route('cms.contacts.store', $contact))->assertOk();

    $this->assertDatabaseHas('contacts', $contact);
});

test('can be updated', function () {
    $contact = factory(Contact::class)->create([
        'name' => 'Original name'
    ]);

    $this->patch(route('cms.contacts.update', [
        'contact' => $contact->id,
        'name' => 'Updated name',
        'email' => 'example@example.com',
    ]))->assertOk();

    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'name' => 'Updated name',
        'email' => 'example@example.com',
    ]);
});

test('can be deleted', function () {
    $contact = factory(Contact::class)->create();

    $this->delete(route('cms.contacts.delete', ['contact' => $contact->id]))->assertOk();

    $this->assertDatabaseMissing('contacts', [
        'name' => $contact->name,
    ]);
});

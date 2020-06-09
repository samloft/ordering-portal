<?php

use App\Models\Contact;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);

    $this->contact = factory(Contact::class)->create();
});

test('returns ok response', function () {
    $this->get(route('contact'))->assertOk();
});

test('email can be sent', function () {
    \Illuminate\Support\Facades\Mail::fake();

    $contact = factory(Contact::class)->create();

    $this->post(route('contact.email'), [
        'to' => $contact->email,
        'name' => $contact->name,
        'email' => $this->user->email,
        'message' => 'Testing',
    ])->assertSessionHas('success');

    \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\Contact::class, static function ($mail) {
        return $mail->subject = 'Online ordering web-app message received';
    });
});

test('email cannot be sent to someone not on the list', function () {
    $this->post(route('contact.email'), [
        'to' => 'someotheremail@example.com',
        'name' => $this->contact->name,
        'email' => $this->user->email,
        'message' => 'Testing',
    ])->assertSessionHasErrors();
});

test('email list shows all contacts', function () {
    $contacts = factory(Contact::class, 5)->create();

    foreach ($contacts as $contact) {
        $this->get(route('contact'))->assertOk()->assertSee($contact->name)->assertSee($contact->email);
    }
});

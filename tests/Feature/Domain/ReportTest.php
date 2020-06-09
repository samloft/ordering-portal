<?php

use App\Models\AccountSummary;
use Tests\Setup\OrderTrackingFactory;
use Tests\Setup\UserFactory;

beforeEach(function () {
    $this->user = (new UserFactory())->withCustomer()->create();

    actingAs($this->user);
});

test('returns ok response', function () {
    $this->get(route('reports'))->assertOk();
});

test('back order report can be downloaded to PDF', function () {
    (new OrderTrackingFactory())->withLines()->create([
        'order_number' => '123/1',
        'customer_code' => $this->user->customer->code,
        'status' => 'Pending',
    ]);

    $response = $this->post(route('reports.show'), [
        'output' => 'pdf',
        'report' => 'back_orders',
    ]);

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'application/pdf');
});

test('back order report can be downloaded to CSV', function () {
    (new OrderTrackingFactory())->withLines()->create([
        'order_number' => '123/1',
        'customer_code' => $this->user->customer->code,
        'status' => 'Pending',
    ]);

    $response = $this->post(route('reports.show'), [
        'output' => 'csv',
        'report' => 'back_orders',
    ]);

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'text/plain');
});

test('back order report with no back orders displays error', function () {
    $this->post(route('reports.show'), [
        'output' => 'pdf',
        'report' => 'back_orders',
    ])->assertStatus(404)->assertSee('no back orders');
});

test('account summary with no data displays error', function () {
    $this->post(route('reports.show'), [
        'output' => 'pdf',
        'report' => 'account_summary',
    ])->assertStatus(404);
});

test('account summary report can be downloaded to PDF', function () {
    factory(AccountSummary::class)->create([
        'customer_code' => $this->user->customer->code,
    ]);

    $response = $this->post(route('reports.show'), [
        'output' => 'pdf',
        'report' => 'account_summary',
    ]);

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'application/pdf');
});

test('account summary report can be download to CSV', function () {
    factory(AccountSummary::class)->create([
        'customer_code' => $this->user->customer->code,
    ]);

    $response = $this->post(route('reports.show'), [
        'output' => 'csv',
        'report' => 'account_summary',
    ]);

    $response->assertStatus(200);
    $this->assertEquals($response->headers->get('content-type'), 'text/plain');
});

test('a report type must be selected', function () {
    $this->post(route('reports.show'), [
        'output' => 'pdf',
    ])->assertRedirect()->assertSessionHas('error');
});

<?php

use Tests\Setup\UserFactory;

test('returns an ok response', function () {
    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/')->assertStatus(200);
});

test('IE11 is the only IE version allowed', function () {
    //$mock = $this->getMockBuilder(\App\Http\Middleware\BrowserMiddleware::class)
    //    ->setMethods(['getUserAgent'])
    //    ->getMock();
    //
    //$mock->expects($this->once())->method('getUserAgent')->willReturn('MSIE|Internet Explorer Trident/7.0; rv:10.0');
    //
    //$this->assertSame('', $mock->handle()->andReturnsUsing(function ($request, \Closure $next) {
    //    return $next($request);
    //}));

    $user = (new UserFactory())->withCustomer()->create();

    actingAs($user);

    $this->get('/', [
        'HTTP_USER_AGENT' => 'MSIE|Internet Explorer Trident/7.0; rv:10.0',
    ])->assertRedirect(route('not-supported'));
});

<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    /**
     * Check then when user attempts to view /register they are redirected to the login page.
     */
    public function test_user_cannot_view_registration()
    {
        $response = $this->get('/register');

        $response->assertRedirect('/login');
    }
}

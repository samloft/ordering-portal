<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class OrderUploadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check that a user can view the change customer section if they have any additional customers.
     *
     * @test
     */
    public function a_user_can_see_change_customer_if_additional_customers_added(): void
    {
        $user = (new UserFactory)->withCustomer()->withUserCustomers(2)->create();

        $this->signIn($user);

        $this->get('/products')->assertSee('Change Customer');
    }
}

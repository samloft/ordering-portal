<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\CustomerFactory;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class ChangeCustomerTest extends TestCase
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

    /**
     * Check that a user cannot view change customer if they have no additional customers.
     *
     * @test
     */
    public function a_user_cannot_see_change_customer_if_no_additional_customers_added(): void
    {
        $user = (new UserFactory)->withCustomer()->create();

        $this->signIn($user);

        $this->get('/products')->assertDontSee('Change Customer');
    }

    /**
     * A user can see change customer if they have the admin flag set to true.
     *
     * @test
     */
    public function a_user_can_see_change_customer_if_set_as_admin(): void
    {
        $user = (new UserFactory)->withCustomer()->create([
            'admin' => true,
        ]);

        $this->signIn($user);

        $this->get('/products')->assertSee('Change Customer');
    }

    /**
     * Check that a user can change to a customer they have access to.
     *
     * @test
     */
    public function a_user_with_additional_customers_can_change_customer(): void
    {
        $user = (new UserFactory)->withCustomer()->withUserCustomers(2)->create();

        $this->signIn($user);

        $customer = $user->customers[1]->customer_code;

        $response = $this->post('/account/customer/change', [
            'customer' => $customer,
        ]);

        $response->assertSessionHas('temp_customer')->assertStatus(302);

        $this->assertEquals(session('temp_customer'), $customer);
    }

    /**
     * A user can only change customer account for a customer that they have access to.
     *
     * @test
     */
    public function a_user_cannot_change_customer_to_one_they_dont_have_access(): void
    {
        $user = (new UserFactory)->withCustomer()->withUserCustomers(2)->create();

        $customer = (new CustomerFactory)->create([
            'code' => str_random(8),
        ]);

        $this->signIn($user);

        $response = $this->post('/account/customer/change', [
            'customer' => $customer->code,
        ]);

        $response->assertSessionMissing('temp_customer')->assertStatus(401);

        $this->assertNotEquals(auth()->user()->customer->code, $customer->code);
    }

    /**
     * A user can revert back to their default customer.
     *
     * @test
     */
    public function a_user_can_revert_to_default_customer(): void
    {
        $user = (new UserFactory)->withCustomer()->withUserCustomers(2)->create();

        $this->signIn($user);

        $this->post('/account/customer/change', [
            'customer' => $user->customers[1]->customer_code,
        ]);

        $response = $this->get('/account/customer/revert');

        $response->assertSessionMissing('temp_customer');

        $this->assertNotEquals(auth()->user()->customer->code, $user->customers[1]->customer_code);
    }
}

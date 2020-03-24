<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\UserFactory;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function terms_and_conditions_shows_the_correct_data_on_cms(): void
    {
        $user = factory(Admin::class)->create();

        $this->adminSignIn($user);

        $this->get(route('cms.pages.terms'))->assertSee('Terms & Conditions will go here');
    }

    /**
     * @test
     */
    public function terms_and_conditions_shows_the_correct_data_on_website(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->get(route('support.terms'))->assertSee('Terms & Conditions will go here');
    }

    /**
 * @test
 */
    public function data_protection_shows_the_correct_data_on_cms(): void
    {
        $user = factory(Admin::class)->create();

        $this->adminSignIn($user);

        $this->get(route('cms.pages.data-protection'))->assertSee('Data Protection will go here');
    }

    /**
     * @test
     */
    public function data_protection_shows_the_correct_data_on_website(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->get(route('support.data'))->assertSee('Data Protection will go here');
    }

    /**
     * @test
     */
    public function accessibility_policy_shows_the_correct_data_on_cms(): void
    {
        $user = factory(Admin::class)->create();

        $this->adminSignIn($user);

        $this->get(route('cms.pages.accessibility'))->assertSee('Accessibility Policy will go here');
    }

    /**
     * @test
     */
    public function accessibility_policy_shows_the_correct_data_on_website(): void
    {
        $user = (new UserFactory())->withCustomer()->create();

        $this->signIn($user);

        $this->get(route('support.accessibility'))->assertSee('Accessibility Policy will go here');
    }
}

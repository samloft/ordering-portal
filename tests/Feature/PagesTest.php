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

    /**
     * @test
     */
    public function terms_can_be_updated(): void
    {
        $admin = factory(Admin::class)->create();
        $this->adminSignIn($admin);

        $user = (new UserFactory())->withCustomer()->create();
        $this->signIn($user);

        $terms = [
            'name' => 'terms-and-conditions',
            'description' => 'NEW TERMS',
        ];

        $this->post(route('cms.pages.store'), $terms);

        $this->assertDatabaseHas('pages', $terms);

        $this->get(route('support.terms'))->assertSee($terms['description']);
    }

    /**
     * @test
     */
    public function data_protection_can_be_updated(): void
    {
        $admin = factory(Admin::class)->create();
        $this->adminSignIn($admin);

        $user = (new UserFactory())->withCustomer()->create();
        $this->signIn($user);

        $data_protection = [
            'name' => 'data-protection',
            'description' => 'NEW DATA PROTECTION',
        ];

        $this->post(route('cms.pages.store'), $data_protection);

        $this->assertDatabaseHas('pages', $data_protection);

        $this->get(route('support.data'))->assertSee($data_protection['description']);
    }

    /**
     * @test
     */
    public function accessibility_policy_can_be_updated(): void
    {
        $admin = factory(Admin::class)->create();
        $this->adminSignIn($admin);

        $user = (new UserFactory())->withCustomer()->create();
        $this->signIn($user);

        $accessibility_policy = [
            'name' => 'accessibility-policy',
            'description' => 'NEW ACCESSIBILITY POLICY',
        ];

        $this->post(route('cms.pages.store'), $accessibility_policy);

        $this->assertDatabaseHas('pages', $accessibility_policy);

        $this->get(route('support.accessibility'))->assertSee($accessibility_policy['description']);
    }
}
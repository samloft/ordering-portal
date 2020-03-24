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
}

<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\CompanyDetailsController
 */
class CompanyDetailsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.company-information'));

        $response->assertOk();
        $response->assertViewIs('company-information.index');
        $response->assertViewHas('company_details');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->post(route('cms.company-information.store'), [
                'company_name' => 'Example Company',
            ]);

        $response->assertRedirect();
    }
}

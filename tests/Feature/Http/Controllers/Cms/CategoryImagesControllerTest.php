<?php

namespace Tests\Feature\Http\Controllers\Cms;

use App\Models\Admin;
use App\Models\CategoryImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Cms\CategoryImagesController
 */
class CategoryImagesControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $category_image = factory(CategoryImage::class)->create();

        $response = $this->actingAs($user, 'admin')
            ->delete(route('cms.category-images.destroy', ['id' => $category_image->id]));

        $response->assertOk();
        $this->assertDeleted($category_image);
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user, 'admin')->get(route('cms.category-images'));

        $response->assertOk();
        $response->assertViewIs('category-images.index');
        $response->assertViewHas('images');
        $response->assertViewHas('category_top_level');
    }

    ///**
    // * @test
    // */
    //public function store_returns_an_ok_response(): void
    //{
    //    $user = factory(Admin::class)->create();
    //
    //    $response = $this->actingAs($user, 'admin')
    //        ->post(route('cms.category-images.store'), [
    //            'level_1' => 'Level One',
    //            'level_2' => 'Level Two',
    //            'level_3' => 'Level Three',
    //            'file' => '',
    //        ]);
    //
    //    $response->assertCreated();
    //}
}

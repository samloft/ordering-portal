<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\CategoryImage;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');
});

test('returns an ok response', function () {
    $this->get(route('cms.category-images'))->assertOk();
});

test('can be deleted', function () {
    $category_image = factory(CategoryImage::class)->create();

    $this->delete(route('cms.category-images.destroy', ['id' => $category_image->id]))->assertOk();

    $this->assertDeleted($category_image);
});

test('can be created', function () {
    $category = factory(Category::class)->create();

    $this->post(route('cms.category-images.store'), [
        'level_1' => $category->level_1,
        'level_2' => $category->level_2,
        'level_3' => $category->level_3,
        'file' => UploadedFile::fake()->create('image.png'),
    ])->assertOk();

    $this->assertDatabaseHas('category_images', [
        'level_1' => $category->level_1,
    ]);
});

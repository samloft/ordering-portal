<?php

use App\Models\Admin;
use App\Models\HomeLink;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = factory(Admin::class)->create();

    actingAs($this->user, 'admin');

    Storage::fake('public');
});

test('returns an ok response', function () {
    $this->get(route('cms.home-links'))->assertOk();
});

test('can be created', function () {
    $home_link = [
        'type' => 'category',
        'name' => 'Link',
        'url' => '/url',
        'position' => 1,
        'file' => UploadedFile::fake()->image('link.png'),
    ];

    $this->post(route('cms.home-links.store'), $home_link)->assertOk();

    $this->assertDatabaseHas('home_links', [
        'name' => $home_link['type'].'-'.$home_link['name'],
    ]);

    Storage::disk('public')->assertExists('/'.config('app.name').'/category/category-link.png');
});

test('can be deleted', function () {
    $home_link = factory(HomeLink::class)->create();

    $this->delete(route('cms.home-links.delete', ['id' => $home_link->id]))->assertOk();

    $this->assertDatabaseMissing('home_links', [
        'name' => $home_link->name,
    ]);

    Storage::disk('public')->assertMissing('/'.config('app.name').'/'.$home_link->category.'/'.$home_link->image);
});

test('position can be updated', function () {
    $home_links = factory(HomeLink::class, 2)->create([
        'type' => 'category',
    ]);

    $this->json('patch', route('cms.home-links.update'), [
        ['id' => $home_links->first()->id, 'position' => 2],
        ['id' => $home_links->skip(1)->take(1)->first()->id, 'position' => 1],
    ])->assertOk();

    $this->assertDatabaseHas('home_links', [
        'id' => $home_links->first()->id,
        'position' => 2,
    ]);

    $this->assertDatabaseHas('home_links', [
        'id' => $home_links->skip(1)->take(1)->first()->id,
        'position' => 1,
    ]);
});

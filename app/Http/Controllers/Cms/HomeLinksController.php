<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomeLink;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeLinksController extends Controller
{
    /**
     * Display all current categories + adverts.
     *
     * @return Factory|View
     */
    public function index()
    {
        $adverts = HomeLink::adverts();
        $category_top_level = Category::show(1);
        $categories = HomeLink::categories();
        $banners = HomeLink::banners();

        return view('home-links.index', compact('category_top_level', 'categories', 'adverts', 'banners'));
    }

    /**
     * Create a new home link.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(): JsonResponse
    {
        request()->validate([
            'name' => 'required|unique:home_links',
            'url' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);

        $home_link = HomeLink::store();

        return response()->json([
            'created' => true,
            'data' => $home_link,
        ]);
    }

    /**
     * Take the list of items and update the position based on the ID.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePositions(): JsonResponse
    {
        HomeLink::updatePositions(request()->all());

        return response()->json([
            'updated' => true,
        ]);
    }

    /**
     * Deletes a home link with the given ID.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function destroy($id): JsonResponse
    {
        $link = HomeLink::findOrFail($id);

        $link->delete();

        Storage::disk('public')->delete('/'.config('app.name').'/'.$link->type.'/'.$link->image);

        return response()->json([
            'deleted' => true,
        ]);
    }
}

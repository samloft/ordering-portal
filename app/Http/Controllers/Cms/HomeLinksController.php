<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\HomeLink;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $categories = HomeLink::categories();

        return view('home-links.index', compact('adverts', 'categories'));
    }

    /**
     * Create a new home link.
     */
    public function store()
    {
        request()->validate([
            'name' => 'required',
            'url' => 'required',
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);

        //if (request()->id) {
        //    $store = HomeLink::edit(request());
        //
        //    return $store ? back()->with('success', 'Home link has been updated') : back()->with('error', 'Unable to update home link, please try again');
        //}

        $home_link = HomeLink::store(request());

        if ($home_link) {
            return response()->json([
                'created' => true,
                'data' => $home_link
            ]);
        }

        return response()->json([
            'created' => false
        ], 400);
    }

    /**
     * Take the list of items and update the position based on the ID.
     *
     * @param Request $request
     *
     * @return array
     */
    public function updatePositions(Request $request): array
    {
        $link_items = [];

        foreach ($request->items as $item) {
            $row = json_decode($item, true);

            $link_items[] = [
                'id' => (int) $row->id,
                'position' => $row->position,
            ];
        }

        if ($link_items) {
            $positions = HomeLink::updatePositions($link_items);

            return [
                'success' => $positions,
            ];
        }

        return [
            'success' => false,
        ];
    }

    /**
     * Deletes a home link with the given ID.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     *
     */
    public function destroy($id): JsonResponse
    {
        if(HomeLink::destroy($id)) {
            return response()->json([
                'deleted' => true
            ]);
        }

        return response()->json([
            'deleted' => false
        ], 400);
    }
}

<?php

namespace App\Http\Controllers\Cms;

use App\Models\HomeLinks;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $adverts = HomeLinks::adverts();
        $categories = HomeLinks::categories();

        return view('cms.home-links.index', compact('adverts', 'categories'));
    }

    /**
     * Create a new home link.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->id) {
            $store = HomeLinks::edit($request);

            return $store ? back()->with('success', 'Home link has been updated') : back()->with('error', 'Unable to update home link, please try again');
        }

        $store = HomeLinks::store($request);

        return $store ? back()->with('success', 'New home link has been created') : back()->with('error', 'Unable to create new home link, please try again');
    }

    /**
     * Take the list of items and update the position based on the ID.
     *
     * @param Request $request
     * @return array
     */
    public function updatePositions(Request $request): array
    {
        $link_items = [];

        foreach ($request->items as $item) {
            $row = json_decode($item, true);

            $link_items[] = [
                'id' => (int)$row->id,
                'position' => $row->position
            ];
        }

        if ($link_items) {
            $positions = HomeLinks::updatePositions($link_items);

            return [
                'success' => $positions
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     * Deletes a home link with the given ID.
     *
     * @param $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy($id): RedirectResponse
    {
        $deleted = HomeLinks::destroy($id);

        return $deleted ? back()->with('success', 'Home link has been deleted') : back()->with('error', 'Unable to delete home link, please try again');
    }
}

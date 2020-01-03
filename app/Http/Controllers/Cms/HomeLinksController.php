<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\HomeLink;
use Exception;
use Illuminate\Contracts\View\Factory;
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

        return view('cms.home-links.index', compact('adverts', 'categories'));
    }

    /**
     * Create a new home link.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->id) {
            $store = HomeLink::edit($request);

            return $store ? back()->with('success', 'Home link has been updated') : back()->with('error', 'Unable to update home link, please try again');
        }

        $store = HomeLink::store($request);

        return $store ? back()->with('success', 'New home link has been created') : back()->with('error', 'Unable to create new home link, please try again');
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
                'id'       => (int) $row->id,
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
     * @throws Exception
     *
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $deleted = HomeLink::destroy($id);

        return $deleted ? back()->with('success', 'Home link has been deleted') : back()->with('error', 'Unable to delete home link, please try again');
    }
}

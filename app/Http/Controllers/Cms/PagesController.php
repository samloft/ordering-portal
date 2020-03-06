<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataProtection()
    {
        $data = [
            'key' => 'data-protection',
            'title' => 'Data protection',
            'description' => 'Add information regarding data protection to display on the page.',
            'data' => Page::show('data-protection')->description,
        ];

        return view('pages.index', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function terms()
    {
        $data = [
            'key' => 'terms-and-conditions',
            'title' => 'Terms & Conditions',
            'description' => 'The terms & conditions to be displayed on the site',
            'data' => Page::show('terms-and-conditions')->description,
        ];

        return view('pages.index', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accessibility()
    {
        $data = [
            'key' => 'accessibility-policy',
            'title' => 'Accessibility Policy',
            'description' => 'The accessibility policy to be displayed on the site',
            'data' => Page::show('accessibility-policy')->description,
        ];

        return view('pages.index', compact('data'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(): RedirectResponse
    {
        $page = Page::where('name', request('key'))->firstOrFail();

        $page->description = request('description');

        if ($page->save()) {
            return back()->with('success', 'Page has been updated');
        }

        return back()->with('error', 'Unable to update this page, please try again');
    }
}

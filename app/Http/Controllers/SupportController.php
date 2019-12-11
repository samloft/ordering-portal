<?php

namespace App\Http\Controllers;

use App\Models\Page;

class SupportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_name = request()->route()->getAction()['page'];

        $content = Page::show($page_name)->description;

        return view('support.index', compact('content'));
    }
}

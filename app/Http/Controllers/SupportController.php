<?php

namespace App\Http\Controllers;

use App\Models\Page;
use League\CommonMark\CommonMarkConverter;

class SupportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $page_name = request()->route()->getAction()['page'];

        $converter = new CommonMarkConverter();

        $support = Page::show($page_name);
        $support->description = $converter->convertToHtml($support->description);

        return view('support.index', compact('support'));
    }
}

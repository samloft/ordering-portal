<?php

namespace App\Http\Controllers\Support;

use App\Models\SupportPages;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TermsController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $title = 'Terms & Conditions';
        $content = SupportPages::show('terms-and-conditions')->description;

        return view('support.pages', compact('content', 'title'));
    }
}

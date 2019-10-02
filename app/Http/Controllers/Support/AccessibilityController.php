<?php

namespace App\Http\Controllers\Support;

use App\Models\SupportPages;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AccessibilityController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $title = 'Accessibility Policy';
        $content = SupportPages::show('accessibility-policy')->description;

        return view('support.pages', compact('content', 'title'));
    }
}

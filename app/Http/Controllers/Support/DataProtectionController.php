<?php

namespace App\Http\Controllers\Support;

use App\Models\SupportPages;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DataProtectionController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $title = 'Data Protection';
        $content = SupportPages::show('data-protection')->description;

        return view('support.pages', compact('content', 'title'));
    }
}

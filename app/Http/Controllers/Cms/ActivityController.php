<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $logs = Activity::where('causer_type', 'App\Models\Admin')->orderBy('created_at', 'desc')->paginate(10);

        return view('activity.index', compact('logs'));
    }
}

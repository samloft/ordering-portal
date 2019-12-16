<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OrderTrackingHeader;
use App\Models\User;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $stats = [
            'users' => User::countAll(),
            'orders-today' => OrderTrackingHeader::todayCount()
        ];

        return view('dashboard.index', compact('stats'));
    }
}

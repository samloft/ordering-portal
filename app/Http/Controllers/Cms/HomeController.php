<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OrderHeader;
use App\Models\User;
use Carbon\Carbon;

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
            'orders-today' => OrderHeader::where('created_at', Carbon::today())->count(),
            'pending-orders' => OrderHeader::where('imported', false)->orderBy('created_at', 'asc')->get(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}

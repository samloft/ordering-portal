<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking\Header;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Options;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the report page for a user to choose a report.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('reports.index');
    }

    public function show(Request $request)
    {
        if ($request->report == 'back_orders') {
            $back_orders = Header::backOrders();

            if (count($back_orders) > 0) {
                $pdf = PDF::loadView('reports.back-orders', compact('back_orders'));

                return $pdf->download('back_orders.pdf');
            }

            return back()->with('error', 'You dont currently have any back orders to display');
        }

        if ($request->report == 'account_summary') {
            dd('Account Summary');
        }

        return abort(404);
    }
}

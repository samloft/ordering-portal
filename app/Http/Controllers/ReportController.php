<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking\Header;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * Display the report page for a user to choose a report.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Generate a report based on the type & output.
     *
     * @param Request $request
     * @return RedirectResponse|Response|BinaryFileResponse|void
     */
    public function show(Request $request)
    {
        $output = $request->output;

        if ($request->report == 'back_orders') {
            return $this->backOrderReport($output);
        }

        if ($request->report == 'account_summary') {
            return $this->accountSummaryReport($output);
        }

        return abort(404);
    }

    /**
     * Generate the back order report.
     *
     * @param $output
     * @return RedirectResponse|Response|BinaryFileResponse
     */
    public function backOrderReport($output)
    {
        $back_orders = Header::backOrders();

        if (count($back_orders) > 0) {
            if ($output == 'pdf') {
                $pdf = PDF::loadView('reports.back-orders', compact('back_orders'));

                return $pdf->download('back_orders.pdf');
            }

            if ($output == 'csv') {
                $headings = [
                    'Order Number', 'Product', 'Description', 'Ordered', 'Outstanding', 'Next Expecting',
                ];

                $lines = [];

                foreach ($back_orders as $back_order) {
                    $lines[] = [
                        $back_order->order_no,
                        $back_order->product,
                        $back_order->long_description,
                        Carbon::parse($back_order->date_received)->format('d-m-Y'),
                        $back_order->line_qty,
                        $back_order->due_date ? Carbon::parse($back_order->due_date)->format('d-m-Y') : 'Unknown',
                    ];
                }

                return $this->createCSV('back_orders.csv', $headings, $lines);
            }
        }

        return back()->with('error', 'You dont currently have any back orders to display');
    }

    public function accountSummaryReport($output)
    {
        return back()->with('error', 'You dont currently have an order summary to display.');
    }

    /**
     * Create a CSV file from the passed headings and lines array.
     *
     * @param $filename
     * @param $headings
     * @param $lines
     * @return BinaryFileResponse
     */
    public function createCSV($filename, $headings, $lines)
    {
        $handle = fopen($filename, 'w+');

        fputcsv($handle, $headings);

        foreach ($lines as $line) {
            fputcsv($handle, $line);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/css'
        ];

        return response()->download($filename, $filename, $headers);
    }
}

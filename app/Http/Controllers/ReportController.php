<?php

namespace App\Http\Controllers;

use App\Models\AccountSummary;
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
        ini_set('memory_limit', '256M');

        $invoice_lines = AccountSummary::show();

        if (count($invoice_lines) > 0) {
            $summary = AccountSummary::summary();
            $summary_lines = [];
            $total_outstanding = 0;


            foreach ($summary as $key => $value) {
                $summary_lines[$value->age] = $value->price;

                $total_outstanding = $total_outstanding + $value->price;
            }

            $summary_lines['Total Outstanding'] = $total_outstanding;

            if ($output == 'pdf') {
                $pdf = PDF::loadView('reports.account-summary', compact('invoice_lines', 'summary_lines'));

                return $pdf->download('account_summary.pdf');
            }

            if ($output == 'csv') {
                $total_price = 0;
//
                $summary_headings[] = ['Total Outstanding'];
                $summary_detail = [];

                foreach ($summary_lines as $summary_line) {
                    $summary_headings[] = [
                        $summary_line->age
                    ];

                    $summary_detail[] = [
                        $summary_line->price
                    ];

                    $total_price = $total_price = $summary_line->price;
                }

                $summary_detail[] = [
                    $total_price
                ];
//
//                array_unshift($summary_detail, [$total_price]);
//
                $invoice_headings = [
                    'Invoice No.', 'Order No.', 'Invoice Date', 'Due Date', 'Amount'
                ];

                $headings = $invoice_headings;
//
//                $headings = array_merge($summary_headings, $summary_detail, $invoice_headings);

                $lines = [];

                foreach ($invoice_lines as $invoice_line) {
                    $lines[] = [
                        $invoice_line->item_no,
                        $invoice_line->reference,
                        Carbon::parse($invoice_line->dated)->format('d-m-Y'),
                        Carbon::parse($invoice_line->due_date)->format('d-m-Y'),
                        $invoice_line->unall_curr_amount
                    ];
                }
//
                return $this->createCSV('account_summary.csv', $headings, $lines);
            }
        }

        return back()->with('error', 'You dont currently have an order summary to display.');
    }

    /**
     * Create a CSV file from the passed headings and lines array.
     *
     * @param $filename
     * @param $headings
     * @param $lines
     * @param null $extra_headings
     * @param null $extra_lines
     * @return BinaryFileResponse
     */
    public function createCSV($filename, $headings, $lines, $extra_headings = null, $extra_lines = null)
    {
        $callback = function () use ($headings, $lines, $extra_headings, $extra_lines) {
            $handle = fopen('php://output', 'w+');
            fputcsv($handle, $headings);

            foreach ($lines as $line) {
                fputcsv($handle, $line);
            }

            if ($extra_headings) {
                fputcsv($handle, $extra_headings);
            }

            if ($extra_lines) {
                foreach ($extra_lines as $extra_line) {
                    fputcsv($handle, $extra_line);
                }
            }

            fclose($handle);
        };

        $headers = [
            'Content-Type' => 'text/css'
        ];

        return response()->streamDownload($callback, $filename, $headers);
    }
}

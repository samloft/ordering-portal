<?php

namespace App\Http\Controllers;

use App\Exports\BackOrderExport;
use App\Models\AccountSummary;
use App\Models\GlobalSettings;
use App\Models\OrderTrackingHeader;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsite\Excel\Facades\Excel;

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
     * @return RedirectResponse|Response|BinaryFileResponse|void
     */
    public function show()
    {
        $output = request('output');
        $report = request('report');

        if ($report === 'back_orders') {
            return $this->backOrderReport($output);
        }

        if ($report === 'account_summary') {
            return $this->accountSummaryReport($output);
        }

        return back()->with('error', 'You must select a report to run');
    }

    /**
     * Generate the back order report.
     *
     * @param $output
     *
     * @return RedirectResponse|Response|BinaryFileResponse
     */
    public function backOrderReport($output)
    {
        $back_orders = OrderTrackingHeader::backOrders();

        if (count($back_orders) > 0) {
            if ($output === 'pdf') {
                $company_details = json_decode(GlobalSettings::key('company-details'), true);

                return PDF::loadView('pdf.back-orders', compact('back_orders', 'company_details'))->download('back_orders.pdf');
            }

            if ($output === 'csv') {
                return Excel::download(new BackOrderExport(), 'back-orders.csv');
            }
        }

        return back()->with('error', 'You dont currently have any back orders to display');
    }

    /**
     * @param $output
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
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

                $total_outstanding += $value->price;
            }

            $summary_lines['Total Outstanding'] = $total_outstanding;

            if ($output === 'pdf') {
                $company_details = json_decode(GlobalSettings::key('company-details'), true);

                return PDF::loadView('pdf.account-summary', compact('invoice_lines', 'summary_lines', 'company_details'))->download('account_summary.pdf');
            }

            if ($output === 'csv') {
                $summary_headings = [
                    'Total Outstanding',
                    'Not Due',
                    'Overdue up to 30 days',
                    'Overdue up to 60 days',
                    'Overdue over 60 days',
                ];

                $summary_line[] = [
                    $summary_lines['Total Outstanding'] ?? 0,
                    $summary_lines['Not due'] ?? 0,
                    $summary_lines['Overdue up to 30 day'] ?? 0,
                    $summary_lines['Overdue up to 60 days'] ?? 0,
                    $summary_lines['Over 60 days overdue'] ?? 0,
                ];

                $invoice_headings = [
                    'Invoice No.',
                    'Order No.',
                    'Invoice Date',
                    'Due Date',
                    'Amount',
                ];

                $lines = [];

                foreach ($invoice_lines as $invoice_line) {
                    $lines[] = [
                        $invoice_line->item_no,
                        $invoice_line->reference,
                        Carbon::parse($invoice_line->dated)->format('d-m-Y'),
                        Carbon::parse($invoice_line->due_date)->format('d-m-Y'),
                        $invoice_line->unall_curr_amount,
                    ];
                }

                return $this->createCSV('account_summary.csv', $summary_headings, $summary_line, $invoice_headings, $lines);
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
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function createCSV(
        $filename,
        $headings,
        $lines,
        $extra_headings = null,
        $extra_lines = null
    ) {
        $callback = static function () use ($headings, $lines, $extra_headings, $extra_lines) {
            $handle = fopen('php://output', 'wb+');
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
            'Content-Type' => 'text/css',
        ];

        return response()->streamDownload($callback, $filename, $headers);
    }
}

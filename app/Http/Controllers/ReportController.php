<?php

namespace App\Http\Controllers;

use App\Exports\AccountSummaryExcel;
use App\Exports\AccountSummaryPDF;
use App\Exports\BackOrderExcel;
use App\Exports\BackOrderPDF;
use App\Models\AccountSummary;
use App\Models\OrderTrackingHeader;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
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
     * @return RedirectResponse|Response|BinaryFileResponse|void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
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
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function backOrderReport($output)
    {
        $back_orders = OrderTrackingHeader::backOrders();

        if (count($back_orders) > 0) {
            if ($output === 'pdf') {
                return (new BackOrderPDF($back_orders))->download();
            }

            if ($output === 'csv') {
                return Excel::download(new BackOrderExcel($back_orders), 'back-orders.csv', \Maatwebsite\Excel\Excel::CSV);
            }
        }

        return back()->with('error', 'You dont currently have any back orders to display');
    }

    /**
     * @param $output
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function accountSummaryReport($output)
    {
        ini_set('memory_limit', '256M');

        $invoice_lines = AccountSummary::show();

        if (! $invoice_lines) {
            return back()->with('error', 'You dont currently have an order summary to display.');
        }

        $summary = AccountSummary::summary();
        $summary_lines = [];
        $total_outstanding = 0;

        foreach ($summary as $key => $value) {
            $summary_lines[Str::slug(strtolower($value->age))] = $value->price;

            $total_outstanding += $value->price;
        }

        $summary_line[] = [
            'total-outstanding' => number_format($total_outstanding, 2),
            'not-due' => isset($summary_lines['not-due']) ? number_format($summary_lines['not-due'], 2) : '0.00',
            'overdue-up-to-30-day' => isset($summary_lines['overdue-up-to-30-day']) ? number_format($summary_lines['overdue-up-to-30-day'], 2) : '0.00',
            'overdue-up-to-60-days' => isset($summary_lines['overdue-up-to-60-days']) ? number_format($summary_lines['overdue-up-to-60-days'], 2) : '0.00',
            'over-60-days-overdue' => isset($summary_lines['over-60-days-overdue']) ? number_format($summary_lines['over-60-days-overdue'], 2) : '0.00',
        ];

        $lines = [];

        foreach ($invoice_lines as $invoice_line) {
            $lines[] = [
                'item_no' => $invoice_line->item_no,
                'reference' => $invoice_line->reference,
                'dated' => Carbon::parse($invoice_line->dated)->format('d-m-Y'),
                'due_date' => Carbon::parse($invoice_line->due_date)->format('d-m-Y'),
                'amount' => $invoice_line->unall_curr_amount,
            ];
        }

        if ($output === 'pdf') {
            return (new AccountSummaryPDF($lines, $summary_line))->download();
        }

        return Excel::download(new AccountSummaryExcel($summary_line, $lines), 'account-summary.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}

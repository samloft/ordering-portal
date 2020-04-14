<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class AccountSummaryExcel implements FromCollection
{
    protected $summary;

    protected $invoice_lines;

    /**
     * AccountSummaryExcel constructor.
     *
     * @param $summary
     * @param $invoice_lines
     */
    public function __construct($summary, $invoice_lines)
    {
        $this->summary = $summary;
        $this->invoice_lines = $invoice_lines;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        $summary_headings = [
            'Total Outstanding',
            'Not Due',
            'Overdue up to 30 days',
            'Overdue up to 60 days',
            'Overdue over 60 days',
        ];

        $invoice_headings = [
            'Invoice No.',
            'Order No.',
            'Invoice Date',
            'Due Date',
            'Amount',
        ];

        return collect(array_merge([$summary_headings, $this->summary, $invoice_headings, $this->invoice_lines]));
    }
}

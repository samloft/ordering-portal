<?php

namespace App\Exports;

use App\Models\GlobalSettings;
use Barryvdh\DomPDF\Facade as PDF;

class AccountSummaryPDF
{
    protected $lines;

    protected $summary_line;

    /**
     * ConfirmationPDF constructor.
     *
     * @param $lines
     * @param $summary_line
     */
    public function __construct($lines, $summary_line)
    {
        $this->lines = $lines;
        $this->summary_line = $summary_line;
    }

    /**
     * @return mixed
     */
    public function download()
    {
        $lines = $this->lines;
        $summary_line = $this->summary_line;
        $company_details = json_decode(GlobalSettings::key('company-details'), true);

        return PDF::loadView('pdf.account-summary', compact('lines', 'summary_line', 'company_details'))
            ->download('account_summary.pdf');
    }
}

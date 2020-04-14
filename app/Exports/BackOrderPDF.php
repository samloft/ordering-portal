<?php

namespace App\Exports;

use App\Models\GlobalSettings;
use Barryvdh\DomPDF\Facade as PDF;

class BackOrderPDF
{
    protected $back_orders;

    /**
     * ConfirmationPDF constructor.
     *
     * @param $back_orders
     */
    public function __construct($back_orders)
    {
        $this->back_orders = $back_orders;
    }

    /**
     * @return mixed
     */
    public function download()
    {
        $back_orders = $this->back_orders;
        $company_details = json_decode(GlobalSettings::key('company-details'), true);

        return PDF::loadView('pdf.back-orders', compact('back_orders', 'company_details'))->download('back_orders.pdf');
    }
}

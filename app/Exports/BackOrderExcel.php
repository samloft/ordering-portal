<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BackOrderExcel implements FromCollection, WithHeadings
{
    protected $back_orders;

    /**
     * AccountSummaryExcel constructor.
     *
     * @param $back_orders
     */
    public function __construct($back_orders)
    {
        $this->back_orders = $back_orders;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        $orders = [];

        $results = $this->back_orders;

        foreach ($results as $result) {
            $orders[] = [
                'Order Number' => $result->order_no,
                'Product' => $result->product,
                'Description' => $result->long_description,
                'Ordered' => Carbon::parse($result->date_received)->format('d-m-Y'),
                'Outstanding' => $result->line_qty,
                'Next Expecting' => $result->due_date ? Carbon::parse($result->due_date)->format('d-m-Y') : 'Unknown',
            ];
        }

        return collect($orders);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}

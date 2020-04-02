<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\OrderTrackingHeader;

class BackOrderExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        $orders = [];

        $results = OrderTrackingHeader::backOrders();

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

<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductPricesExport extends ExportStyling implements FromCollection, WithHeadings
{
    protected $brand;

    protected $range;

    /**
     * ProductDataExport constructor.
     *
     * @param $brand
     * @param $range
     */
    public function __construct($brand, $range)
    {
        $this->brand = $brand;
        $this->range = $range;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        $products = [];

        $results = Product::with('prices')->with('categories')->whereHas('prices')->where('obsolete', false)->whereHas('categories', function ($query) {
            if ($this->brand) {
                $query->where('level_1', $this->brand);
            }

            if ($this->range) {
                $query->where('level_2', $this->range);
            }
        })->get();

        foreach ($results as $result) {
            $products[] = [
                'Product' => $result->code,
                'Description' => $result->description,
                'Brand' => $result->categories->level_1 ?? null,
                'Range' => $result->categories->level_2 ?? null,
                'Luckins Code' => $result->luckins_code,
                'Trade Price' => $result->trade_price,
                'Net Price' => number_format($result->prices->price, 4),
                'Online Discount Price' => discount($result->prices->price),
                'QTY Break 1' => $result->prices->break1,
                'Online Price Break 1' => discount($result->prices->price1),
                'QTY Break 2' => $result->prices->break2,
                'Online Price Break 2' => discount($result->prices->price2),
                'QTY Break 3' => $result->prices->break1,
                'Online Price Break 3' => discount($result->prices->price3),
            ];
        }

        return collect($products);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return array_keys($this->collection()->first());
    }
}

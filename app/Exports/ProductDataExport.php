<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductDataExport extends ExportStyling implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        $products = [];

        $results = Product::with('prices')->with('categories')->whereHas('prices')->where('obsolete', false)->get();

        foreach ($results as $result) {
            $products[] = [
                'Product' => $result->code,
                'Short Description' => $result->name,
                'Long Description' => $result->description,
                'Category Level 1' => $result->categories->level_1 ?? null,
                'Category Level 2' => $result->categories->level_2 ?? null,
                'Category Level 3' => $result->categories->level_3 ?? null,
                'Outer Box Quantity' => $result->outer_box_qty,
                'Inner Box Quantity' => $result->order_multiples,
                'Luckins Code' => $result->luckins_code,
                'Trade Price' => $result->trade_price,
                'Product Barcode' => $result->product_barcode,
                'Inner Barcode' => $result->inner_barcode,
                'Outer Barcode' => ' '.$result->outer_barcode,
                'Product Net Weight (KG)' => $result->net_weight,
                'Product Gross Weight (KG)' => $result->gross_weight,
                'Outer Length (mm)' => $result->length,
                'Outer Width (mm)' => $result->width,
                'Outer Height (mm)' => $result->height,
                'Image URL' => $result->localImagePath(),
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

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER,
            'L' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}

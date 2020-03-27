<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ExportStyling implements ShouldAutoSize, WithEvents
{
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => static function (AfterSheet $event) {
                $endColumn = $event->sheet->getDelegate()->getHighestColumn();
                $endRow = $event->sheet->getDelegate()->getHighestRow();

                $headerStyle = [
                    'font' => [
                        'size' => 16,
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'E5E4E2'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A1:'.$endColumn.'1')->applyFromArray($headerStyle);

                $rowStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                $event->sheet->getDelegate()->getStyle('A2:'.$endColumn.$endRow)->applyFromArray($rowStyle);

                $event->sheet->getDelegate()->getStyle('A2');
            },
        ];
    }
}

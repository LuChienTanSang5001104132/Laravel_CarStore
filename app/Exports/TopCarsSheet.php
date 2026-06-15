<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TopCarsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Xe Bán Chạy';
    }

    public function headings(): array
    {
        return ['Tên Xe', 'Hãng', 'Giá (VNĐ)', 'Số Lượng Bán', 'Doanh Thu (VNĐ)'];
    }

    public function collection()
    {
        return collect($this->data['top_cars'])->map(fn($car) => [
            $car->name,
            $car->brand,
            number_format($car->price, 0, ',', '.'),
            $car->total_sold,
            number_format($car->total_revenue, 0, ',', '.'),
        ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 30, 'B' => 20, 'C' => 22, 'D' => 18, 'E' => 25];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

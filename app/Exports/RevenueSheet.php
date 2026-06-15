<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Doanh Thu Theo Tháng';
    }

    public function headings(): array
    {
        return ['Tháng', 'Doanh Thu (VNĐ)', 'Số Đơn Hàng'];
    }

    public function collection()
    {
        return collect($this->data['revenue_by_month'])->map(fn($row) => [
            'Tháng ' . $row->month . '/' . $this->data['year'],
            number_format($row->revenue, 0, ',', '.'),
            $row->orders,
        ]);
    }

    public function columnWidths(): array
    {
        return ['A' => 20, 'B' => 25, 'C' => 18];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}

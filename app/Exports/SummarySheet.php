<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummarySheet implements FromArray, WithTitle, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function title(): string
    {
        return 'Tổng Quan';
    }

    public function array(): array
    {
        $period = $this->data['month']
            ? 'Tháng ' . $this->data['month'] . '/' . $this->data['year']
            : 'Năm ' . $this->data['year'];

        return [
            ['BÁO CÁO KINH DOANH - CARSTORE'],
            [''],
            ['Kỳ báo cáo',     $period],
            ['Xuất lúc',       $this->data['generated_at']],
            [''],
            ['TỔNG QUAN'],
            ['Tổng doanh thu', number_format($this->data['total_revenue'], 0, ',', '.') . ' ₫'],
            ['Tổng đơn hàng',  $this->data['total_orders'] . ' đơn'],
            ['Tổng khách hàng',$this->data['total_customers'] . ' người'],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 25, 'B' => 35];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            6 => ['font' => ['bold' => true]],
        ];
    }
}

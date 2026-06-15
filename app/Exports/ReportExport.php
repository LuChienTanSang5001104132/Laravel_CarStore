<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// FIXED: File này chỉ chứa class chính ReportExport.
// RevenueSheet và TopCarsSheet được tách ra file riêng để autoload hoạt động đúng.
class ReportExport implements WithMultipleSheets
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new RevenueSheet($this->data),
            new TopCarsSheet($this->data),
            new SummarySheet($this->data),
        ];
    }
}

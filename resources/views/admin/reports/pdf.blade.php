<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Kinh Doanh - CarStore</title>
    <style>
        body        { font-family: DejaVu Sans, sans-serif; margin: 20px; font-size: 13px; color: #1e293b; }
        h1          { text-align: center; color: #1e40af; margin: 0; font-size: 20px; }
        h2          { text-align: center; color: #334155; margin: 4px 0; font-size: 15px; }
        .header     { text-align: center; margin-bottom: 25px; border-bottom: 2px solid #1e40af; padding-bottom: 12px; }
        .header p   { margin: 4px 0; color: #64748b; font-size: 12px; }

        .summary        { width: 100%; margin: 20px 0; }
        .summary td     { width: 33%; padding: 5px; }
        .card           { border: 1px solid #cbd5e1; padding: 12px; border-radius: 8px;
                          text-align: center; background: #f8fafc; }
        .card h3        { margin: 0 0 6px 0; color: #64748b; font-size: 11px; text-transform: uppercase; }
        .card .value    { font-size: 20px; font-weight: bold; color: #1e40af; }

        h3.section      { color: #1e40af; border-bottom: 1px solid #bfdbfe; padding-bottom: 4px;
                          margin-top: 25px; font-size: 14px; }

        table           { width: 100%; border-collapse: collapse; margin: 12px 0; }
        th, td          { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: left; }
        th              { background-color: #1e40af; color: white; font-size: 12px; }
        tr:nth-child(even) td { background: #f1f5f9; }
        td.num          { text-align: right; }

        .footer         { text-align: center; margin-top: 40px; color: #94a3b8; font-size: 11px;
                          border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

<div class="header">
    <h1>BÁO CÁO KINH DOANH</h1>
    <h2>CỬA HÀNG XE HƠI CARSTORE</h2>
    <p>
        Kỳ báo cáo: <strong>{{ $month ? 'Tháng '.$month.'/'.$year : 'Năm '.$year }}</strong>
        &nbsp;|&nbsp; Xuất lúc: {{ $generated_at }}
    </p>
</div>

{{-- Tổng quan --}}
<table class="summary">
    <tr>
        <td>
            <div class="card">
                <h3>Tổng Doanh Thu</h3>
                {{-- FIXED: total_revenue được tính từ total_amount --}}
                <div class="value">{{ number_format($total_revenue, 0, ',', '.') }} ₫</div>
            </div>
        </td>
        <td>
            <div class="card">
                <h3>Tổng Đơn Hàng</h3>
                <div class="value">{{ number_format($total_orders) }}</div>
            </div>
        </td>
        <td>
            <div class="card">
                <h3>Tổng Khách Hàng</h3>
                <div class="value">{{ number_format($total_customers) }}</div>
            </div>
        </td>
    </tr>
</table>

{{-- Doanh thu theo tháng --}}
<h3 class="section">DOANH THU THEO THÁNG - NĂM {{ $year }}</h3>
<table>
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Doanh Thu</th>
            <th>Số Đơn Hàng</th>
        </tr>
    </thead>
    <tbody>
        @foreach($revenue_by_month as $row)
        <tr>
            <td>Tháng {{ $row->month }} / {{ $year }}</td>
            {{-- FIXED: dữ liệu đến từ total_amount --}}
            <td class="num">{{ number_format($row->revenue, 0, ',', '.') }} ₫</td>
            <td class="num">{{ $row->orders }} đơn</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Top xe bán chạy --}}
<h3 class="section">TOP XE BÁN CHẠY NHẤT</h3>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Tên Xe</th>
            <th>Hãng</th>       {{-- FIXED: lấy từ brands table --}}
            <th>Giá niêm yết</th>
            <th>Số Lượng Bán</th>
            <th>Doanh Thu</th>
        </tr>
    </thead>
    <tbody>
        @foreach($top_cars as $i => $car)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $car->name }}</td>
            <td>{{ $car->brand }}</td>
            <td class="num">{{ number_format($car->price, 0, ',', '.') }} ₫</td>
            <td class="num">{{ $car->total_sold }} chiếc</td>
            <td class="num">{{ number_format($car->total_revenue, 0, ',', '.') }} ₫</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Báo cáo được tạo tự động bởi Hệ thống Quản trị CarStore &nbsp;|&nbsp; {{ $generated_at }}
</div>

</body>
</html>

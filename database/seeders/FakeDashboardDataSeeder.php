<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FakeDashboardDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Lấy danh sách ID của User và Xe hiện có trong DB
        $users = User::all();
        $cars = Car::all();

        if ($users->isEmpty() || $cars->isEmpty()) {
            $this->command->error('Vui lòng đảm bảo bảng users và cars đã có dữ liệu trước!');
            return;
        }

        $this->command->info('Đang tạo dữ liệu fake cho 6 tháng...');

        // 2. Chạy vòng lặp cho 6 tháng (từ tháng hiện tại lùi về 5 tháng trước)
        for ($i = 5; $i >= 0; $i--) {
            $currentMonth = Carbon::now()->subMonths($i);
            
            // Random số lượng đơn hàng trong tháng này (từ 5 đến 15 đơn)
            $orderCount = rand(1, 5);

            for ($j = 0; $j < $orderCount; $j++) {
                // Tạo ngày giờ mua hàng ngẫu nhiên trong tháng đó
                $randomDay = rand(1, $currentMonth->daysInMonth);
                $orderDate = $currentMonth->copy()->day($randomDay)->setHour(rand(8, 20))->setMinute(rand(0, 59));

                $randomUser = $users->random();

                // 3. Tạo Đơn hàng (Order) với CÁC CỘT ĐÃ ĐƯỢC CHUẨN HÓA
                $order = Order::create([
                    'user_id' => $randomUser->id,
                    'total_amount' => 0, // Tạm để 0, lát cộng dồn chi tiết tính sau
                    'status' => 'delivered', // Đã khớp với Enum của bạn
                    'payment_status' => 'paid', // Cập nhật trạng thái thanh toán
                    'payment_method' => 'Bank Transfer',
                    'customer_full_name' => $randomUser->name ?? 'Khách Hàng', // Lấy tên user
                    'customer_address' => '123 Đường Số 1, Quận 1, TP.HCM',
                    'customer_phone' => '09' . rand(10000000, 99999999),
                    'notes' => 'Giao hàng giờ hành chính',
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]);

                $totalAmount = 0;
                
                // Random mỗi đơn hàng sẽ mua từ 1 đến 2 loại xe
                $itemCount = rand(1, 2);
                $selectedCars = $cars->random($itemCount);

                // 4. Tạo Chi tiết đơn hàng (Order Items)
                foreach ($selectedCars as $car) {
                    $quantity = rand(1, 3); // Mua 1 đến 3 chiếc
                    $price = $car->price ?? 500000000; // Đề phòng xe chưa có giá

                    OrderItem::create([
                        'order_id' => $order->id,
                        'car_id' => $car->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ]);

                    $totalAmount += ($quantity * $price);
                }

                // Cập nhật lại tổng tiền thực tế của đơn hàng (dùng total_amount)
                $order->update(['total_amount' => $totalAmount]);
            }
        }

        $this->command->info('Đã fake dữ liệu thành công! Hãy vào Dashboard kiểm tra nhé.');
    }
}
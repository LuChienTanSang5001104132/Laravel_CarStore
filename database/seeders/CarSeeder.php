<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Tạo 5 hãng xe (Nếu chưa có thì tạo mới)
        $brands = [
            'Toyota' => Brand::firstOrCreate(['name' => 'Toyota']),
            'Honda' => Brand::firstOrCreate(['name' => 'Honda']),
            'Ford' => Brand::firstOrCreate(['name' => 'Ford']),
            'BMW' => Brand::firstOrCreate(['name' => 'BMW']),
            'VinFast' => Brand::firstOrCreate(['name' => 'VinFast']),
        ];

        // 2. Danh sách 15 chiếc xe cực chất
        $carsData = [
            // ================= TOYOTA =================
            [
                'brand_id' => $brands['Toyota']->id,
                'name' => 'Toyota Camry 2.5Q',
                'price' => 2405,
                'quantity' => 10,
                'year' => 2024,
                'type' => 'Sedan',
                'color' => 'Trắng, Đen',
                'fuel_type' => 'Xăng',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.5L',
                'seats' => 5,
                'description' => 'Mẫu Sedan hạng D cao cấp mang đến trải nghiệm êm ái, sang trọng và công nghệ an toàn Toyota Safety Sense.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Toyota']->id,
                'name' => 'Toyota Fortuner Legender',
                'price' => 1259000000,
                'quantity' => 8,
                'year' => 2023,
                'type' => 'SUV',
                'color' => 'Đen, Trắng ngọc trai',
                'fuel_type' => 'Dầu',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.4L',
                'seats' => 7,
                'description' => 'Mẫu SUV 7 chỗ mạnh mẽ, thiết kế thể thao hiện đại, khả năng vượt địa hình xuất sắc.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Toyota']->id,
                'name' => 'Toyota Yaris Cross HEV',
                'price' => 838000000,
                'quantity' => 15,
                'year' => 2024,
                'type' => 'Crossover',
                'color' => 'Xanh, Trắng, Đỏ',
                'fuel_type' => 'Hybrid',
                'transmission' => 'CVT',
                'engine_capacity' => '1.5L',
                'seats' => 5,
                'description' => 'Mẫu Crossover cỡ B sử dụng công nghệ Hybrid tiết kiệm nhiên liệu, thiết kế góc cạnh và trẻ trung.',
                'status' => 1,
            ],

            // ================= HONDA =================
            [
                'brand_id' => $brands['Honda']->id,
                'name' => 'Honda CR-V L AWD',
                'price' => 1310000000,
                'quantity' => 12,
                'year' => 2024,
                'type' => 'Crossover',
                'color' => 'Đen, Trắng, Đỏ',
                'fuel_type' => 'Xăng',
                'transmission' => 'CVT',
                'engine_capacity' => '1.5T',
                'seats' => 7,
                'description' => 'Mẫu CUV cỡ C đậm chất thể thao, trang bị hệ dẫn động 4 bánh toàn thời gian AWD vượt trội.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Honda']->id,
                'name' => 'Honda Civic RS',
                'price' => 870000000,
                'quantity' => 6,
                'year' => 2023,
                'type' => 'Sedan',
                'color' => 'Đỏ, Đen, Xám',
                'fuel_type' => 'Xăng',
                'transmission' => 'CVT',
                'engine_capacity' => '1.5T',
                'seats' => 5,
                'description' => 'Mẫu Sedan thể thao với thiết kế khí động học, động cơ tăng áp mạnh mẽ và cảm giác lái chân thực.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Honda']->id,
                'name' => 'Honda City RS',
                'price' => 609000000,
                'quantity' => 20,
                'year' => 2024,
                'type' => 'Sedan',
                'color' => 'Trắng, Titan, Đỏ',
                'fuel_type' => 'Xăng',
                'transmission' => 'CVT',
                'engine_capacity' => '1.5L',
                'seats' => 5,
                'description' => 'Mẫu xe quốc dân trong phân khúc B, thiết kế nam tính, trang bị Honda SENSING an toàn tuyệt đối.',
                'status' => 1,
            ],

            // ================= FORD =================
            [
                'brand_id' => $brands['Ford']->id,
                'name' => 'Ford Ranger Wildtrak 4x4',
                'price' => 979000000,
                'quantity' => 25,
                'year' => 2024,
                'type' => 'Pickup',
                'color' => 'Vàng Luxe, Đen, Trắng',
                'fuel_type' => 'Dầu',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.0L Bi-Turbo',
                'seats' => 5,
                'description' => 'Vua bán tải tại Việt Nam với thiết kế cơ bắp, động cơ Bi-Turbo mạnh mẽ và hàng tá công nghệ thông minh.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Ford']->id,
                'name' => 'Ford Everest Titanium+ 4x4',
                'price' => 1468000000,
                'quantity' => 10,
                'year' => 2024,
                'type' => 'SUV',
                'color' => 'Đen, Trắng, Nâu',
                'fuel_type' => 'Dầu',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.0L Bi-Turbo',
                'seats' => 7,
                'description' => 'Mẫu SUV 7 chỗ gầm cao mạnh mẽ, nội thất bọc da cao cấp, màn hình giải trí SYNC 4A kích thước lớn.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['Ford']->id,
                'name' => 'Ford Explorer Limited',
                'price' => 2439000000,
                'quantity' => 4,
                'year' => 2023,
                'type' => 'SUV',
                'color' => 'Xanh, Đen, Trắng',
                'fuel_type' => 'Xăng',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.3L EcoBoost',
                'seats' => 7,
                'description' => 'Mẫu xe SUV cỡ lớn nhập khẩu trực tiếp từ Mỹ, động cơ EcoBoost trứ danh và không gian vô cùng rộng rãi.',
                'status' => 1,
            ],

            // ================= BMW =================
            [
                'brand_id' => $brands['BMW']->id,
                'name' => 'BMW 330i M Sport',
                'price' => 2499000000,
                'quantity' => 5,
                'year' => 2024,
                'type' => 'Sedan',
                'color' => 'Xanh Portimao, Đen, Trắng',
                'fuel_type' => 'Xăng',
                'transmission' => 'Tự động',
                'engine_capacity' => '2.0L',
                'seats' => 5,
                'description' => 'Mẫu Sedan thể thao hạng sang biểu tượng của BMW, trang bị gói M Sport từ nội đến ngoại thất.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['BMW']->id,
                'name' => 'BMW X5 xDrive40i',
                'price' => 4169000000,
                'quantity' => 3,
                'year' => 2024,
                'type' => 'SUV',
                'color' => 'Đen Sapphire, Xám',
                'fuel_type' => 'Xăng',
                'transmission' => 'Tự động',
                'engine_capacity' => '3.0L',
                'seats' => 7,
                'description' => 'Mẫu SAV hạng sang sở hữu không gian đẳng cấp, cần số pha lê và khả năng vận hành đỉnh cao.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['BMW']->id,
                'name' => 'BMW 740i Pure Excellence',
                'price' => 4999000000,
                'quantity' => 2,
                'year' => 2024,
                'type' => 'Sedan',
                'color' => 'Đen, Trắng, Bạc',
                'fuel_type' => 'Xăng',
                'transmission' => 'Tự động',
                'engine_capacity' => '3.0L',
                'seats' => 5,
                'description' => 'Mẫu xe siêu sang dành cho các ông chủ với hệ thống treo khí nén và màn hình rạp hát phía sau.',
                'status' => 1,
            ],

            // ================= VINFAST =================
            [
                'brand_id' => $brands['VinFast']->id,
                'name' => 'VinFast VF 8 Plus',
                'price' => 1270000000,
                'quantity' => 18,
                'year' => 2024,
                'type' => 'SUV',
                'color' => 'Xanh VinFast, Xám, Trắng',
                'fuel_type' => 'Điện',
                'transmission' => 'Tự động',
                'engine_capacity' => '300 kW',
                'seats' => 5,
                'description' => 'Mẫu SUV điện thông minh cỡ D do người Việt sản xuất, trợ lý ảo ViVi và tính năng tự lái ADAS vượt trội.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['VinFast']->id,
                'name' => 'VinFast VF 9 Plus',
                'price' => 1676000000,
                'quantity' => 12,
                'year' => 2024,
                'type' => 'SUV',
                'color' => 'Đen, Trắng, Cam',
                'fuel_type' => 'Điện',
                'transmission' => 'Tự động',
                'engine_capacity' => '300 kW',
                'seats' => 6,
                'description' => 'Chiếc SUV điện full-size cao cấp nhất của VinFast, ghế cơ trưởng massage và cửa sổ trời toàn cảnh.',
                'status' => 1,
            ],
            [
                'brand_id' => $brands['VinFast']->id,
                'name' => 'VinFast VF 3',
                'price' => 240000000,
                'quantity' => 50,
                'year' => 2024,
                'type' => 'SUV',
                'color' => 'Hồng, Vàng, Trắng',
                'fuel_type' => 'Điện',
                'transmission' => 'Tự động',
                'engine_capacity' => '32 kW',
                'seats' => 4,
                'description' => 'Mẫu xe điện mini "chất riêng, rất ngầu", thiết kế hai cửa độc đáo, phù hợp di chuyển cực linh hoạt trong đô thị.',
                'status' => 1,
            ],
        ];

        foreach ($carsData as $car) {
            Car::create($car);
        }

        $this->command->info('Đã seed thành công 5 hãng và 15 chiếc xe!');
    }
}
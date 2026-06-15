<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Mẫu Xe | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Header chung (đã tích hợp auth, profile, cart count) --}}
    @include('header')

    <!-- PAGE HEADER -->
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold tracking-tight">Khám Phá Các Mẫu Xe</h1>
            <p class="mt-4 text-gray-400 max-w-2xl mx-auto">Bộ sưu tập siêu xe và xe sang đẳng cấp nhất, mang đến trải nghiệm lái hoàn hảo dành riêng cho bạn.</p>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-grow max-w-7xl mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- BỘ LỌC BÊN TRÁI -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b">
                        <h2 class="font-bold text-lg"><i class="fas fa-filter text-blue-600 mr-2"></i>Bộ Lọc</h2>
                        <button onclick="resetFilters()" class="text-sm text-gray-500 hover:text-blue-600">Xóa lọc</button>
                    </div>

                    <form id="filterForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tìm kiếm</label>
                            <input type="text" id="search" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 border" placeholder="Tên xe...">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Hãng xe</label>
                            <select id="brand_id" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 border">
                                <option value="">Tất cả hãng xe</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Phân khúc</label>
                            <select id="type" class="w-full border-gray-300 rounded-xl text-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 border">
                                <option value="">Tất cả các loại</option>
                                <option value="SUV">SUV</option>
                                <option value="Sedan">Sedan</option>
                                <option value="Hatchback">Hatchback</option>
                                <option value="Coupe">Coupe</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition">
                            Áp dụng bộ lọc
                        </button>
                    </form>
                </div>
            </div>

            <!-- DANH SÁCH XE (GRID) -->
            <div class="w-full lg:w-3/4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800" id="result-count">Đang tải danh sách xe...</h2>
                </div>

                <div id="cars-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                </div>

                <div id="pagination" class="mt-10 flex justify-center gap-2">
                </div>
            </div>

        </div>
    </main>

    {{-- Footer chung --}}
    @include('footer')

    <script>
        // -------------------- LẤY DANH SÁCH HÃNG XE --------------------
        async function loadBrands() {
            try {
                const res = await fetch('/api/brands');
                const result = await res.json();
                if (result.success || result.data) {
                    const brands = result.data || result;
                    let options = '<option value="">Tất cả hãng xe</option>';
                    brands.forEach(b => {
                        options += `<option value="${b.id}">${b.name}</option>`;
                    });
                    document.getElementById('brand_id').innerHTML = options;
                }
            } catch (e) { console.error('Lỗi lấy hãng xe', e); }
        }

        // -------------------- LẤY DANH SÁCH XE + PHÂN TRANG --------------------
        let currentPage = 1;

        async function fetchCars(page = 1) {
            currentPage = page;
            const search = document.getElementById('search').value;
            const brand_id = document.getElementById('brand_id').value;
            const type = document.getElementById('type').value;
            
            const params = new URLSearchParams({ page, search, brand_id, type, status: 1 });
            const grid = document.getElementById('cars-grid');
            grid.innerHTML = '<div class="col-span-full text-center py-10"><i class="fas fa-circle-notch fa-spin text-3xl text-blue-500"></i></div>';

            try {
                const res = await fetch(`/api/cars?${params.toString()}`);
                const result = await res.json();

                if (result.success) {
                    const carsData = result.data.data ? result.data.data : result.data;
                    const paginationData = result.data.current_page ? result.data : null;

                    document.getElementById('result-count').innerHTML = `Hiển thị <span class="text-blue-600">${result.data.total || carsData.length}</span> mẫu xe`;
                    
                    renderCarsGrid(carsData);
                    
                    if (paginationData) {
                        renderPagination(paginationData);
                    } else {
                        document.getElementById('pagination').innerHTML = '';
                    }
                } else {
                    grid.innerHTML = `<div class="col-span-full text-center py-10 text-red-500">Không thể tải danh sách xe.</div>`;
                }
            } catch (e) {
                grid.innerHTML = `<div class="col-span-full text-center py-10 text-red-500">Lỗi kết nối máy chủ.</div>`;
            }
        }

        function renderCarsGrid(cars) {
            const grid = document.getElementById('cars-grid');
            
            if (!cars || cars.length === 0) {
                grid.innerHTML = `<div class="col-span-full text-center py-10 text-gray-500">Không tìm thấy mẫu xe nào phù hợp.</div>`;
                return;
            }

            let html = '';
            cars.forEach(car => {
                const defaultImgPath = `/Image/${encodeURIComponent(car.name)}.jpg`;
                const imgUrl = car.featured_image ? `/storage/${car.featured_image}` : defaultImgPath;
                const price = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';
                
                html += `
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm card-hover transition duration-300 group flex flex-col">
                    <div class="relative h-48 overflow-hidden bg-gray-50 flex items-center justify-center p-4">
                        <img src="${imgUrl}" alt="${car.name}" class="w-full h-full object-contain group-hover:scale-110 transition duration-500" onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                        <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">${car.type || 'N/A'}</div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow border-t border-gray-50">
                        <p class="text-xs text-gray-400 font-semibold uppercase mb-1">${car.brand ? car.brand.name : 'N/A'}</p>
                        <h3 class="font-bold text-lg text-gray-900 mb-2 leading-tight">${car.name}</h3>
                        <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                            <span><i class="fas fa-gas-pump mr-1"></i> ${car.fuel_type || 'N/A'}</span>
                            <span><i class="fas fa-cog mr-1"></i> ${car.transmission || 'N/A'}</span>
                        </div>
                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-black text-blue-600 text-lg">${price}</span>
                            <a href="/ChiTietXe/${car.id}" class="bg-gray-900 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                `;
            });
            grid.innerHTML = html;
        }

        function renderPagination(data) {
            const paginationDiv = document.getElementById('pagination');
            let html = '';
            if (data.current_page > 1) {
                html += `<button onclick="fetchCars(${data.current_page - 1})" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 font-medium transition">Trang Trước</button>`;
            }
            if (data.current_page < data.last_page) {
                html += `<button onclick="fetchCars(${data.current_page + 1})" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 font-medium transition">Trang Sau</button>`;
            }
            paginationDiv.innerHTML = html;
        }

        // Xử lý form lọc
        document.getElementById('filterForm').addEventListener('submit', (e) => {
            e.preventDefault();
            fetchCars(1);
        });

        function resetFilters() {
            document.getElementById('search').value = '';
            document.getElementById('brand_id').value = '';
            document.getElementById('type').value = '';
            fetchCars(1);
        }

        // Khởi tạo dữ liệu
        document.addEventListener('DOMContentLoaded', async () => {
            await loadBrands();
            await fetchCars(1);
        });
    </script>
</body>
</html>
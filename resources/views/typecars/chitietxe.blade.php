<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Xe | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- ==================== NAVBAR (GIỐNG HEADER CHUẨN) ==================== -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-blue-600 flex items-center gap-2 tracking-tight">
                <i class="fas fa-car-side"></i> CARSTORE
            </a>
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
                <a href="/mauxe" class="text-blue-600 font-bold transition">Mẫu xe</a>
                <a href="#" class="hover:text-blue-600 transition">Ưu đãi</a>
                <a href="#" class="hover:text-blue-600 transition">Video</a>
                <a href="#" class="hover:text-blue-600 transition">Liên hệ</a>
            </div>
            <div class="flex items-center gap-6">
                <a href="/cart" class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-2 text-sm relative py-2">
                    <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                    <span id="cart-count" class="absolute top-0 -right-3 bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">0</span>
                </a>

                <div id="auth-section" class="relative ml-2 group">
                    <div class="animate-pulse flex items-center gap-2 py-2">
                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                        <div class="h-4 w-20 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2">
            <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="/mauxe" class="hover:text-blue-600 transition">Mẫu xe</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <span id="breadcrumb-name" class="font-semibold text-gray-800">Đang tải...</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div id="loading-spinner" class="text-center py-20">
            <i class="fas fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
            <p class="text-gray-500 text-sm font-medium">Đang tải thông tin chi tiết siêu xe...</p>
        </div>

        <div id="car-details" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 items-start">
                
                <div class="w-full lg:col-span-3">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center justify-center h-[350px] md:h-[450px] lg:h-[520px] transition-all overflow-hidden group">
                        <img id="car-main-image" src="" alt="Hình ảnh xe" class="w-full h-full object-contain drop-shadow-2xl group-hover:scale-105 transition duration-500">
                    </div>
                </div>

                <div class="w-full lg:col-span-2 flex flex-col h-full min-h-[350px] md:min-h-[450px] lg:min-h-[520px]">
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span id="car-brand" class="bg-blue-50 text-blue-700 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide">Hãng Xe</span>
                        <span id="car-type" class="bg-gray-100 text-gray-600 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide">Phân Khúc</span>
                    </div>
                    
                    <h1 id="car-name" class="text-3xl md:text-4xl font-black text-gray-900 mt-2 mb-2 tracking-tight leading-tight">Tên Mẫu Xe</h1>
                    
                    <div class="flex items-center gap-5 text-xs text-gray-400 font-medium mb-6">
                        <span id="car-year"><i class="far fa-calendar-alt mr-1 text-gray-300"></i> Năm SX: --</span>
                        <span><i class="fas fa-eye mr-1 text-gray-300"></i> Lượt xem: <span id="car-views" class="font-semibold text-gray-600">0</span></span>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 mb-6 border border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Giá niêm yết chính hãng</p>
                        <h2 id="car-price" class="text-3xl md:text-4xl font-black text-blue-600 tracking-tight">0 ₫</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-sm"><i class="fas fa-gas-pump"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Nhiên liệu</p>
                                <p id="car-fuel" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-sm"><i class="fas fa-cog"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Hộp số</p>
                                <p id="car-transmission" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-sm"><i class="fas fa-chair"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Số chỗ</p>
                                <p id="car-seats" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-sm"><i class="fas fa-tachometer-alt"></i></div>
                            <div>
                                <p class="text-[11px] font-medium text-gray-400 uppercase">Động cơ</p>
                                <p id="car-engine" class="font-bold text-gray-800 text-sm">--</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 mt-auto">
                        <button onclick="addToCart()" class="flex-1 bg-gray-900 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                        </button>
                        <button onclick="buyNow()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
                            <i class="fa-regular fa-credit-card"></i> Mua ngay
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-12 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-align-left text-blue-600 text-sm"></i> Tổng quan về dòng xe
                </h3>
                <p id="car-description" class="text-gray-600 leading-relaxed whitespace-pre-line text-base"></p>
            </div>
        </div>
        
    </div>

    <footer class="bg-gray-900 text-gray-400 py-8 text-center text-xs border-t border-gray-800">
        © 2025 CARSTORE – Đẳng cấp phục vụ thượng lưu. Mọi quyền được bảo lưu.
    </footer>

    <script>
        const carId = "{{ $id }}";
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            // ========== AUTH & CART ==========
            const authSection = document.getElementById('auth-section');
            const token = localStorage.getItem('token');

            if (!token) {
                authSection.innerHTML = `
                    <div class="flex items-center gap-4">
                        <a href="/login" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition"><i class="fa-solid fa-arrow-right-to-bracket"></i> Đăng nhập</a>
                        <a href="/register" class="text-sm font-medium bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">Đăng ký</a>
                    </div>
                `;
            } else {
                authSection.innerHTML = `
                    <div class="cursor-pointer text-gray-700 hover:text-blue-600 font-medium flex items-center gap-2 text-sm py-2 transition">
                        <img id="header-avatar" src="/images/default-avatar.png" class="w-8 h-8 rounded-full object-cover border border-gray-200 shadow-sm" alt="Avatar">
                        <span id="header-name">Đang tải...</span>
                        <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-hover:rotate-180"></i>
                    </div>
                    <div class="absolute top-full right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                        <div class="p-3 border-b border-gray-50 bg-gray-50/50">
                            <p class="text-xs text-gray-500 mb-1">Đăng nhập với email:</p>
                            <p id="header-email" class="text-sm font-bold text-gray-800 truncate"></p>
                        </div>
                        <a href="/profile" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-3">
                            <i class="fa-solid fa-id-card text-gray-400 w-4"></i> Hồ sơ cá nhân
                        </a>
                        <a href="/orders" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-3">
                            <i class="fa-solid fa-clock-rotate-left text-gray-400 w-4"></i> Lịch sử mua hàng
                        </a>
                        <div class="border-t border-gray-100">
                            <button onclick="clientLogout()" class="w-full text-left block px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition flex items-center gap-3">
                                <i class="fa-solid fa-right-from-bracket text-red-400 w-4"></i> Đăng xuất
                            </button>
                        </div>
                    </div>
                `;

                try {
                    const res = await fetch('/api/profile', {
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        const user = data.user || data.data;
                        document.getElementById('header-name').textContent = user.full_name || user.name;
                        document.getElementById('header-email').textContent = user.email;
                        if (user.avatar) {
                            document.getElementById('header-avatar').src = '/storage/' + user.avatar;
                        } else {
                            document.getElementById('header-avatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=0D8ABC&color=fff&rounded=true`;
                        }
                    } else {
                        clientLogout();
                    }
                } catch (err) {
                    console.error("Lỗi lấy profile:", err);
                }
            }

            // Cập nhật số lượng giỏ hàng lúc đầu
            await updateCartCount();

            // Tải chi tiết xe
            await loadCarDetails();
        });

        // Hàm đăng xuất
        async function clientLogout() {
            const token = localStorage.getItem('token');
            if(token) {
                try {
                    await fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + token } });
                } catch(e) {}
                localStorage.removeItem('token');
                localStorage.removeItem('user_role');
            }
            window.location.href = '/login';
        }

        // Hàm cập nhật số lượng giỏ hàng (dựa theo cấu trúc API thực tế)
        async function updateCartCount() {
            const token = localStorage.getItem('token');
            if (!token) {
                const countSpan = document.getElementById('cart-count');
                if (countSpan) countSpan.textContent = '0';
                return;
            }
            try {
                const res = await fetch('/api/cart', {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();
                console.log('Cart API response:', data); // Debug xem cấu trúc

                // Kiểm tra đúng theo format của CartController: { success: true, data: [...] }
                if (data.success && Array.isArray(data.data)) {
                    const totalQty = data.data.reduce((sum, item) => sum + (item.quantity || 0), 0);
                    document.getElementById('cart-count').textContent = totalQty;
                } else {
                    document.getElementById('cart-count').textContent = '0';
                }
            } catch(e) {
                console.error('Lỗi cập nhật số lượng giỏ:', e);
                document.getElementById('cart-count').textContent = '0';
            }
        }

        // Hàm tải chi tiết xe
        async function loadCarDetails() {
            const spinner = document.getElementById('loading-spinner');
            const detailsBox = document.getElementById('car-details');

            try {
                const res = await fetch(`/api/cars/${carId}`);
                const result = await res.json();

                if (res.ok && result.success) {
                    const car = result.data;
                    document.getElementById('breadcrumb-name').textContent = car.name;
                    document.getElementById('car-name').textContent = car.name;
                    document.getElementById('car-brand').textContent = car.brand ? car.brand.name : 'N/A';
                    document.getElementById('car-type').textContent = car.type || 'N/A';
                    document.getElementById('car-year').innerHTML = `<i class="far fa-calendar-alt mr-1 text-gray-300"></i> Năm SX: ${car.year}`;
                    document.getElementById('car-views').textContent = car.views || 0;
                    document.getElementById('car-price').textContent = new Intl.NumberFormat('vi-VN').format(car.price) + ' ₫';
                    document.getElementById('car-fuel').textContent = car.fuel_type || '--';
                    document.getElementById('car-transmission').textContent = car.transmission || '--';
                    document.getElementById('car-seats').textContent = car.seats ? car.seats + ' chỗ' : '--';
                    document.getElementById('car-engine').textContent = car.engine_capacity || '--';
                    document.getElementById('car-description').textContent = car.description || 'Hiện tại chưa có bài viết đánh giá chi tiết cho dòng sản phẩm này.';

                    const defaultImgPath = `/Image/${encodeURIComponent(car.name)}.jpg`;
                    const imgUrl = car.featured_image ? `/storage/${car.featured_image}` : defaultImgPath;
                    const mainImage = document.getElementById('car-main-image');
                    mainImage.src = imgUrl;
                    mainImage.onerror = function() {
                        this.src = 'https://via.placeholder.com/800x500?text=Hình+Ảnh+Đang+Cập+Nhật';
                    };

                    spinner.classList.add('hidden');
                    detailsBox.classList.remove('hidden');
                } else {
                    spinner.innerHTML = `
                        <div class="p-6 bg-red-50 border border-red-200 rounded-2xl max-w-md mx-auto text-red-700">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p class="font-bold">${result.message || 'Mẫu xe này không tồn tại hoặc đã ngừng kinh doanh!'}</p>
                            <a href="/mauxe" class="mt-4 inline-block text-sm bg-gray-900 text-white px-4 py-2 rounded-xl font-semibold">Quay lại showroom</a>
                        </div>`;
                }
            } catch (error) {
                console.error('Lỗi kết nối tải thông tin:', error);
                spinner.innerHTML = `
                    <div class="text-red-500 font-bold">
                        <i class="fas fa-wifi text-2xl mb-2"></i>
                        <p>Lỗi kết nối nghiêm trọng đến máy chủ, vui lòng thử lại sau!</p>
                    </div>`;
            }
        }

        // Thêm vào giỏ hàng
        async function addToCart() {
            const token = localStorage.getItem('token');
            if (!token) {
                alert('⚠️ Bạn vui lòng đăng nhập tài khoản để thực hiện tính năng thêm sản phẩm vào giỏ hàng!');
                window.location.href = '/login';
                return false;
            }

            try {
                const res = await fetch('/api/cart', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + token, 
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify({
                        car_id: carId,
                        quantity: 1
                    })
                });

                const result = await res.json();
                if (res.ok && result.success) {
                    alert('✅ Đã thêm siêu xe vào hệ thống giỏ hàng của bạn thành công!');
                    await updateCartCount();  // Cập nhật số lượng trên header ngay lập tức
                    return true;
                } else {
                    alert('❌ Thao tác thất bại: ' + (result.message || 'Hệ thống giỏ hàng đang bận!'));
                    return false;
                }
            } catch (error) {
                console.error('Lỗi xử lý giỏ hàng:', error);
                alert('❌ Máy chủ phản hồi lỗi, không thể cập nhật giỏ hàng lúc này!');
                return false;
            }
        }

        // Mua ngay
        async function buyNow() {
            const success = await addToCart();
            if (success) {
                window.location.href = '/checkout';
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>CarStore | Trang chủ xe sang đẳng cấp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{font-family:'Inter',system-ui,-apple-system,sans-serif;}
        html{scroll-behavior:smooth;}
        .hero-video {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; z-index: 0;
        }
        .hero-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.4) 100%);
            z-index: 1;
        }
        .hero-content {
            position: relative; z-index: 2;
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 35px -12px rgba(0,0,0,0.2);
        }
        .btn-primary {
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            transform: scale(1.02);
            background-color: #1e40af;
            box-shadow: 0 8px 20px rgba(37,99,235,0.3);
        }
        .service-icon {
            transition: 0.2s;
        }
        .service-card:hover .service-icon {
            transform: scale(1.1);
            color: #2563eb;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Sử dụng header chung --}}
    @include('header')

    <main class="flex-grow">
        <section class="relative h-screen max-h-[750px] md:max-h-[800px] overflow-hidden">
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/videoxe.mp4') }}" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-content relative z-10 flex flex-col justify-center items-center text-center h-full px-4 max-w-5xl mx-auto text-white">
                <span class="inline-block px-4 py-1 rounded-full bg-blue-600/30 backdrop-blur-sm text-sm font-semibold mb-5 border border-white/20">
                    <i class="fa-regular fa-gem mr-1"></i> Đẳng cấp vượt thời gian
                </span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-tight drop-shadow-2xl tracking-tight">
                    Khám Phá Bộ Sưu Tập <br> <span class="text-blue-400">Siêu Xe & Xe Sang</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-100 mt-6 max-w-2xl mx-auto font-light">Trải nghiệm cảm giác lái đỉnh cao, dịch vụ tận tâm & chế độ bảo hành vượt trội.</p>
                <div class="flex flex-col sm:flex-row gap-4 mt-10">
                    <button onclick="scrollToFeatured()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-lg shadow-xl btn-primary transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-car"></i> Xem ngay
                    </button>
                    <button id="btnTestDrive" class="bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-white/20 text-white px-8 py-3 rounded-full font-semibold text-lg transition flex items-center justify-center gap-2">
                        <i class="fa-regular fa-circle-play"></i> Lái thử
                    </button>
                </div>
                <div class="absolute bottom-8 left-0 right-0 flex justify-center gap-4 text-sm font-medium text-white/80">
                    <div class="flex items-center gap-1"><i class="fa-solid fa-check-circle text-blue-400"></i> Miễn phí giao xe</div>
                    <div class="flex items-center gap-1"><i class="fa-solid fa-shield-alt text-blue-400"></i> Bảo hành 5 năm</div>
                    <div class="flex items-center gap-1"><i class="fa-solid fa-headset text-blue-400"></i> Hỗ trợ 24/7</div>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center mb-14">
                <span class="text-blue-600 font-semibold uppercase tracking-wider text-sm">Tuyển chọn hàng đầu</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2 text-gray-800">Mẫu xe bán chạy nhất</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-4 rounded-full"></div>
                <p class="text-gray-500 max-w-2xl mx-auto mt-4">Những siêu phẩm được yêu thích nhất, kết hợp giữa thiết kế Ý, Đức và sức mạnh vượt trội</p>
            </div>
            <div id="featured-cars-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"></div>
        </div>

        <section class="bg-white py-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="order-2 md:order-1">
                        <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider"><i class="fa-regular fa-film mr-1"></i> Trải nghiệm sống động</span>
                        <h3 class="text-3xl md:text-4xl font-bold mt-3 leading-tight">Tinh hoa công nghệ <br> & cảm xúc mãnh liệt</h3>
                        <p class="text-gray-600 mt-5 leading-relaxed">Đắm chìm trong thế giới của những chiếc xe – từ sức mạnh động cơ đến thiết kế hoàn hảo. CarStore mang đến chuẩn mực mới cho trải nghiệm lái.</p>
                        <ul class="mt-6 space-y-3">
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Đánh giá chuyên sâu từ các tay lái</span></li>
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Góc nhìn 360° nội thất sang trọng</span></li>
                            <li class="flex items-center gap-3"><i class="fa-solid fa-check-circle text-blue-600 text-lg"></i> <span>Công nghệ an toàn đỉnh cao</span></li>
                        </ul>
                    </div>
                    <div class="order-1 md:order-2 relative group w-full">
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-2xl">
                            <iframe class="absolute top-0 left-0 w-full h-full" 
                                    src="https://www.youtube.com/embed/0JGQBuHfL7M" 
                                    title="VF 3 CHẤT RIÊNG, RẤT NGẦU" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" 
                                    allowfullscreen>
                            </iframe>
                        </div>
                        <div class="absolute -bottom-4 -right-2 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden md:block border-4 border-white">
                            <i class="fa-solid fa-video text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="bg-gray-50 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Đẳng cấp phục vụ</h2>
                    <p class="text-gray-500 mt-2">Trải nghiệm mua sắm chuyên nghiệp, tận tâm và xứng tầm</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                        <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-truck-fast"></i></div>
                        <h3 class="font-bold text-xl">Giao xe toàn quốc</h3>
                        <p class="text-gray-500 text-sm mt-2">Miễn phí vận chuyển nội thành, hỗ trợ tận nơi</p>
                    </div>
                    <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                        <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-clock"></i></div>
                        <h3 class="font-bold text-xl">Bảo hành dài hạn</h3>
                        <p class="text-gray-500 text-sm mt-2">5 năm hoặc 100.000 km, bảo dưỡng định kỳ</p>
                    </div>
                    <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                        <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-hand-holding-usd"></i></div>
                        <h3 class="font-bold text-xl">Trả góp linh hoạt</h3>
                        <p class="text-gray-500 text-sm mt-2">Lãi suất ưu đãi, thủ tục nhanh chóng</p>
                    </div>
                    <div class="service-card bg-white p-6 rounded-2xl shadow-sm text-center transition-all hover:shadow-md border border-gray-100">
                        <div class="service-icon text-blue-600 text-4xl mb-4"><i class="fa-solid fa-star-of-life"></i></div>
                        <h3 class="font-bold text-xl">Hỗ trợ 24/7</h3>
                        <p class="text-gray-500 text-sm mt-2">Đội ngũ chuyên viên tư vấn chuyên nghiệp</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== PHẦN HIỂN THỊ BÌNH LUẬN ==================== --}}
        @php
            $reviews = [];
            try {
                $reviews = \App\Models\Review::with('user')
                    ->where('is_approved', true)
                    ->latest()
                    ->take(6)
                    ->get();
            } catch (\Exception $e) {
                $reviews = [];
            }
        @endphp

        <div class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Khách hàng nói gì về chúng tôi?</h2>
                    <p class="text-gray-500 mt-2">Những trải nghiệm thực tế từ cộng đồng</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($reviews as $review)
                        <div class="bg-gray-50 p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $review->user->name }}</h4>
                                    <div class="flex text-yellow-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"{{ $review->content }}"</p>
                            @if($review->car)
                                <p class="text-xs text-gray-400 mt-3">Đánh giá về: {{ $review->car->name }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-400 py-8">
                            <i class="fa-regular fa-comment-dots text-4xl mb-2"></i>
                            <p>Chưa có đánh giá nào. Hãy là người đầu tiên chia sẻ trải nghiệm của bạn!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    {{-- Modal đăng ký lái thử --}}
    <div id="testDriveModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white p-4 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Đăng Ký Lái Thử</h3>
                <button onclick="closeTestDriveModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="testDriveForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên *</label>
                        <input type="text" id="full_name" name="full_name" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại *</label>
                        <input type="tel" id="phone" name="phone" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email (tùy chọn)</label>
                        <input type="email" id="email" name="email" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Xe muốn lái thử (tùy chọn)</label>
                        <select id="car_id" name="car_id" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="">Chọn xe (nếu có)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ngày dự kiến (tùy chọn)</label>
                        <input type="date" id="preferred_date" name="preferred_date" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lời nhắn (tùy chọn)</label>
                        <textarea id="message" name="message" rows="3" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="VD: Mong muốn lái thử vào buổi chiều..."></textarea>
                    </div>
                    <button type="submit" id="submitTestDrive" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                        Gửi đăng ký
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Sử dụng footer chung --}}
    @include('footer')

    <script>
        // Hàm cuộn
        function scrollToFeatured() {
            const section = document.getElementById('featured-cars-grid');
            if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function scrollToVideo() {
            const videoFrame = document.querySelector('iframe');
            if (videoFrame) videoFrame.scrollIntoView({ behavior: 'smooth', block: 'center' });
            else alert('Video đang được cập nhật.');
        }

        // Load danh sách xe nổi bật
        async function loadFeaturedCars() {
            try {
                const res = await fetch('/api/cars?limit=4&status=1');
                const result = await res.json();
                if (result.success && result.data) {
                    let cars = result.data.data ? result.data.data : result.data;
                    if (Array.isArray(cars)) renderFeaturedCars(cars.slice(0, 4));
                    else showEmpty();
                } else showEmpty();
            } catch (err) {
                console.error(err);
                showEmpty();
            }
        }

        function showEmpty() {
            const container = document.getElementById('featured-cars-grid');
            if (container) container.innerHTML = `
                <div class="col-span-full text-center text-gray-400 py-12">
                    <i class="fa-solid fa-car text-4xl mb-3"></i>
                    <p>Danh sách xe bán chạy đang được cập nhật...</p>
                </div>`;
        }

        function formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
        }

        function renderFeaturedCars(cars) {
            const container = document.getElementById('featured-cars-grid');
            if (!container) return;
            if (!cars || cars.length === 0) return showEmpty();

            let html = '';
            cars.forEach(car => {
                const defaultImgPath = `/Image/${encodeURIComponent(car.name)}.jpg`;
                const imgUrl = car.featured_image ? `/storage/${car.featured_image}` : defaultImgPath;
                const badge = car.type || 'Siêu xe';
                html += `
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden card-hover transition border border-gray-100 group">
                        <div class="relative overflow-hidden h-52">
                            <img src="${imgUrl}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" alt="${car.name}" onerror="this.src='https://via.placeholder.com/400x250?text=No+Image'">
                            <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">${badge}</div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-extrabold text-xl tracking-tight">${car.name}</h3>
                            <p class="text-blue-600 font-bold text-xl mt-2">${formatPrice(car.price)}</p>
                            <div class="flex gap-2 mt-5">
                                <a href="/ChiTietXe/${car.id}" class="flex-1 bg-gray-900 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm">
                                    <i class="fa-solid fa-cart-plus"></i> Đặt xe
                                </a>
                                <button class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center transition">
                                    <i class="fa-regular fa-heart text-gray-600"></i>
                                </button>
                            </div>
                        </div>
                    </div>`;
            });
            container.innerHTML = html;
        }

        // Modal đăng ký lái thử
        async function loadCarsForSelect() {
            try {
                const res = await fetch('/api/cars?limit=100&status=1');
                const result = await res.json();
                if (result.success && result.data) {
                    let cars = result.data.data ? result.data.data : result.data;
                    const select = document.getElementById('car_id');
                    if (select && cars.length) {
                        let options = '<option value="">Chọn xe (nếu có)</option>';
                        cars.forEach(car => {
                            options += `<option value="${car.id}">${car.name} ${car.brand?.name ? `- ${car.brand.name}` : ''}</option>`;
                        });
                        select.innerHTML = options;
                    }
                }
            } catch (err) {
                console.error('Lỗi tải danh sách xe:', err);
            }
        }

        function openTestDriveModal() {
            loadCarsForSelect(); // load lại danh sách xe mới nhất
            document.getElementById('testDriveModal').classList.remove('hidden');
            document.getElementById('testDriveModal').style.display = 'flex';
        }

        function closeTestDriveModal() {
            document.getElementById('testDriveModal').classList.add('hidden');
            document.getElementById('testDriveModal').style.display = 'none';
            document.getElementById('testDriveForm').reset();
        }

        // Gửi form đăng ký
        document.getElementById('testDriveForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('submitTestDrive');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

            const payload = {
                full_name: document.getElementById('full_name').value,
                phone: document.getElementById('phone').value,
                email: document.getElementById('email').value,
                car_id: document.getElementById('car_id').value || null,
                preferred_date: document.getElementById('preferred_date').value,
                message: document.getElementById('message').value,
            };

            try {
                const response = await fetch('/api/test-drive', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + (localStorage.getItem('token') || '')
                    },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    alert(result.message);
                    closeTestDriveModal();
                } else {
                    alert(result.message || 'Có lỗi xảy ra, vui lòng thử lại sau.');
                }
            } catch (error) {
                console.error(error);
                alert('Không thể kết nối đến máy chủ.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Gửi đăng ký';
            }
        });

        // Gắn sự kiện cho nút "Lái thử"
        document.getElementById('btnTestDrive').addEventListener('click', openTestDriveModal);

        // Khởi chạy
        document.addEventListener('DOMContentLoaded', () => {
            loadFeaturedCars();
            const video = document.querySelector('.hero-video');
            if (video) video.play().catch(e => console.log('Autoplay bị chặn'));
        });
    </script>
</body>
    {{-- Khung Chat AI --}}
    <div id="chatbot-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
        <div id="chat-window" class="hidden w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-gray-200 flex flex-col mb-4 overflow-hidden origin-bottom-right transition-all duration-300 h-[500px]">
            <div class="bg-blue-600 text-white p-4 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">Trợ lý CarStore (AI)</h4>
                        <p class="text-[10px] text-blue-100"><span class="w-2 h-2 inline-block bg-green-400 rounded-full animate-pulse mr-1"></span>Đang trực tuyến</p>
                    </div>
                </div>
                <button onclick="toggleChat()" class="text-white/80 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            
            <div id="chat-messages" class="flex-1 overflow-y-auto p-4 bg-gray-50 flex flex-col gap-3 text-sm border-t border-b border-gray-100 min-h-0">
                <div class="bg-blue-100 text-blue-800 p-3 rounded-2xl rounded-tl-sm w-5/6 shadow-sm">
                    Xin chào! Tôi là trợ lý AI của CarStore. Bạn cần tìm xe tầm giá bao nhiêu hoặc xe của hãng nào?
                </div>
            </div>

            <div class="p-3 bg-white border-t border-gray-100 flex items-center gap-2 shrink-0">
                <input type="text" id="chat-input" class="flex-1 bg-gray-100 rounded-full px-4 py-2 outline-none focus:ring-2 focus:ring-blue-500 transition text-sm" placeholder="Nhập câu hỏi...">
                <button onclick="sendMessage()" id="send-btn" class="w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition flex items-center justify-center shadow-md">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <button onclick="toggleChat()" id="chat-toggle-btn" class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-2xl hover:bg-blue-700 hover:scale-110 transition-all flex items-center justify-center text-2xl group">
            <i class="fas fa-comment-dots group-hover:hidden"></i>
            <i class="fas fa-headset hidden group-hover:block"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        const chatWindow = document.getElementById('chat-window');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        function toggleChat() { chatWindow.classList.toggle('hidden'); }

        chatInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendMessage();
        });

        async function sendMessage() {
            const message = chatInput.value.trim();
            if (!message) return;
            appendMessage('user', message);
            chatInput.value = '';
            
            const typingId = 'typing-' + Date.now();
            chatMessages.innerHTML += `<div id="${typingId}" class="bg-gray-200 p-3 rounded-2xl w-fit text-xs text-gray-500">Đang gõ...</div>`;
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            chatInput.disabled = true;
            document.getElementById('send-btn').disabled = true;

            try {
                const res = await fetch('/api/chatbot', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ message: message })
                });
                const data = await res.json();
                document.getElementById(typingId).remove();
                appendMessage('ai', data.reply);
            } catch (err) {
                document.getElementById(typingId).remove();
                appendMessage('ai', 'Lỗi kết nối mạng.');
            } finally {
                chatInput.disabled = false;
                document.getElementById('send-btn').disabled = false;
                chatInput.focus();
            }
        }

        function appendMessage(sender, text) {
            const div = document.createElement('div');
            if (sender === 'user') {
                div.className = "bg-blue-600 text-white p-3 rounded-2xl rounded-tr-sm w-fit max-w-[85%] self-end shadow-sm";
                div.textContent = text;
            } else {
                div.className = "bg-blue-100 text-blue-900 p-3 rounded-2xl rounded-tl-sm w-fit max-w-[85%] shadow-sm leading-relaxed";
                div.innerHTML = marked.parse(text); 
            }
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</html>
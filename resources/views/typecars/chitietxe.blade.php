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
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Header chung (đã có xử lý token, cart count) --}}
    @include('header')

    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 text-sm text-gray-500 flex items-center gap-2">
            <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="/mauxe" class="hover:text-blue-600 transition">Mẫu xe</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
            <span id="breadcrumb-name" class="font-semibold text-gray-800">Đang tải...</span>
        </div>
    </div>

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
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
                            <div><p class="text-[11px] font-medium text-gray-400 uppercase">Nhiên liệu</p><p id="car-fuel" class="font-bold text-gray-800 text-sm">--</p></div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-sm"><i class="fas fa-cog"></i></div>
                            <div><p class="text-[11px] font-medium text-gray-400 uppercase">Hộp số</p><p id="car-transmission" class="font-bold text-gray-800 text-sm">--</p></div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-sm"><i class="fas fa-chair"></i></div>
                            <div><p class="text-[11px] font-medium text-gray-400 uppercase">Số chỗ</p><p id="car-seats" class="font-bold text-gray-800 text-sm">--</p></div>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm">
                            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-sm"><i class="fas fa-tachometer-alt"></i></div>
                            <div><p class="text-[11px] font-medium text-gray-400 uppercase">Động cơ</p><p id="car-engine" class="font-bold text-gray-800 text-sm">--</p></div>
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

            {{-- PHẦN BÌNH LUẬN --}}
            <div class="mt-12 bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-100 flex items-center gap-2">
                    <i class="fas fa-comments text-blue-600 text-sm"></i> Đánh giá & Bình luận
                </h3>

                <div id="review-login-prompt" class="hidden mb-8 p-4 bg-yellow-50 text-yellow-800 rounded-xl text-sm border border-yellow-200">
                    <i class="fas fa-exclamation-circle mr-1"></i> Vui lòng <a href="/login" class="font-bold underline hover:text-yellow-900">đăng nhập</a> để gửi đánh giá.
                </div>

                <div id="review-form-container" class="hidden mb-8">
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Đánh giá sao:</label>
                            <div class="flex gap-1 text-2xl text-yellow-400" id="rating-stars">
                                <i class="far fa-star cursor-pointer hover:text-yellow-500" data-rating="1"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-500" data-rating="2"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-500" data-rating="3"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-500" data-rating="4"></i>
                                <i class="far fa-star cursor-pointer hover:text-yellow-500" data-rating="5"></i>
                            </div>
                            <input type="hidden" id="review-rating" value="0">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung bình luận:</label>
                            <textarea id="review-content" rows="3" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none text-sm transition" placeholder="Chia sẻ trải nghiệm của bạn về dòng xe này..."></textarea>
                        </div>
                        <button id="submitReviewBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition duration-300 flex items-center gap-2 text-sm">
                            <i class="fas fa-paper-plane"></i> Gửi bình luận
                        </button>
                    </div>
                </div>

                <div id="reviews-list" class="space-y-5">
                    <p class="text-gray-500 text-sm italic">Đang tải bình luận...</p>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer chung --}}
    @include('footer')

    <script>
        const carId = "{{ $id }}";

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        document.addEventListener('DOMContentLoaded', async () => {
            // Header đã tự động cập nhật auth và cart count, ta chỉ cần gọi updateCartCount để đảm bảo
            if (typeof window.updateCartCount === 'function') {
                await window.updateCartCount();
            } else {
                await updateCartCount();
            }

            await loadCarDetails();

            // Xử lý phần bình luận
            const token = localStorage.getItem('token');
            const loginPrompt = document.getElementById('review-login-prompt');
            const formContainer = document.getElementById('review-form-container');

            if (token) {
                loginPrompt.classList.add('hidden');
                formContainer.classList.remove('hidden');
                attachReviewEvents();
                await loadReviews();
            } else {
                loginPrompt.classList.remove('hidden');
                formContainer.classList.add('hidden');
                // Vẫn tải danh sách bình luận cho khách
                await loadReviews();
            }
        });

        function attachReviewEvents() {
            // Chọn sao
            const stars = document.querySelectorAll('#rating-stars i');
            const ratingInput = document.getElementById('review-rating');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingInput.value = rating;
                    stars.forEach(s => s.className = 'far fa-star cursor-pointer hover:text-yellow-500');
                    for (let i = 0; i < rating; i++) {
                        stars[i].className = 'fas fa-star cursor-pointer hover:text-yellow-500';
                    }
                });
            });

            // Gửi bình luận
            const submitBtn = document.getElementById('submitReviewBtn');
            submitBtn.addEventListener('click', async () => {
                const rating = ratingInput.value;
                const content = document.getElementById('review-content').value.trim();
                if (!rating || rating === '0') {
                    alert('Vui lòng chọn số sao đánh giá.');
                    return;
                }
                if (!content) {
                    alert('Vui lòng nhập nội dung bình luận.');
                    return;
                }
                const token = localStorage.getItem('token');
                if (!token) {
                    alert('Bạn cần đăng nhập để gửi bình luận.');
                    window.location.href = '/login';
                    return;
                }
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
                try {
                    const res = await fetch(`/api/cars/${carId}/reviews`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ rating: parseInt(rating), content: content })
                    });
                    const result = await res.json();
                    if (res.ok && result.status === 'success') {
                        alert('Cảm ơn bạn đã đánh giá! Bình luận sẽ được hiển thị sau khi được duyệt.');
                        document.getElementById('review-content').value = '';
                        ratingInput.value = '0';
                        stars.forEach(s => s.className = 'far fa-star cursor-pointer hover:text-yellow-500');
                        await loadReviews(); // tải lại danh sách
                    } else {
                        alert(result.message || 'Gửi thất bại, vui lòng thử lại.');
                    }
                } catch (err) {
                    alert('Lỗi kết nối. Không thể gửi bình luận.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Gửi bình luận';
                }
            });
        }

        async function loadReviews() {
            const container = document.getElementById('reviews-list');
            try {
                const res = await fetch(`/api/cars/${carId}/reviews`);
                const result = await res.json();
                if (res.ok && result.status === 'success') {
                    const reviews = result.data;
                    if (!reviews || reviews.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-sm italic text-center py-4">Chưa có đánh giá nào cho mẫu xe này. Hãy là người đầu tiên trải nghiệm!</p>';
                        return;
                    }
                    let html = '';
                    reviews.forEach(rv => {
                        const starsFull = '⭐'.repeat(rv.rating);
                        const starsEmpty = '⭐'.repeat(5 - rv.rating);
                        const userName = rv.user ? rv.user.name : 'Khách hàng';
                        const initial = userName.charAt(0).toUpperCase();
                        const date = new Date(rv.created_at).toLocaleDateString('vi-VN');
                        html += `
                            <div class="pb-5 border-b border-gray-100 last:border-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-lg">${initial}</div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">${escapeHtml(userName)}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-xs tracking-widest">${starsFull}${starsEmpty}</span>
                                            <span class="text-gray-400 text-xs"><i class="far fa-clock"></i> ${date}</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm pl-13 leading-relaxed">${escapeHtml(rv.content)}</p>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<p class="text-red-500 text-sm italic">Không thể tải bình luận lúc này.</p>';
                }
            } catch (err) {
                container.innerHTML = '<p class="text-red-500 text-sm italic">Lỗi tải bình luận.</p>';
            }
        }

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
                    mainImage.onerror = () => { mainImage.src = 'https://via.placeholder.com/800x500?text=Hình+Ảnh+Đang+Cập+Nhật'; };
                    spinner.classList.add('hidden');
                    detailsBox.classList.remove('hidden');
                } else {
                    spinner.innerHTML = `<div class="p-6 bg-red-50 border border-red-200 rounded-2xl max-w-md mx-auto text-red-700"><i class="fas fa-exclamation-triangle text-2xl mb-2"></i><p class="font-bold">${result.message || 'Mẫu xe này không tồn tại hoặc đã ngừng kinh doanh!'}</p><a href="/mauxe" class="mt-4 inline-block text-sm bg-gray-900 text-white px-4 py-2 rounded-xl font-semibold">Quay lại showroom</a></div>`;
                }
            } catch (error) {
                spinner.innerHTML = `<div class="text-red-500 font-bold"><i class="fas fa-wifi text-2xl mb-2"></i><p>Lỗi kết nối nghiêm trọng đến máy chủ, vui lòng thử lại sau!</p></div>`;
            }
        }

        async function updateCartCount() {
            const token = localStorage.getItem('token');
            const cartSpan = document.getElementById('cart-count');
            if (!token) { if(cartSpan) cartSpan.textContent = '0'; return; }
            try {
                const res = await fetch('/api/cart', { headers: { 'Authorization': 'Bearer ' + token } });
                const data = await res.json();
                if (data.success && Array.isArray(data.data)) {
                    const total = data.data.reduce((sum, item) => sum + (item.quantity || 0), 0);
                    if(cartSpan) cartSpan.textContent = total;
                } else if(cartSpan) cartSpan.textContent = '0';
            } catch(e) { if(cartSpan) cartSpan.textContent = '0'; }
        }

        async function addToCart() {
            const token = localStorage.getItem('token');
            if (!token) {
                alert('⚠️ Vui lòng đăng nhập để thêm vào giỏ hàng!');
                window.location.href = '/login';
                return false;
            }
            try {
                const res = await fetch('/api/cart', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' },
                    body: JSON.stringify({ car_id: carId, quantity: 1 })
                });
                const result = await res.json();
                if (res.ok && result.success) {
                    alert('✅ Đã thêm xe vào giỏ hàng!');
                    await updateCartCount();
                    return true;
                } else {
                    alert('❌ ' + (result.message || 'Không thể thêm vào giỏ.'));
                    return false;
                }
            } catch (error) {
                alert('❌ Lỗi kết nối!');
                return false;
            }
        }

        async function buyNow() {
            const success = await addToCart();
            if (success) window.location.href = '/checkout';
        }

        // Hàm logout đã được định nghĩa trong header, nhưng nếu không có thì tự định nghĩa
        if (typeof window.clientLogout !== 'function') {
            window.clientLogout = async function() {
                const token = localStorage.getItem('token');
                if(token) await fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + token } }).catch(e=>{});
                localStorage.removeItem('token');
                localStorage.removeItem('user_role');
                window.location.href = '/login';
            };
        }
    </script>
</body>
</html>
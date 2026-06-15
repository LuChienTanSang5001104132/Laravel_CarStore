<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Liên Hệ | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{font-family:'Inter',system-ui,-apple-system,sans-serif;}
        html{scroll-behavior:smooth;}
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <!-- ==================== NAVBAR DÙNG TOKEN ==================== -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-blue-600 flex items-center gap-2 tracking-tight">
                <i class="fas fa-car-side"></i> CARSTORE
            </a>
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
                <a href="/mauxe" class="hover:text-blue-600 transition">Mẫu xe</a>
                <a href="/installment" class="hover:text-blue-600 transition">Ưu đãi</a>
                <a href="/contact" class="text-blue-600 font-bold transition">Liên hệ</a>
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

    <main class="flex-grow w-full bg-white">
        <div class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-4xl font-bold text-center text-blue-600 mb-12 uppercase tracking-tight">CarStore - Nơi đam mê tốc độ giao thoa cùng đẳng cấp thượng lưu</h1>
            <div class="space-y-6 text-gray-700 leading-relaxed text-justify text-lg">
                <p>Trong thế giới của giới tinh hoa, một chiếc xe hơi từ lâu đã vượt ra khỏi giới hạn của một phương tiện di chuyển đơn thuần. Nó là biểu tượng của sự thành đạt, là bản tuyên ngôn không lời về phong cách sống, là tác phẩm nghệ thuật cơ khí và là minh chứng cho khát khao chinh phục sự hoàn mỹ. Thấu hiểu sâu sắc những giá trị vô hình nhưng vô giá đó, CarStore chính thức ra đời với sứ mệnh mang đến cho khách hàng Việt Nam những siêu phẩm bốn bánh đẳng cấp nhất thế giới.</p>
                <p>Chúng tôi không chỉ bán một chiếc xe, chúng tôi trao gửi một trải nghiệm độc bản, một lối sống thượng lưu và một tấm vé bước vào thế giới của những đặc quyền chưa từng có. Tại CarStore, mỗi giao dịch là một hành trình kết nối, nơi sự chuyên nghiệp, uy tín và chất lượng được đặt lên hàng đầu, đảm bảo mang đến sự an tâm tuyệt đối cho mọi chủ nhân tương lai.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">1. Bộ sưu tập kiệt tác cơ khí độc bản</h3>
                <p>CarStore tự hào là đại lý phân phối và nhập khẩu trực tiếp các dòng siêu xe, xe sang và xe thể thao hiệu suất cao từ những thương hiệu huyền thoại trên toàn cầu. Khám phá showroom của chúng tôi, quý khách sẽ được chiêm ngưỡng tận mắt những "mãnh thú" đường phố đến từ Lamborghini, Ferrari, Bugatti, Porsche, cho đến những biểu tượng của sự quyền uy và êm ái như Rolls-Royce, Bentley hay Mercedes-Maybach.</p>
                <p>Mọi sản phẩm tại CarStore, dù là bản tiêu chuẩn hay bản giới hạn (Limited Edition), đều được tuyển chọn vô cùng khắt khe. Chúng tôi cam kết 100% xe nhập khẩu chính hãng, nguyên chiếc, với đầy đủ giấy tờ chứng nhận nguồn gốc xuất xứ và kiểm định chất lượng từ nhà sản xuất. Mỗi chiếc xe trước khi bàn giao đều phải vượt qua hàng trăm hạng mục kiểm tra kỹ thuật nghiêm ngặt nhất, đảm bảo tình trạng hoàn hảo không tì vết.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">2. Uy tín là kim chỉ nam, chất lượng là sinh mệnh</h3>
                <p>Trong lĩnh vực kinh doanh hàng xa xỉ, uy tín chính là tài sản quý giá nhất. Tại CarStore, chữ "Tín" được xây dựng từ sự minh bạch trong mọi khâu vận hành. Quý khách hàng sẽ được cung cấp toàn bộ thông tin chi tiết về thông số kỹ thuật, lịch sử bảo dưỡng (đối với xe lướt), giấy tờ hải quan và biểu thuế rõ ràng. Chúng tôi tuyệt đối nói không với sự mập mờ, bóp méo thông tin hay cung cấp những sản phẩm kém chất lượng.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">3. Đảm bảo an toàn và pháp lý tuyệt đối</h3>
                <p>Sở hữu một khối tài sản di động trị giá hàng chục, hàng trăm tỷ đồng đòi hỏi một quy trình pháp lý chặt chẽ và an toàn tuyệt đối. CarStore cung cấp dịch vụ hỗ trợ pháp lý trọn gói, từ thủ tục đăng ký, đăng kiểm, nộp thuế cho đến việc mua bảo hiểm vật chất toàn diện. Quý khách hàng chỉ cần lựa chọn chiếc xe ưng ý, mọi thủ tục giấy tờ phức tạp sẽ được đội ngũ chuyên viên pháp lý của chúng tôi xử lý nhanh gọn, chính xác và bảo mật thông tin tuyệt đối.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">4. Đặc quyền hậu mãi - Đồng hành trọn vòng đời</h3>
                <p>Sự tận tâm của CarStore không dừng lại ở thời điểm khách hàng nhận chìa khóa. Đó mới chỉ là bước khởi đầu cho một chặng đường đồng hành dài lâu. Chúng tôi sở hữu trung tâm dịch vụ bảo dưỡng và sửa chữa đạt chuẩn quốc tế, được trang bị hệ thống máy móc chẩn đoán tối tân nhất. Đội ngũ kỹ thuật viên của CarStore đều được đào tạo bài bản, cấp chứng chỉ trực tiếp từ các hãng xe danh tiếng, đảm bảo khả năng xử lý những vấn đề kỹ thuật phức tạp nhất.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">5. Gia nhập câu lạc bộ tinh hoa</h3>
                <p>Trở thành khách hàng của CarStore, bạn chính thức bước chân vào một cộng đồng tinh hoa, nơi quy tụ những doanh nhân, nghệ sĩ và những cá nhân xuất chúng có chung niềm đam mê bất tận với siêu xe. Chúng tôi thường xuyên tổ chức các sự kiện Private (kín) như: tiệc ra mắt xe mới, các chuyến hành trình siêu xe xuyên Việt, các giải đấu Golf tri ân và những đêm tiệc Gala sang trọng.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">Lời kết</h3>
                <p>Với triết lý kinh doanh "Lấy khách hàng làm trung tâm, lấy sự hoàn hảo làm tiêu chuẩn", CarStore đang từng bước khẳng định vị thế độc tôn của mình trên bản đồ thị trường xe sang Việt Nam. Chúng tôi cam kết sẽ không ngừng nỗ lực, nâng tầm dịch vụ để mang đến những trải nghiệm vượt trên cả sự mong đợi. Hãy đến với CarStore để chạm tay vào kiệt tác, cầm lái giấc mơ và khẳng định vị thế dẫn đầu của chính bạn.</p>
                <div class="mt-16 pt-8 border-t border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-sm tracking-wider">Thành viên của Carstore:</h4>
                    <ul class="text-sm text-gray-600 space-y-3">
                        <li class="flex items-center gap-3"><i class="fa-solid fa-user-tie text-blue-600 w-5"></i> <strong class="text-gray-800 font-semibold">Lữ Chiến Tấn Sang</strong> - Chủ Carstore</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-user text-gray-400 w-5"></i> <strong class="text-gray-800 font-semibold">Đặng Yên Chí Tài</strong> - Nhân viên</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-user text-gray-400 w-5"></i> <strong class="text-gray-800 font-semibold">Vũ Hữu Viên Minh</strong> - Nhân viên</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-user text-gray-400 w-5"></i> <strong class="text-gray-800 font-semibold">Ngô Huỳnh Anh Quốc</strong> - Nhân viên</li>
                        <li class="flex items-center gap-3"><i class="fa-solid fa-user text-gray-400 w-5"></i> <strong class="text-gray-800 font-semibold">Lâm Kim Khánh</strong> - Nhân viên</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    {{-- Sử dụng footer riêng --}}
    @include('footer')

    <script>
        // ========== AUTH & CART ==========
        document.addEventListener('DOMContentLoaded', async () => {
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

            await updateCartCount();
        });

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

        async function updateCartCount() {
            const token = localStorage.getItem('token');
            if (!token) {
                document.getElementById('cart-count').textContent = '0';
                return;
            }
            try {
                const res = await fetch('/api/cart', {
                    headers: { 'Authorization': 'Bearer ' + token }
                });
                const data = await res.json();
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
    </script>
</body>
</html>
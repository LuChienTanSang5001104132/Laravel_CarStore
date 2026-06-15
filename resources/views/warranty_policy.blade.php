<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Chính Sách Bảo Hành | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>*{font-family:'Inter',system-ui,-apple-system,sans-serif;}html{scroll-behavior:smooth;}</style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-black text-blue-600 flex items-center gap-2 tracking-tight">
                <i class="fas fa-car-side text-blue-600"></i>
                <span class="bg-gradient-to-r from-blue-700 to-blue-500 bg-clip-text text-transparent">CARSTORE</span>
            </a>
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                <a href="/" class="hover:text-blue-600 transition">Trang chủ</a>
                <a href="#" class="hover:text-blue-600 transition">Mẫu xe</a>
                <a href="#" class="hover:text-blue-600 transition">Ưu đãi</a>
                <a href="#" class="hover:text-blue-600 transition">Video</a>
                <a href="/contact" class="hover:text-blue-600 transition">Liên hệ</a>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative group cursor-pointer" id="account-menu">
                    <div class="text-gray-700 group-hover:text-blue-600 font-medium flex items-center gap-2 text-sm py-2 transition">
                        <i class="fa-regular fa-user"></i> Tài khoản
                        <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-hover:rotate-180"></i>
                    </div>
                    <div class="absolute top-full right-0 w-full h-4"></div>
                    <div class="absolute top-full right-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50 overflow-hidden">
                        <a href="/login" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-b border-gray-50 transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-to-bracket w-4"></i> Đăng nhập
                        </a>
                        <a href="/register" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition flex items-center gap-2">
                            <i class="fa-solid fa-user-plus w-4"></i> Đăng ký
                        </a>
                    </div>
                </div>
                <a href="/cart" class="text-gray-700 hover:text-blue-600 font-medium flex items-center gap-2 text-sm relative py-2 transition">
                    <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
                    <span class="absolute top-0 -right-3 bg-blue-600 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center shadow-sm">0</span>
                </a>
            </div>
        </div>
    </nav>
    <main class="flex-grow w-full bg-white">
        <div class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-4xl font-bold text-center text-blue-600 mb-4 uppercase tracking-tight">Chính Sách Bảo Hành</h1>
            <p class="text-center text-gray-500 mb-12">Đảm bảo quyền lợi tối đa - Đồng hành cùng bạn trên mọi nẻo đường</p>
            <div class="space-y-6 text-gray-700 leading-relaxed text-justify text-lg">
                <p>Kính chào Quý khách hàng, CarStore (thuộc hệ thống Kẹo Dừa Vĩnh Long) vô cùng vinh hạnh khi được Quý khách tin tưởng và lựa chọn làm nơi gửi gắm niềm đam mê tốc độ. Để đảm bảo chiếc xe của Quý khách luôn vận hành trong tình trạng hoàn hảo nhất, chúng tôi thiết lập và áp dụng một hệ thống chính sách bảo hành chính hãng chuẩn quốc tế. Mọi quy định dưới đây được xây dựng dựa trên tiêu chuẩn khắt khe nhất của các thương hiệu xe sang hàng đầu thế giới.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">1. Thời hạn và điều kiện bảo hành cơ bản</h3>
                <p>Tất cả các dòng xe mới (New Cars) được phân phối chính thức tại CarStore đều được hưởng chế độ bảo hành tiêu chuẩn kéo dài <strong>05 năm hoặc 100.000 km</strong> (tùy thuộc điều kiện nào đến trước), tính từ thời điểm xe được bàn giao chính thức cho khách hàng. Đối với các dòng xe siêu sang và siêu xe đặc biệt, thời hạn bảo hành có thể được nâng lên theo chế độ riêng biệt của từng hãng.</p>
                <p>Bên cạnh đó, đối với các dòng xe điện, cụm pin cao áp (High-Voltage Battery) sẽ được áp dụng chính sách bảo hành độc lập lên đến <strong>08 năm hoặc 160.000 km</strong>. Chúng tôi cam kết thay mới hoặc sửa chữa miễn phí nếu dung lượng pin hao hụt xuống dưới 70% trong thời gian bảo hành hợp lệ.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">2. Phạm vi áp dụng bảo hành</h3>
                <p>CarStore chịu trách nhiệm bảo hành, sửa chữa hoặc thay thế miễn phí bất kỳ chi tiết, linh kiện nào bị hư hỏng do lỗi vật liệu hoặc lỗi lắp ráp từ phía nhà sản xuất. Phạm vi bảo hành bao gồm nhưng không giới hạn ở:</p>
                <ul class="list-disc pl-6 space-y-2 mt-2">
                    <li>Hệ thống động cơ, hộp số và hệ dẫn động.</li>
                    <li>Hệ thống điện, điện tử và các cảm biến trên xe.</li>
                    <li>Hệ thống làm mát, hệ thống điều hòa nhiệt độ.</li>
                    <li>Khung gầm và hệ thống treo, hệ thống lái.</li>
                    <li>Chính sách chống rỉ sét xuyên thủng thân vỏ (lên đến 10 năm).</li>
                </ul>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">3. Các trường hợp từ chối bảo hành</h3>
                <p>Để đảm bảo tính công bằng và tuân thủ nguyên tắc kỹ thuật, chế độ bảo hành sẽ không được áp dụng đối với những trường hợp sau đây:</p>
                <ul class="list-disc pl-6 space-y-2 mt-2">
                    <li>Những hư hỏng do hao mòn tự nhiên trong quá trình sử dụng (ví dụ: má phanh, lốp xe, cần gạt nước, các loại bộ lọc, bugi, dây đai truyền động...).</li>
                    <li>Hư hỏng phát sinh do khách hàng không tuân thủ lịch bảo dưỡng định kỳ tại các trung tâm dịch vụ ủy quyền của CarStore.</li>
                    <li>Xe bị thay đổi kết cấu, can thiệp phần mềm (remap động cơ), hoặc lắp đặt các phụ tùng, phụ kiện không chính hãng mà không có sự chấp thuận bằng văn bản từ CarStore.</li>
                    <li>Hư hỏng do tai nạn giao thông, va chạm, hỏa hoạn, ngập nước (thủy kích), hoặc các thảm họa thiên nhiên khác.</li>
                    <li>Sử dụng sai nhiên liệu, dầu nhớt hoặc hóa chất không đúng với khuyến cáo của nhà sản xuất ghi trong sách hướng dẫn sử dụng.</li>
                </ul>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">4. Trách nhiệm của chủ sở hữu</h3>
                <p>Để duy trì hiệu lực của sổ bảo hành, Quý khách hàng cần thực hiện đúng và đủ các trách nhiệm sau: Đọc kỹ Sách hướng dẫn sử dụng được giao kèm theo xe; Đảm bảo thực hiện bảo dưỡng định kỳ đúng hạn tại các xưởng dịch vụ của CarStore; Kịp thời mang xe đến kiểm tra ngay khi phát hiện các đèn cảnh báo trên bảng điều khiển hoặc các âm thanh, rung động bất thường. Việc tự ý đưa xe đến các garage bên ngoài không được ủy quyền có thể dẫn đến việc xe bị từ chối bảo hành.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">5. Quy trình tiếp nhận và xử lý bảo hành</h3>
                <p>Khi xe gặp sự cố nằm trong phạm vi bảo hành, Quý khách chỉ cần liên hệ ngay với đường dây nóng hỗ trợ 24/7 của CarStore. Đội ngũ chuyên viên sẽ lập tức hướng dẫn xử lý từ xa hoặc điều phối xe cứu hộ chuyên dụng đến đưa xe Quý khách về trung tâm dịch vụ gần nhất hoàn toàn miễn phí. Tại đây, các kỹ sư lành nghề sẽ tiến hành kiểm tra bằng hệ thống máy tính chuyên dụng, xác định lỗi và thông báo phương án khắc phục. Mọi chi phí về nhân công và phụ tùng thay thế thuộc diện bảo hành sẽ do CarStore chi trả 100%.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">Dịch vụ hỗ trợ thay thế phương tiện</h3>
                <p>Đặc biệt, thấu hiểu sự bất tiện của Quý khách khi xe phải nằm xưởng, đối với những ca bảo dưỡng hoặc sửa chữa phức tạp kéo dài hơn 48 giờ, CarStore sẽ cung cấp cho Quý khách một chiếc xe sang trọng tương đương để sử dụng tạm thời (Courtesy Car) trong suốt quá trình chờ đợi.</p>
                <p class="font-semibold mt-8 italic text-gray-600">CarStore - Trách nhiệm đến cùng, cam kết dài lâu. Xin trân trọng cảm ơn Quý khách!</p>
            </div>
        </div>
    </main>
    <footer class="bg-gray-900 text-gray-300 pt-14 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div>
                <div class="flex items-center gap-2 text-2xl font-black text-white mb-4">
                    <i class="fa-solid fa-car-side text-blue-500"></i> CARSTORE
                </div>
                <p class="text-sm text-gray-400">Hệ thống phân phối xe chính hãng. Mang đẳng cấp đến gần hơn.</p>
                <div class="flex gap-4 mt-5">
                    <a href="https://www.facebook.com/T.Seng.LC2027" target="_blank" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/tnsng2027/" target="_blank" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@TSengLC2027" target="_blank" class="text-gray-400 hover:text-white transition text-xl"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Khám phá</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-blue-400">Đội xe mới nhất</a></li>
                    <li><a href="#" class="hover:text-blue-400">Chương trình lái thử</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Tin tức & sự kiện</a></li>
                    <li><a href="#" class="hover:text-blue-400">Video giới thiệu</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Hỗ trợ</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/warranty-policy" class="hover:text-blue-400">Chính sách bảo hành</a></li>
                    <li><a href="/installment" class="hover:text-blue-400">Trả góp & vay</a></li>
                    <li><a href="/contact" class="hover:text-blue-400">Liên hệ showroom</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Liên hệ</h4>
                <ul class="space-y-2 text-sm">
                    <li><i class="fa-solid fa-location-dot mr-2 w-4 text-blue-400"></i> 280, An Dương Vương, phường Chợ Quán Thành phố Hồ Chí Minh</li>
                    <li><i class="fa-solid fa-phone mr-2 text-blue-400"></i> 0964584850</li>
                    <li><i class="fa-regular fa-envelope mr-2 text-blue-400"></i> luchientansang@gmail.com</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-6 text-center text-xs text-gray-500">
            © 2025 CARSTORE. Được thực hiện bởi Team Kẹo dừa Vĩnh Long.
        </div>
    </footer>
    <script>
        function hien_thi_menu_tai_khoan() {
            const trinh_don = document.getElementById('account-menu');
            if (!trinh_don) return;
            const ma_thong_bao = localStorage.getItem('carstore_token');
            const chuoi_nguoi_dung = localStorage.getItem('carstore_user');
            if (!ma_thong_bao || !chuoi_nguoi_dung) return;
            let nguoi_dung;
            try { nguoi_dung = JSON.parse(chuoi_nguoi_dung); } catch (loi) { return; }
            const la_quan_tri = nguoi_dung.role === 'admin';
            trinh_don.innerHTML = `
                <div class="text-blue-600 font-medium flex items-center gap-2 text-sm py-2 transition">
                    <i class="fa-regular fa-circle-user text-lg"></i> Xin chào, ${nguoi_dung.name}
                    <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-hover:rotate-180"></i>
                </div>
                <div class="absolute top-full right-0 w-full h-4"></div>
                <div class="absolute top-full right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50 overflow-hidden">
                    ${la_quan_tri ? `<a href="/admin/dashboard" class="block px-5 py-3 text-sm font-medium text-purple-700 hover:bg-purple-50 border-b border-gray-50 transition flex items-center gap-2"><i class="fa-solid fa-chart-line w-4"></i> Quản trị Admin</a>` : ''}
                    <a href="/profile" class="block px-5 py-3 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-600 border-b border-gray-50 transition flex items-center gap-2"><i class="fa-solid fa-id-card w-4"></i> Trang cá nhân</a>
                    <button id="nut-dang-xuat" type="button" class="w-full text-left block px-5 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition flex items-center gap-2"><i class="fa-solid fa-right-from-bracket w-4"></i> Đăng xuất</button>
                </div>
            `;
            const nut_dang_xuat = document.getElementById('nut-dang-xuat');
            if (nut_dang_xuat) {
                nut_dang_xuat.addEventListener('click', async () => {
                    try {
                        await fetch('/api/logout', { method: 'POST', headers: { 'Authorization': 'Bearer ' + ma_thong_bao, 'Accept': 'application/json' } });
                    } catch (loi) {}
                    localStorage.removeItem('carstore_token');
                    localStorage.removeItem('carstore_user');
                    window.location.href = '/';
                });
            }
        }
        hien_thi_menu_tai_khoan();
    </script>
</body>
</html>
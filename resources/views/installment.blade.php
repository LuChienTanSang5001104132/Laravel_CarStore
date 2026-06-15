<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Trả Góp & Vay | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{font-family:'Inter',system-ui,-apple-system,sans-serif;}
        html{scroll-behavior:smooth;}
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Header chung (đã tích hợp token, profile, cart count) --}}
    @include('header')

    <main class="flex-grow w-full bg-white">
        <div class="max-w-4xl mx-auto px-4 py-16">
            <h1 class="text-4xl font-bold text-center text-blue-600 mb-4 uppercase tracking-tight">Giải Pháp Tài Chính Toàn Diện</h1>
            <p class="text-center text-gray-500 mb-12">Hiện thực hóa giấc mơ siêu xe với dòng tiền tối ưu và linh hoạt nhất</p>
            <div class="space-y-6 text-gray-700 leading-relaxed text-justify text-lg">
                <p>Tại CarStore, chúng tôi thấu hiểu rằng việc sở hữu một chiếc siêu xe hay xe sang không chỉ là sự thỏa mãn đam mê tốc độ, mà còn là một quyết định đầu tư và phân bổ tài sản chiến lược của giới thượng lưu. Chính vì vậy, CarStore tự hào mang đến những giải pháp tài chính "may đo" độc bản, giúp Quý khách hàng tối ưu hóa dòng tiền kinh doanh trong khi vẫn tận hưởng trọn vẹn đẳng cấp sống khác biệt.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">1. Đối tác chiến lược từ các định chế tài chính hàng đầu</h3>
                <p>Nhằm mang lại đặc quyền tối thượng cho khách hàng, CarStore đã ký kết hợp tác chiến lược với các khối ngân hàng khách hàng cá nhân cao cấp (VIP Banking) từ những định chế tài chính trong nước và quốc tế uy tín nhất. Sự hợp tác này cho phép chúng tôi thiết kế những gói vay mua xe với điều khoản ưu việt mà Quý khách khó có thể tìm thấy ở các nền tảng tín dụng thông thường.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">2. Lãi suất đặc quyền & Hạn mức vượt trội</h3>
                <p>Khách hàng của CarStore sẽ được hưởng mức lãi suất ưu đãi cực kỳ cạnh tranh, cố định trong biên độ dài hạn, giúp loại bỏ mọi rủi ro về biến động thị trường. Hạn mức tài trợ linh hoạt có thể lên đến <strong>80% - 90% giá trị xe</strong>, đi kèm với thời gian vay kéo dài tối đa lên tới <strong>8 năm (96 tháng)</strong>. Điều này giúp giảm thiểu tối đa áp lực thanh toán hàng tháng, giải phóng nguồn vốn để Quý khách tiếp tục sinh lời trong các dự án kinh doanh khác.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">3. Quy trình thẩm định "VIP" nhanh chóng</h3>
                <p>Sự chờ đợi không có trong từ điển của sự đẳng cấp. CarStore áp dụng quy trình thẩm định tín dụng "Fast-track" dành riêng cho khách hàng mua xe sang. Hồ sơ được tinh gọn đến mức tối đa, miễn trừ nhiều loại giấy tờ chứng minh tài chính phức tạp đối với tệp khách hàng doanh nghiệp hoặc cá nhân có lịch sử tín dụng tốt. Thời gian phê duyệt hồ sơ và giải ngân được tính bằng giờ, đảm bảo chiếc siêu xe mơ ước sẽ có mặt tại garage của Quý khách trong thời gian ngắn nhất.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">4. Linh hoạt trong phương án thanh toán</h3>
                <p>Chúng tôi cung cấp đa dạng các phác đồ thanh toán để phù hợp tuyệt đối với chu kỳ dòng tiền của Quý khách. Từ phương án trả gốc lãi giảm dần truyền thống, đến giải pháp thanh toán Balloon (trả một khoản lớn vào cuối kỳ), hay đặc quyền thanh toán trước hạn với mức phí phạt tiệm cận 0%. Mọi điều khoản đều được thiết kế trên sự thấu hiểu và tôn trọng lợi ích tối đa của khách hàng.</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-10 mb-4 uppercase">5. Bảo mật thông tin tài chính tuyệt đối</h3>
                <p>Mọi thông tin cá nhân, doanh nghiệp và số liệu tài chính của Quý khách trong quá trình tư vấn và làm hồ sơ vay vốn đều được mã hóa và bảo mật theo chuẩn an ninh thông tin cấp độ cao nhất. CarStore cam kết chỉ sử dụng thông tin cho mục đích hoàn thiện hồ sơ với đối tác ngân hàng đã được sự chấp thuận trực tiếp từ Quý khách.</p>
                <p class="font-semibold mt-8 italic text-gray-600">Đừng để dòng tiền trở thành rào cản của sự tận hưởng. Hãy để các chuyên gia tài chính của CarStore đồng hành cùng Quý khách, biến mọi khát khao chinh phục đỉnh cao cơ khí trở thành hiện thực ngay hôm nay!</p>
            </div>
        </div>
    </main>

    {{-- Footer chung --}}
    @include('footer')

    <script>
        // Nếu header đã export hàm updateCartCount ra window thì không cần định nghĩa lại
        // Tuy nhiên, để đảm bảo an toàn, ta kiểm tra và dùng hàm có sẵn, nếu không thì tự định nghĩa.
        if (typeof window.updateCartCount !== 'function') {
            window.updateCartCount = async function() {
                const token = localStorage.getItem('token');
                const cartCountSpan = document.getElementById('cart-count');
                if (!token) {
                    if (cartCountSpan) cartCountSpan.textContent = '0';
                    return;
                }
                try {
                    const res = await fetch('/api/cart', {
                        headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success && Array.isArray(data.data)) {
                        const totalQty = data.data.reduce((sum, item) => sum + (item.quantity || 0), 0);
                        if (cartCountSpan) cartCountSpan.textContent = totalQty;
                    } else {
                        if (cartCountSpan) cartCountSpan.textContent = '0';
                    }
                } catch(e) {
                    console.error('Lỗi cập nhật số lượng giỏ:', e);
                    if (cartCountSpan) cartCountSpan.textContent = '0';
                }
            };
        }

        // Đảm bảo cập nhật giỏ hàng khi trang tải (nếu header chưa làm)
        document.addEventListener('DOMContentLoaded', async () => {
            if (typeof window.updateCartCount === 'function') {
                await window.updateCartCount();
            }
        });
    </script>
</body>
</html>
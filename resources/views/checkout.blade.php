<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    {{-- Header chung (đã tích hợp token, profile, cart count) --}}
    @include('header')

    <main class="flex-grow">
        <div class="max-w-2xl mx-auto p-8 mt-10 bg-white rounded-2xl shadow-sm border border-gray-100">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-blue-600"></i> Thông Tin Giao Hàng
            </h2>
            
            <form id="checkoutForm" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                    <input type="text" id="full_name" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required placeholder="Nhập họ và tên người nhận...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                    <input type="text" id="phone" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required placeholder="Nhập số điện thoại liên hệ...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ giao hàng</label>
                    <textarea id="address" rows="3" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition" required placeholder="Nhập địa chỉ nhận xe chi tiết..."></textarea>
                </div>
                
                <input type="hidden" id="payment_method" value="vietqr">

                <button type="submit" id="submitBtn" class="w-full mt-4 bg-blue-600 text-white py-3.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-md shadow-blue-100 text-lg">
                    Xác nhận đặt hàng
                </button>
            </form>

            <div id="payment-box" class="hidden mt-6 text-center p-8 border-2 border-dashed border-blue-200 rounded-xl bg-blue-50">
                <h3 class="font-bold text-xl mb-2 text-blue-800">Quét mã để thanh toán</h3>
                <p class="text-sm text-gray-600 mb-6">Sử dụng App ngân hàng để quét mã QR dưới đây</p>
                
                <div class="bg-white p-4 rounded-xl shadow-sm inline-block mb-4">
                    <img id="qr-code" src="" class="mx-auto w-64 h-64 object-contain" alt="QR Code Thanh Toán">
                </div>
                
                <p class="mt-2 font-medium text-gray-800 bg-white inline-block px-4 py-2 rounded-lg border">Mã đơn hàng: <span id="order-id-display" class="text-blue-600 font-bold"></span></p>
                
                <button onclick="confirmPayment()" class="mt-8 w-full bg-green-600 text-white py-3.5 rounded-xl font-bold hover:bg-green-700 transition shadow-md shadow-green-100 text-lg flex justify-center items-center gap-2">
                    <i class="fas fa-check-circle"></i> Tôi đã thanh toán thành công
                </button>
            </div>
        </div>
    </main>

    {{-- Footer chung --}}
    @include('footer')

    <script>
        // Kiểm tra đăng nhập
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Bạn cần đăng nhập để truy cập trang này!');
            window.location.href = '/login';
        }

        let currentOrderId = null;

        // Tự động điền thông tin Profile nếu có
        async function prefillData() {
            try {
                const res = await fetch('/api/profile', {
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
                const result = await res.json();
                if (result.status === 'success') {
                    const user = result.user || result.data;
                    if (user.full_name) document.getElementById('full_name').value = user.full_name;
                    if (user.phone) document.getElementById('phone').value = user.phone;
                    if (user.address) document.getElementById('address').value = user.address;
                }
            } catch (error) {
                console.error('Lỗi lấy profile:', error);
            }
        }
        prefillData();

        // Xử lý đặt hàng
        document.getElementById('checkoutForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';

            try {
                const res = await fetch('/api/orders', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        customer_full_name: document.getElementById('full_name').value,
                        customer_phone: document.getElementById('phone').value,
                        customer_address: document.getElementById('address').value,
                        payment_method: 'vietqr'
                    })
                });

                const result = await res.json();

                if (res.ok && result.status === 'success') {
                    currentOrderId = result.data.id;
                    const total = result.data.total_amount;

                    document.getElementById('order-id-display').textContent = '#' + currentOrderId;
                    const qrUrl = `https://img.vietqr.io/image/MB-0366907515-compact.png?amount=${total}&addInfo=DonHang${currentOrderId}&accountName=CHITAI`;
                    document.getElementById('qr-code').src = qrUrl;

                    document.getElementById('payment-box').classList.remove('hidden');
                    document.getElementById('checkoutForm').classList.add('hidden');
                } else {
                    alert(result.message || 'Có lỗi xảy ra khi tạo đơn hàng!');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Xác nhận đặt hàng';
                }
            } catch (err) {
                console.error(err);
                alert('Không thể kết nối đến máy chủ.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Xác nhận đặt hàng';
            }
        });

        // Xác nhận thanh toán
        async function confirmPayment() {
            if (!currentOrderId) {
                alert('Không tìm thấy đơn hàng!');
                return;
            }
            try {
                const res = await fetch(`/api/orders/${currentOrderId}/confirm-payment`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });

                if (res.ok) {
                    alert('Đặt hàng và thanh toán thành công! Cảm ơn bạn đã mua sắm.');
                    window.location.href = '/';
                } else {
                    alert('Có lỗi xảy ra khi xác nhận, vui lòng thử lại.');
                }
            } catch (err) {
                alert('Lỗi kết nối máy chủ!');
            }
        }
    </script>
</body>
</html>
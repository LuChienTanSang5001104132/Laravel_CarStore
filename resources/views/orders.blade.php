<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Mua Hàng | CarStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .status-badge {
            @apply px-3 py-1 rounded-full text-xs font-semibold;
        }
        .status-pending { background-color: #fef3c7; color: #d97706; }
        .status-processing { background-color: #dbeafe; color: #2563eb; }
        .status-completed { background-color: #d1fae5; color: #059669; }
        .status-cancelled { background-color: #fee2e2; color: #dc2626; }
        .status-shipped { background-color: #e0e7ff; color: #4f46e5; }
        .status-refunded { background-color: #fce7f3; color: #db2777; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        
        /* Hiệu ứng mượt cho Modal */
        #orderModal { transition: opacity 0.3s ease; }
        #orderModalContent { transition: transform 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    @include('header')

    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center flex-wrap gap-3">
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i> Lịch Sử Đơn Hàng
                </h1>
                <button id="refreshBtn" class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center gap-1 font-semibold bg-blue-50 px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-rotate-right"></i> Làm mới
                </button>
            </div>
            
            <div id="orders-container" class="p-6">
                <div class="text-center py-12" id="loading-state">
                    <i class="fas fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
                    <p class="text-gray-500 font-medium">Đang tải lịch sử mua hàng của bạn...</p>
                </div>
            </div>
        </div>
    </main>

    <div id="orderModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none">
        <div id="orderModalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col scale-95">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                    <i class="fas fa-receipt text-blue-600"></i> Chi Tiết Đơn Hàng <span id="modal-order-id" class="text-blue-600"></span>
                </h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-grow bg-white">
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <p class="text-gray-500 mb-1">Ngày đặt hàng:</p>
                        <p id="modal-order-date" class="font-semibold text-gray-800">--</p>
                    </div>
                    <div>
                        <p class="text-gray-500 mb-1">Trạng thái:</p>
                        <p id="modal-order-status" class="font-semibold">--</p>
                    </div>
                    <div class="col-span-2 bg-blue-50 rounded-xl p-4 mt-2 border border-blue-100">
                        <p class="text-blue-800 font-bold mb-2 uppercase text-xs">Thông tin nhận xe:</p>
                        <p class="font-medium text-gray-800"><i class="fas fa-user text-blue-400 mr-2"></i><span id="modal-order-name"></span></p>
                        <p class="font-medium text-gray-800 mt-1"><i class="fas fa-phone text-blue-400 mr-2"></i><span id="modal-order-phone"></span></p>
                        <p class="font-medium text-gray-800 mt-1"><i class="fas fa-map-marker-alt text-blue-400 mr-2"></i><span id="modal-order-address"></span></p>
                    </div>
                </div>

                <h4 class="font-bold text-gray-800 mb-3 border-b pb-2">Sản phẩm đã mua</h4>
                <div id="modal-order-items" class="space-y-3 mb-6">
                    </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-between items-center">
                <div class="text-sm font-medium text-gray-500">
                    Thanh toán: <span id="modal-payment-status" class="font-bold">--</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Tổng cộng</p>
                    <p id="modal-total-amount" class="text-2xl font-black text-blue-600">--</p>
                </div>
            </div>
        </div>
    </div>

    @include('footer')

    <script>
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Vui lòng đăng nhập để xem lịch sử mua hàng!');
            window.location.href = '/login';
        }

        async function fetchOrders() {
            const container = document.getElementById('orders-container');
            container.innerHTML = `
                <div class="text-center py-12">
                    <i class="fas fa-circle-notch fa-spin text-4xl text-blue-500 mb-4"></i>
                    <p class="text-gray-500 font-medium">Đang tải đơn hàng...</p>
                </div>
            `;
            
            try {
                const res = await fetch('/api/orders', {
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const result = await res.json();
                
                if (res.ok && result.status === 'success') {
                    renderOrders(result.data || []);
                } else {
                    showError(result.message || 'Không thể tải đơn hàng');
                }
            } catch (err) {
                showError('Lỗi kết nối máy chủ');
            }
        }

        function renderOrders(orders) {
            const container = document.getElementById('orders-container');
            if (!orders || orders.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-box-open text-4xl text-gray-300"></i>
                        </div>
                        <p class="text-gray-500 text-lg font-medium">Bạn chưa có đơn hàng nào.</p>
                        <a href="/mauxe" class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition shadow-md">
                            <i class="fa-solid fa-car"></i> Khám phá xe ngay
                        </a>
                    </div>
                `;
                return;
            }
            
            const html = `
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mã đơn</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Thanh toán</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            ${orders.map(order => `
                                <tr class="hover:bg-blue-50/50 transition duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">#${order.id}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">${formatDate(order.created_at)}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-blue-600">${formatCurrency(order.total_amount)}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-badge ${getStatusClass(order.status)}">${getStatusText(order.status)}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-badge ${getPaymentClass(order.payment_status)}">${getPaymentText(order.payment_status)}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <button onclick="viewOrderDetail(${order.id})" class="bg-gray-100 text-gray-700 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-lg transition font-semibold text-xs shadow-sm">
                                            Xem chi tiết
                                        </button>
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            container.innerHTML = html;
        }

        // ==================== CÁC HÀM FORMAT ====================
        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const date = new Date(dateStr);
            return date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        function getStatusClass(status) {
            const map = {
                'pending': 'status-pending', 'processing': 'status-processing', 'shipped': 'status-shipped',
                'completed': 'status-completed', 'cancelled': 'status-cancelled', 'refunded': 'status-refunded'
            };
            return map[status] || 'status-pending';
        }

        function getStatusText(status) {
            const map = {
                'pending': 'Chờ xử lý', 'processing': 'Đang xử lý', 'shipped': 'Đang giao',
                'completed': 'Hoàn thành', 'cancelled': 'Đã hủy', 'refunded': 'Hoàn tiền'
            };
            return map[status] || status;
        }

        function getPaymentClass(pStatus) {
            const map = { 'pending': 'status-pending', 'paid': 'status-completed', 'failed': 'status-cancelled', 'refunded': 'status-refunded' };
            return map[pStatus] || 'status-pending';
        }

        function getPaymentText(pStatus) {
            const map = { 'pending': 'Chưa thanh toán', 'paid': 'Đã thanh toán', 'failed': 'Thất bại', 'refunded': 'Đã hoàn tiền' };
            return map[pStatus] || pStatus;
        }

        function showError(message) {
            document.getElementById('orders-container').innerHTML = `
                <div class="text-center py-12 text-red-500">
                    <i class="fa-solid fa-circle-exclamation text-4xl mb-3"></i>
                    <p class="font-bold">${message}</p>
                    <button onclick="fetchOrders()" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-xl hover:bg-blue-700 transition shadow-md">Thử lại</button>
                </div>
            `;
        }

        // ==================== LOGIC XỬ LÝ MODAL ====================
        async function viewOrderDetail(orderId) {
            try {
                const res = await fetch(`/api/orders/${orderId}`, {
                    headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' }
                });
                const result = await res.json();
                
                if (res.ok && result.status === 'success') {
                    const order = result.data;
                    
                    // Đổ dữ liệu text
                    document.getElementById('modal-order-id').innerText = order.id;
                    document.getElementById('modal-order-date').innerText = formatDate(order.created_at);
                    
                    document.getElementById('modal-order-name').innerText = order.customer_full_name || 'Không có';
                    document.getElementById('modal-order-phone').innerText = order.customer_phone || 'Không có';
                    // Đã fix lỗi field: dùng customer_address
                    document.getElementById('modal-order-address').innerText = order.customer_address || 'Không có'; 
                    
                    // Render HTML sản phẩm
                    let itemsHtml = '';
                    if (order.items && order.items.length) {
                        itemsHtml = order.items.map(item => `
                            <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0 bg-gray-50/50 px-3 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center border shadow-sm text-gray-400">
                                        <i class="fas fa-car-side"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">${item.car ? item.car.name : 'Sản phẩm đã xóa'}</p>
                                        <p class="text-xs text-gray-500">Số lượng: ${item.quantity}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-blue-600">${formatCurrency(item.quantity * item.price)}</span>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        itemsHtml = '<div class="text-gray-500 py-4 text-center italic">Không tìm thấy chi tiết sản phẩm</div>';
                    }
                    
                    document.getElementById('modal-order-items').innerHTML = itemsHtml;
                    
                    // Trạng thái và tổng tiền
                    document.getElementById('modal-order-status').innerHTML = `<span class="status-badge ${getStatusClass(order.status)}">${getStatusText(order.status)}</span>`;
                    document.getElementById('modal-payment-status').innerHTML = `<span class="${order.payment_status === 'paid' ? 'text-green-600' : 'text-orange-500'}">${getPaymentText(order.payment_status)}</span>`;
                    document.getElementById('modal-total-amount').innerText = formatCurrency(order.total_amount);

                    // Mở Modal
                    openModal();
                } else {
                    alert('Không thể tải chi tiết đơn hàng');
                }
            } catch (err) {
                alert('Lỗi kết nối khi tải chi tiết');
            }
        }

        function openModal() {
            const modal = document.getElementById('orderModal');
            const content = document.getElementById('orderModalContent');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }

        function closeModal() {
            const modal = document.getElementById('orderModal');
            const content = document.getElementById('orderModalContent');
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
        }

        // Đóng modal khi click ra ngoài vùng xám
        document.getElementById('orderModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Sự kiện nút làm mới
        document.getElementById('refreshBtn').addEventListener('click', fetchOrders);

        // Khởi động
        document.addEventListener('DOMContentLoaded', fetchOrders);
    </script>
</body>
</html>
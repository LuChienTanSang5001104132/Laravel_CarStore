<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Của Tôi - CarStore</title>
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
        <div class="max-w-6xl mx-auto p-6 mt-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Thông Tin Cá Nhân</h2>
                <form id="profileForm">
                    <div class="flex flex-col items-center mb-6">
                        <img id="avatarPreview" src="/images/default-avatar.png" onerror="this.src='https://ui-avatars.com/api/?name=User&background=random'" class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-sm mb-4">
                        <label class="cursor-pointer bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                            <i class="fas fa-camera mr-1"></i> Chọn ảnh mới
                            <input type="file" id="avatarInput" class="hidden" accept="image/*">
                        </label>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Họ và Tên</label>
                            <input type="text" id="full_name" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                            <input type="text" id="phone" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                            <input type="text" id="address" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="birth" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-bold shadow-md">Lưu Hồ Sơ</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Đổi Mật Khẩu</h2>
                <form id="passwordForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mật khẩu hiện tại</label>
                        <input type="password" id="current_password" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mật khẩu mới</label>
                        <input type="password" id="new_password" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Xác nhận mật khẩu mới</label>
                        <input type="password" id="new_password_confirmation" required class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-bold shadow-md">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>
    </main>

    {{-- Footer chung --}}
    @include('footer')

    <script>
        // Kiểm tra token ngay khi vào trang
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Vui lòng đăng nhập để xem hồ sơ!');
            window.location.href = '/login';
        }

        // Tải thông tin profile
        async function loadProfile() {
            try {
                const res = await fetch('/api/profile', {
                    headers: { 
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    }
                });
                const result = await res.json();
                if (result.status === 'success') {
                    const user = result.user || result.data; 
                    
                    document.getElementById('full_name').value = user.full_name || '';
                    document.getElementById('phone').value = user.phone || '';
                    document.getElementById('address').value = user.address || '';
                    
                    if (user.birth) {
                        document.getElementById('birth').value = user.birth.substring(0, 10);
                    } else {
                        document.getElementById('birth').value = '';
                    }
                    
                    if (user.avatar) {
                        document.getElementById('avatarPreview').src = '/storage/' + user.avatar;
                    }
                }
            } catch(err) { 
                console.error('Lỗi tải profile:', err); 
            }
        }

        // Preview ảnh trước khi upload
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                document.getElementById('avatarPreview').src = URL.createObjectURL(this.files[0]);
            }
        });

        // Cập nhật hồ sơ (kèm avatar)
        document.getElementById('profileForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append('full_name', document.getElementById('full_name').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('birth', document.getElementById('birth').value);
            
            const avatarFile = document.getElementById('avatarInput').files[0];
            if (avatarFile) formData.append('avatar', avatarFile);

            try {
                const res = await fetch('/api/profile/update', {
                    method: 'POST', 
                    headers: { 
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const result = await res.json();
                alert(result.message || 'Cập nhật thành công');
                // Tải lại profile để cập nhật avatar (nếu có)
                await loadProfile();
                // Cập nhật lại header (nếu cần) – header tự động gọi updateCartCount nhưng không cập nhật tên; 
                // có thể reload trang để đồng bộ, hoặc gọi window.location.reload()
                // Đơn giản: reload lại trang để header hiển thị tên mới và avatar mới
                window.location.reload();
            } catch (error) {
                alert('Có lỗi xảy ra khi cập nhật hồ sơ');
            }
        });

        // Đổi mật khẩu
        document.getElementById('passwordForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const res = await fetch('/api/profile/change-password', {
                    method: 'POST',
                    headers: { 
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: document.getElementById('current_password').value,
                        new_password: document.getElementById('new_password').value,
                        new_password_confirmation: document.getElementById('new_password_confirmation').value
                    })
                });
                const result = await res.json();
                if (result.status === 'success') {
                    alert('Đổi mật khẩu thành công!');
                    document.getElementById('passwordForm').reset();
                } else {
                    alert(result.message || 'Đổi mật khẩu thất bại');
                }
            } catch (error) {
                alert('Có lỗi xảy ra khi đổi mật khẩu');
            }
        });

        loadProfile();
    </script>
</body>
</html>
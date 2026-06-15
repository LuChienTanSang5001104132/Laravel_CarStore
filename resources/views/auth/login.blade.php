<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 80px; }
        #togglePassword { cursor: pointer; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white text-center py-3">
            <h4 class="mb-0">ĐĂNG NHẬP</h4>
        </div>
        <div class="card-body p-4">
            
            <div id="errorAlert" class="alert alert-danger py-2 d-none">
                <ul class="mb-0 ps-3" id="errorList"></ul>
            </div>

            <form id="loginForm">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" required placeholder="nhập email của bạn...">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <div class="input-group">
                        <input type="password" id="password" class="form-control" required placeholder="••••••••">
                        <span class="input-group-text bg-white" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('password.forgot') }}" class="text-decoration-none small">Quên mật khẩu?</a>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary w-100 py-2">Đăng nhập</button>
            </form>

            <div class="mt-4 text-center border-top pt-3">
                <p class="mb-0 text-muted small">Chưa có tài khoản? 
                    <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Xử lý nút ẩn/hiện mật khẩu
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        
        if (isPassword) {
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });

    // 2. Xử lý gửi dữ liệu Đăng nhập qua API
    document.getElementById('loginForm').addEventListener('submit', async (e) => {
        e.preventDefault(); // Ngăn chặn tuyệt đối hành vi submit mặc định của trình duyệt
        
        const submitBtn = document.getElementById('submitBtn');
        const errorAlert = document.getElementById('errorAlert');
        const errorList = document.getElementById('errorList');
        
        // Reset trạng thái hiển thị lỗi cũ
        errorAlert.classList.add('d-none');
        errorList.innerHTML = '';
        
        // Khóa nút bấm để tránh người dùng nhấn liên tục
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang đăng nhập...';

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            // Thực hiện gọi request đến API Login
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            const result = await res.json();

            if (res.status === 200 && result.status === 'success') {
                // Lưu token bảo mật và quyền hạn vào bộ nhớ trình duyệt
                localStorage.setItem('token', result.access_token);
                localStorage.setItem('user_role', result.user.role);

                // Chuyển hướng theo vai trò (Role) tương ứng
                if (result.user.role === 'admin' || result.user.role === 1) {
                    window.location.href = '/admin/dashboard';
                } else {
                    window.location.href = '/'; 
                }
            } else {
                // Xuất thông báo lỗi từ API ra giao diện
                errorAlert.classList.remove('d-none');
                const li = document.createElement('li');
                li.textContent = result.message || 'Email hoặc mật khẩu không chính xác!';
                errorList.appendChild(li);
            }
        } catch (error) {
            console.error("Lỗi:", error);
            errorAlert.classList.remove('d-none');
            const li = document.createElement('li');
            li.textContent = 'Không thể kết nối đến hệ thống máy chủ, vui lòng thử lại sau!';
            errorList.appendChild(li);
        } finally {
            // Mở khóa lại nút bấm sau khi xử lý xong
            submitBtn.disabled = false;
            submitBtn.textContent = 'Đăng nhập';
        }
    });
</script>

</body>
</html>
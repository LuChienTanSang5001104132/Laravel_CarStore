<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - CarStore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .forgot-container { max-width: 400px; margin-top: 80px; }
    </style>
</head>
<body>

<div class="container forgot-container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white text-center py-3">
            <h4 class="mb-0">QUÊN MẬT KHẨU</h4>
        </div>
        <div class="card-body p-4">
            
            <div id="step1">
                <p class="text-muted small mb-4 text-center">Nhập email của bạn và chúng tôi sẽ gửi mã khôi phục mật khẩu.</p>
                
                <form id="forgotForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email đăng ký</label>
                        <input type="email" id="email" class="form-control" required placeholder="nhập email của bạn...">
                    </div>
                    <button type="submit" id="submitBtn" class="btn btn-warning w-100 py-2 text-white fw-bold">Gửi mã xác nhận</button>
                </form>
            </div>

            <div id="step2" class="d-none">
                <div class="alert alert-success py-2 text-sm text-center">
                    Mã xác nhận đã được gửi đến email của bạn!
                </div>
                
                <form id="resetForm">
                    <div class="mb-3">
                        <label for="token" class="form-label">Mã xác nhận (Token)</label>
                        <input type="text" id="token" class="form-control" required placeholder="Nhập mã gửi trong email...">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" id="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" id="password_confirmation" class="form-control" required placeholder="••••••••">
                    </div>
                    <button type="submit" id="resetBtn" class="btn btn-success w-100 py-2 text-white fw-bold">Đặt lại mật khẩu</button>
                </form>
            </div>

            <div class="mt-4 text-center border-top pt-3">
                <a href="{{ route('login') }}" class="text-secondary text-decoration-none small">Quay lại đăng nhập</a>
            </div>
        </div>
    </div>
</div>

<script>
    let userEmail = ''; // Lưu tạm email để dùng cho bước 2

    // XỬ LÝ BƯỚC 1: GỬI EMAIL YÊU CẦU MÃ
    document.getElementById('forgotForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Đang gửi mã...';

        userEmail = document.getElementById('email').value;

        try {
            const res = await fetch('/api/forgot-password', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: userEmail })
            });

            const result = await res.json();

            if (res.ok && result.status !== 'error') {
                // Thành công -> Ẩn form 1, Hiện form 2
                document.getElementById('step1').classList.add('d-none');
                document.getElementById('step2').classList.remove('d-none');
            } else {
                alert(result.message || 'Email không tồn tại trong hệ thống.');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Gửi mã xác nhận';
            }
        } catch (err) {
            alert('Lỗi kết nối tới máy chủ.');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Gửi mã xác nhận';
        }
    });

    // XỬ LÝ BƯỚC 2: GỬI MÃ TOKEN + MẬT KHẨU MỚI ĐỂ RESET
    document.getElementById('resetForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const resetBtn = document.getElementById('resetBtn');
        resetBtn.disabled = true;
        resetBtn.textContent = 'Đang xử lý...';

        const token = document.getElementById('token').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        try {
            const res = await fetch('/api/reset-password', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    email: userEmail, 
                    code: token, 
                    password: password, 
                    password_confirmation: password_confirmation 
                })
            });

            const result = await res.json();

            if (res.ok && result.status !== 'error') {
                alert('Khôi phục mật khẩu thành công! Vui lòng đăng nhập lại.');
                window.location.href = "{{ route('login') }}"; // Đá về trang đăng nhập
            } else {
                // Nếu báo lỗi validation từ Laravel (ví dụ: mã sai, pass không khớp)
                let errorMsg = result.message || 'Có lỗi xảy ra.';
                if(result.errors) {
                    errorMsg = Object.values(result.errors).flat().join('\n');
                }
                alert(errorMsg);
                resetBtn.disabled = false;
                resetBtn.textContent = 'Đặt lại mật khẩu';
            }
        } catch (err) {
            alert('Lỗi kết nối tới máy chủ.');
            resetBtn.disabled = false;
            resetBtn.textContent = 'Đặt lại mật khẩu';
        }
    });
</script>

</body>
</html>
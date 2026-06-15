<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .register-container { max-width: 450px; margin-top: 50px; }
    </style>
</head>
<body>

<div class="container register-container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white text-center py-3">
            <h4 class="mb-0">ĐĂNG KÝ TÀI KHOẢN</h4>
        </div>
        <div class="card-body p-4">
            
            {{-- Hiển thị lỗi validation --}}
            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Nhập họ tên của bạn...">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="Nhập email...">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 mt-2">Đăng ký ngay</button>
            </form>

            <div class="mt-4 text-center border-top pt-3">
                <p class="mb-0 text-muted small">Đã có tài khoản? 
                    <a href="{{ route('login') }}" class="text-success text-decoration-none fw-bold">Đăng nhập</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', async (e) => {
        e.preventDefault(); // Ngăn form load lại trang
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        const res = await fetch('/api/register', { // Đảm bảo route api.php đã trỏ vào method này
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (result.status === 'success') {
            alert(result.message);
            window.location.href = "{{ route('login') }}"; // Chuyển sang trang login
        } else {
            // Hiển thị lỗi từ server
            alert(result.message + "\n" + JSON.stringify(result.errors));
        }
    });
</script>
</body>
</html>
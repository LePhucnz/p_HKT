<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký — HKT Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f3f4f6; font-family:'Segoe UI',sans-serif; }
        .card { border-radius:16px; border:none; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .form-control { border-radius:8px; }
        .form-control:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.12); }
        .btn-register { background:#1a56db; border:none; border-radius:8px; padding:11px; font-weight:600; width:100%; }
        .btn-register:hover { background:#1447b2; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh">
<div style="width:100%;max-width:420px;padding:16px">
    <div class="card p-4">
        <div class="text-center mb-4">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white mb-2"
                 style="width:56px;height:56px;font-size:1.5rem">
                <i class="bi bi-shop"></i>
            </div>
            <h5 class="fw-bold mb-0">HKT Shop</h5>
            <small class="text-muted">Tạo tài khoản mới</small>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2" style="font-size:.85rem">
                <i class="bi bi-exclamation-triangle me-1"></i>
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= BASE_URL ?>auth/doRegister">
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.85rem">Họ tên</label>
                <input type="text" name="ho_ten" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.85rem">Email</label>
                <input type="email" name="email" class="form-control" placeholder="email@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:.85rem">Mật khẩu</label>
                <input type="password" name="mat_khau" class="form-control" placeholder="Ít nhất 6 ký tự" required minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:.85rem">Xác nhận mật khẩu</label>
                <input type="password" name="mat_khau2" class="form-control" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-primary btn-register text-white">
                <i class="bi bi-person-plus me-2"></i>Đăng ký
            </button>
        </form>

        <p class="text-center mt-3 mb-0" style="font-size:.85rem">
            Đã có tài khoản?
            <a href="<?= BASE_URL ?>auth/login" class="text-primary fw-semibold">Đăng nhập</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

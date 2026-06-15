<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập — HKT Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f3f4f6; font-family:'Segoe UI',sans-serif; }
        .card { width:100%;max-width:420px;border-radius:16px;border:none;box-shadow:0 4px 24px rgba(0,0,0,.08);padding:36px; }
        .logo { width:56px;height:56px;background:#1a56db;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:#fff;margin:0 auto 16px; }
        .form-control { border-radius:8px;border-color:#d1d5db;padding:10px 14px; }
        .form-control:focus { border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.12); }
        .input-group-text { border-color:#d1d5db; }
        .btn-main { background:#1a56db;color:#fff;border:none;border-radius:8px;padding:11px;font-weight:600;width:100%;font-size:.95rem; }
        .btn-main:hover { background:#1447b2; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh">
<div class="card">
    <div class="logo"><i class="bi bi-shop"></i></div>
    <h5 class="text-center fw-bold mb-1">HKT Shop</h5>
    <p class="text-center text-muted mb-4" style="font-size:.85rem">Hệ thống quản lý bán hàng & thanh toán</p>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger py-2" style="font-size:.85rem">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success py-2" style="font-size:.85rem">
            <i class="bi bi-check-circle-fill me-1"></i>
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>auth/doLogin">
        <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.85rem">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border-radius:8px 0 0 8px">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input type="email" name="email" class="form-control border-start-0"
                       placeholder="email@example.com" required
                       style="border-radius:0 8px 8px 0">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold" style="font-size:.85rem">Mật khẩu</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border-radius:8px 0 0 8px">
                    <i class="bi bi-lock text-muted"></i>
                </span>
                <input type="password" name="mat_khau" id="pwdInput" class="form-control border-start-0"
                       placeholder="••••••••" required style="border-radius:0 8px 8px 0">
                <button type="button" class="input-group-text bg-white border-start-0"
                        style="border-radius:0 8px 8px 0;cursor:pointer" onclick="togglePwd()">
                    <i class="bi bi-eye" id="pwdIcon"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn-main mb-3">
            <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập
        </button>
    </form>

    <p class="text-center mb-3" style="font-size:.85rem">
        Chưa có tài khoản?
        <a href="<?= BASE_URL ?>auth/register" class="text-primary fw-semibold">Đăng ký ngay</a>
    </p>

    <div class="p-3 rounded" style="background:#f9fafb;font-size:.78rem;color:#6b7280">
        <div class="fw-semibold mb-1">Tài khoản mẫu:</div>
        <div>👑 Admin: <strong>admin@hkt.com</strong> / <strong>123456</strong></div>
        <div>💼 Manager: <strong>manager@hkt.com</strong> / <strong>123456</strong></div>
        <div>🧾 Thu ngân: <strong>thu_ngan@hkt.com</strong> / <strong>123456</strong></div>
        <div>📦 Thủ kho: <strong>kho@hkt.com</strong> / <strong>123456</strong></div>
    </div>
</div>

<script>
function togglePwd() {
    const i = document.getElementById('pwdInput');
    const ic = document.getElementById('pwdIcon');
    i.type = i.type==='password' ? 'text' : 'password';
    ic.className = i.type==='password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

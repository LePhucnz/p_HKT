<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h4><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</h4>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="Nhập email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="mat_khau" class="form-control" 
                               placeholder="Nhập mật khẩu" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                    </button>
                </form>
                <p class="text-center mt-3">
                    Chưa có tài khoản? 
                    <a href="?page=auth&action=register">Đăng ký ngay</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
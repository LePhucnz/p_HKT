<?php $title = 'Thêm người dùng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center"><div class="col-md-6">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-primary"></i>Thêm người dùng</h5>

    <form method="POST" action="<?= BASE_URL ?>user/store">
        <div class="mb-3">
            <label class="form-label fw-semibold">Họ tên *</label>
            <input type="text" name="ho_ten" class="form-control" placeholder="Nguyễn Văn A" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email *</label>
            <input type="email" name="email" class="form-control" placeholder="email@hkt.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Mật khẩu *</label>
            <input type="password" name="mat_khau" class="form-control" placeholder="Ít nhất 6 ký tự" required minlength="6">
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Vai trò</label>
            <select name="vai_tro" class="form-select">
                <option value="cashier">Thu ngân — Tạo hóa đơn, xem sản phẩm</option>
                <option value="stock_keeper">Thủ kho — Nhập kho, xem sản phẩm</option>
                <option value="manager">Quản lý — Xem báo cáo, quản lý SP, KH, KM</option>
                <option value="admin">Admin — Toàn quyền hệ thống</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Lưu</button>
            <a href="<?= BASE_URL ?>user" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>

<?php require_once 'app/views/layouts/footer.php'; ?>

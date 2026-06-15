<?php $title = 'Sửa người dùng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center"><div class="col-md-6">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Sửa người dùng</h5>

    <form method="POST" action="<?= BASE_URL ?>user/update/<?= $user['id'] ?>">
        <div class="mb-3">
            <label class="form-label fw-semibold">Họ tên *</label>
            <input type="text" name="ho_ten" class="form-control"
                   value="<?= htmlspecialchars($user['ho_ten']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email *</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Mật khẩu mới</label>
            <input type="password" name="mat_khau" class="form-control"
                   placeholder="Để trống nếu không đổi">
            <div class="text-muted mt-1" style="font-size:.78rem">Để trống = giữ nguyên mật khẩu cũ</div>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Vai trò</label>
            <select name="vai_tro" class="form-select">
                <?php
                $roles = [
                    'cashier'      => 'Thu ngân — Tạo hóa đơn, xem sản phẩm',
                    'stock_keeper' => 'Thủ kho — Nhập kho, xem sản phẩm',
                    'manager'      => 'Quản lý — Xem báo cáo, quản lý SP, KH, KM',
                    'admin'        => 'Admin — Toàn quyền hệ thống',
                ];
                foreach($roles as $val => $label):
                ?>
                <option value="<?= $val ?>" <?= $user['vai_tro']===$val?'selected':'' ?>>
                    <?= $label ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning px-4"><i class="bi bi-check-lg me-1"></i>Lưu thay đổi</button>
            <a href="<?= BASE_URL ?>user" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>

<?php require_once 'app/views/layouts/footer.php'; ?>

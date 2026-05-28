<?php require_once 'app/views/layouts/header.php'; ?>
<div class="row justify-content-center"><div class="col-lg-6">
<div class="form-card">
    <h5 class="fw-bold mb-4"><?=$title?></h5>
    <?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
    <form method="POST">
        <div class="mb-3"><label class="form-label">Họ tên *</label><input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($khach_hang['ho_ten']??'') ?>" required></div>
        <div class="row g-3 mb-3">
            <div class="col-6"><label class="form-label">Số điện thoại</label><input type="text" name="so_dien_thoai" class="form-control" value="<?= htmlspecialchars($khach_hang['so_dien_thoai']??'') ?>"></div>
            <div class="col-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($khach_hang['email']??'') ?>"></div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-6"><label class="form-label">Ngày sinh</label><input type="date" name="ngay_sinh" class="form-control" value="<?= $khach_hang['ngay_sinh']??'' ?>"></div>
            <div class="col-6"><label class="form-label">Giới tính</label>
                <select name="gioi_tinh" class="form-select">
                    <?php foreach(['Nam','Nữ','Khác'] as $gt): ?>
                    <option <?= ($khach_hang['gioi_tinh']??'')===$gt?'selected':'' ?>><?=$gt?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="mb-3"><label class="form-label">Địa chỉ</label><input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($khach_hang['dia_chi']??'') ?>"></div>
        <div class="mb-4"><label class="form-label">Ghi chú</label><textarea name="ghi_chu" class="form-control" rows="2"><?= htmlspecialchars($khach_hang['ghi_chu']??'') ?></textarea></div>
        <div class="d-flex gap-2"><button class="btn btn-primary px-4">Lưu</button><a href="?page=khach_hang" class="btn btn-outline-secondary">Hủy</a></div>
    </form>
</div>
</div></div>
<?php require_once 'app/views/layouts/footer.php'; ?>

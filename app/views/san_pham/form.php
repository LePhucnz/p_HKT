<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center">
<div class="col-lg-7">
    <div class="form-card">
        <h5 class="fw-bold mb-4"><i class="bi bi-<?= $san_pham ? 'pencil' : 'plus-circle' ?> me-2 text-primary"></i><?= $title ?></h5>

        <?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>

        <form method="POST">
            <?php if(!$san_pham): ?>
            <div class="mb-3">
                <label class="form-label">Mã sản phẩm <span class="text-danger">*</span></label>
                <input type="text" name="ma_sp" class="form-control" placeholder="VD: SP001" value="<?= htmlspecialchars($_POST['ma_sp'] ?? '') ?>" required>
            </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" name="ten_sp" class="form-control" placeholder="Nhập tên sản phẩm" value="<?= htmlspecialchars($san_pham['ten_sp'] ?? $_POST['ten_sp'] ?? '') ?>" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Danh mục</label>
                    <select name="danh_muc_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach($danh_mucs as $dm): ?>
                        <option value="<?=$dm['id']?>" <?= ($san_pham['danh_muc_id']??'')==$dm['id']?'selected':'' ?>><?= htmlspecialchars($dm['ten_danh_muc']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Đơn vị tính</label>
                    <input type="text" name="don_vi_tinh" class="form-control" placeholder="Cái, Hộp, Kg..." value="<?= htmlspecialchars($san_pham['don_vi_tinh'] ?? '') ?>">
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Giá bán (VNĐ)</label>
                    <input type="number" name="gia_ban" class="form-control" min="0" placeholder="0" value="<?= $san_pham['gia_ban'] ?? 0 ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số lượng tồn</label>
                    <input type="number" name="so_luong_ton" class="form-control" min="0" value="<?= $san_pham['so_luong_ton'] ?? 0 ?>">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả sản phẩm..."><?= htmlspecialchars($san_pham['mo_ta'] ?? '') ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Lưu</button>
                <a href="?page=san_pham" class="btn btn-outline-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

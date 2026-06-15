<?php $title = 'Sửa sản phẩm'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center"><div class="col-lg-7">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-pencil me-2 text-warning"></i>Sửa sản phẩm</h5>

    <form method="POST" action="<?= BASE_URL ?>product/update/<?= $product['id'] ?>" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Tên sản phẩm *</label>
                <input type="text" name="ten_sp" class="form-control"
                       value="<?= htmlspecialchars($product['ten_sp']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Danh mục</label>
                <select name="danh_muc_id" class="form-select">
                    <option value="">-- Không có --</option>
                    <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= $product['danh_muc_id']==$c['id']?'selected':'' ?>>
                        <?= htmlspecialchars($c['ten_danh_muc']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Đơn vị tính</label>
                <input type="text" name="don_vi_tinh" class="form-control"
                       value="<?= htmlspecialchars($product['don_vi_tinh'] ?? 'cái') ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Giá bán (đ) *</label>
                <input type="number" name="gia_ban" class="form-control"
                       value="<?= $product['gia_ban'] ?>" min="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold text-muted">Tồn kho</label>
                <input type="text" class="form-control bg-light"
                       value="<?= $product['so_luong_ton'] ?>" readonly>
                <small class="text-muted">Tồn kho chỉ thay đổi qua nhập/bán hàng</small>
            </div>

            <!-- UPLOAD ANH -->
            <div class="col-12">
                <label class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                <?php if(!empty($product['hinh_anh']) && file_exists($product['hinh_anh'])): ?>
                <div class="mb-2">
                    <img src="<?= BASE_URL ?><?= htmlspecialchars($product['hinh_anh']) ?>"
                         alt="Ảnh hiện tại" id="imgPreview"
                         style="max-height:140px;border-radius:8px;border:1px solid #e5e7eb">
                    <div class="text-muted mt-1" style="font-size:.78rem">Ảnh hiện tại — tải ảnh mới để thay thế</div>
                </div>
                <?php else: ?>
                <div class="mb-2">
                    <div class="d-flex align-items-center justify-content-center bg-light rounded"
                         style="height:100px;border:1px dashed #d1d5db">
                        <img id="imgPreview" src="" alt="" style="max-height:90px;display:none">
                        <span class="text-muted" id="noImg"><i class="bi bi-image me-1"></i>Chưa có ảnh</span>
                    </div>
                </div>
                <?php endif; ?>
                <input type="file" name="hinh_anh" class="form-control"
                       accept="image/jpeg,image/png,image/gif,image/webp"
                       onchange="previewImg(this)">
                <div class="text-muted mt-1" style="font-size:.78rem">JPG, PNG, WEBP — Tối đa 2MB — Để trống nếu không đổi ảnh</div>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($product['mo_ta'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-warning px-4"><i class="bi bi-check-lg me-1"></i>Lưu thay đổi</button>
            <a href="<?= BASE_URL ?>product" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>

<script>
function previewImg(input) {
    const img   = document.getElementById('imgPreview');
    const noImg = document.getElementById('noImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            img.style.display = 'block';
            if (noImg) noImg.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>

<?php $title = 'Thêm sản phẩm'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row justify-content-center"><div class="col-lg-7">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2 text-primary"></i>Thêm sản phẩm</h5>

    <form method="POST" action="<?= BASE_URL ?>product/store" enctype="multipart/form-data">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Tên sản phẩm *</label>
                <input type="text" name="ten_sp" class="form-control" placeholder="Nhập tên sản phẩm" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Danh mục</label>
                <select name="danh_muc_id" class="form-select">
                    <option value="">-- Không có --</option>
                    <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['ten_danh_muc']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Đơn vị tính</label>
                <input type="text" name="don_vi_tinh" class="form-control" value="cái">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Giá bán (đ) *</label>
                <input type="number" name="gia_ban" class="form-control" min="0" placeholder="0" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Số lượng tồn</label>
                <input type="number" name="so_luong_ton" class="form-control" min="0" value="0">
            </div>

            <!-- UPLOAD ANH -->
            <div class="col-12">
                <label class="form-label fw-semibold">Hình ảnh sản phẩm</label>
                <input type="file" name="hinh_anh" id="imgInput" class="form-control"
                       accept="image/jpeg,image/png,image/gif,image/webp"
                       onchange="previewImg(this)">
                <div class="text-muted mt-1" style="font-size:.78rem">JPG, PNG, WEBP — Tối đa 2MB</div>
                <div id="imgPreviewWrap" class="mt-2 d-none">
                    <img id="imgPreview" src="" alt="Preview"
                         style="max-height:160px;border-radius:8px;border:1px solid #e5e7eb">
                </div>
            </div>

            <div class="col-12">
                <label class="form-label fw-semibold">Mô tả</label>
                <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả sản phẩm..."></textarea>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Lưu</button>
            <a href="<?= BASE_URL ?>product" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>

<script>
function previewImg(input) {
    const wrap = document.getElementById('imgPreviewWrap');
    const img  = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; wrap.classList.remove('d-none'); };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>

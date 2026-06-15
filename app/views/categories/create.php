<?php $title = 'Thêm danh mục'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>
<div class="row justify-content-center"><div class="col-md-5">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle me-2 text-primary"></i>Thêm danh mục</h5>
    <form method="POST" action="<?= BASE_URL ?>category/store">
        <div class="mb-3">
            <label class="form-label fw-semibold">Tên danh mục *</label>
            <input type="text" name="ten_danh_muc" class="form-control" placeholder="VD: Điện tử" required>
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="3" placeholder="Mô tả danh mục..."></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Lưu</button>
            <a href="<?= BASE_URL ?>categories" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>
<?php require_once 'app/views/layouts/footer.php'; ?>

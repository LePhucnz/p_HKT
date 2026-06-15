<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
<div class="row justify-content-center"><div class="col-md-6">
  <div class="card shadow-sm">
    <div class="card-header bg-warning"><h5 class="mb-0">✏️ Sửa danh mục</h5></div>
    <div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>category/update/<?= $category['id'] ?>">
        <div class="mb-3">
          <label class="form-label fw-semibold">Tên danh mục *</label>
          <input type="text" name="ten_danh_muc" class="form-control" value="<?= htmlspecialchars($category['ten_danh_muc']) ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Mô tả</label>
          <textarea name="mo_ta" class="form-control" rows="3"><?= htmlspecialchars($category['mo_ta'] ?? '') ?></textarea>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-warning">💾 Lưu</button>
          <a href="<?= BASE_URL ?>categories" class="btn btn-outline-secondary">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div></div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

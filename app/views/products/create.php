<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
<div class="row justify-content-center"><div class="col-md-7">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white"><h5 class="mb-0">➕ Thêm sản phẩm</h5></div>
    <div class="card-body">
      <?php if(isset($_SESSION['error'])): ?><div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div><?php endif; ?>
      <form method="POST" action="<?= BASE_URL ?>product/store">
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label fw-semibold">Tên sản phẩm *</label>
            <input type="text" name="ten_sp" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label fw-semibold">Đơn vị tính</label>
            <input type="text" name="don_vi_tinh" class="form-control" value="cái">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Danh mục</label>
            <select name="danh_muc_id" class="form-select">
              <option value="">-- Không có --</option>
              <?php foreach($categories as $c): ?>
              <option value="<?=$c['id']?>"><?= htmlspecialchars($c['ten_danh_muc']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Giá bán (đ) *</label>
            <input type="number" name="gia_ban" class="form-control" min="0" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Số lượng tồn</label>
            <input type="number" name="so_luong_ton" class="form-control" min="0" value="0">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-primary">💾 Lưu</button>
          <a href="<?= BASE_URL ?>product" class="btn btn-outline-secondary">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div></div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

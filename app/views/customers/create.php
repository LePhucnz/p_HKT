<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
<div class="row justify-content-center"><div class="col-md-7">
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white"><h5 class="mb-0">➕ Thêm khách hàng</h5></div>
    <div class="card-body">
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>
      <form method="POST" action="<?= BASE_URL ?>customer/store">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Họ tên *</label>
            <input type="text" name="ho_ten" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Số điện thoại *</label>
            <input type="text" name="so_dien_thoai" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Ngày sinh</label>
            <input type="date" name="ngay_sinh" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Giới tính</label>
            <select name="gioi_tinh" class="form-select">
              <option value="">-- Chọn --</option>
              <option value="Nam">Nam</option>
              <option value="Nữ">Nữ</option>
              <option value="Khác">Khác</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Địa chỉ</label>
            <input type="text" name="dia_chi" class="form-control">
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-success">💾 Lưu</button>
          <a href="<?= BASE_URL ?>customer" class="btn btn-outline-secondary">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div></div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

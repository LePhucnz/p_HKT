<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
<div class="row justify-content-center"><div class="col-md-7">
  <div class="card shadow-sm">
    <div class="card-header bg-warning"><h5 class="mb-0">✏️ Sửa khách hàng</h5></div>
    <div class="card-body">
      <form method="POST" action="<?= BASE_URL ?>customer/update/<?= $customer['id'] ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Họ tên *</label>
            <input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($customer['ho_ten']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Số điện thoại *</label>
            <input type="text" name="so_dien_thoai" class="form-control" value="<?= htmlspecialchars($customer['so_dien_thoai']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($customer['email'] ?? '') ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Ngày sinh</label>
            <input type="date" name="ngay_sinh" class="form-control" value="<?= $customer['ngay_sinh'] ?? '' ?>">
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Giới tính</label>
            <select name="gioi_tinh" class="form-select">
              <option value="">-- Chọn --</option>
              <?php foreach(['Nam','Nữ','Khác'] as $gt): ?>
              <option value="<?=$gt?>" <?= ($customer['gioi_tinh']??'')===$gt?'selected':'' ?>><?=$gt?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Địa chỉ</label>
            <input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($customer['dia_chi'] ?? '') ?>">
          </div>
        </div>
        <div class="d-flex gap-2 mt-4">
          <button type="submit" class="btn btn-warning">💾 Lưu</button>
          <a href="<?= BASE_URL ?>customers" class="btn btn-outline-secondary">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div></div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

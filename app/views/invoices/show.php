<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container py-4">
  <?php if(isset($_SESSION['success'])): ?><div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div><?php endif; ?>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>🧾 Hóa đơn #<?= htmlspecialchars($invoice['so_hd']) ?></h4>
    <div>
      <button onclick="window.print()" class="btn btn-outline-secondary">🖨️ In</button>
      <a href="<?= BASE_URL ?>invoice/create" class="btn btn-primary">➕ Hóa đơn mới</a>
    </div>
  </div>

  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <p><strong>Khách hàng:</strong> <?= htmlspecialchars($invoice['khach_ten'] ?? 'Khách lẻ') ?></p>
          <p><strong>SĐT:</strong> <?= htmlspecialchars($invoice['so_dien_thoai'] ?? '—') ?></p>
        </div>
        <div class="col-md-6">
          <p><strong>Nhân viên:</strong> <?= htmlspecialchars($invoice['nhan_vien_ten'] ?? '') ?></p>
          <p><strong>Ngày lập:</strong> <?= $invoice['ngay_lap'] ?></p>
          <p><strong>Thanh toán:</strong> <span class="badge bg-info"><?= htmlspecialchars($invoice['phuong_thuc_tt']) ?></span></p>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mb-3">
    <table class="table mb-0">
      <thead class="table-dark"><tr><th>#</th><th>Mã SP</th><th>Tên sản phẩm</th><th>SL</th><th>Đơn giá</th><th>Thành tiền</th></tr></thead>
      <tbody>
      <?php foreach($invoice['details'] as $i => $d): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= htmlspecialchars($d['ma_sp']) ?></td>
        <td><?= htmlspecialchars($d['ten_sp']) ?></td>
        <td><?= $d['so_luong'] ?></td>
        <td><?= number_format($d['don_gia']) ?> đ</td>
        <td class="fw-semibold"><?= number_format($d['thanh_tien']) ?> đ</td>
      </tr>
      <?php endforeach; ?>
      </tbody>
      <tfoot class="table-light">
        <tr><td colspan="5" class="text-end">Tổng tiền hàng:</td><td class="fw-semibold"><?= number_format($invoice['tong_tien']) ?> đ</td></tr>
        <tr><td colspan="5" class="text-end text-danger">Giảm giá:</td><td class="text-danger">-<?= number_format($invoice['giam_gia']) ?> đ</td></tr>
        <tr class="table-success"><td colspan="5" class="text-end fw-bold fs-5">Thành tiền:</td><td class="fw-bold fs-5 text-success"><?= number_format($invoice['thanh_tien']) ?> đ</td></tr>
      </tfoot>
    </table>
  </div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

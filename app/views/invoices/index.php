<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📋 Danh sách hóa đơn</h4>
    <a href="<?= BASE_URL ?>invoice/create" class="btn btn-primary">➕ Tạo hóa đơn</a>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-dark"><tr><th>Số HĐ</th><th>Khách hàng</th><th>Thanh toán</th><th>Tổng tiền</th><th>Ngày lập</th><th></th></tr></thead>
        <tbody>
        <?php if($invoices): foreach($invoices as $hd): ?>
        <tr>
          <td class="fw-semibold"><?= htmlspecialchars($hd['so_hd']) ?></td>
          <td><?= htmlspecialchars($hd['khach_ten'] ?? 'Khách lẻ') ?></td>
          <td><span class="badge bg-info"><?= htmlspecialchars($hd['phuong_thuc_tt']) ?></span></td>
          <td class="fw-semibold text-success"><?= number_format($hd['thanh_tien']) ?> đ</td>
          <td><?= $hd['ngay_lap'] ?></td>
          <td><a href="<?= BASE_URL ?>invoice/show/<?= $hd['id'] ?>" class="btn btn-sm btn-outline-primary">👁️ Xem</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" class="text-center text-muted py-3">Chưa có hóa đơn nào</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

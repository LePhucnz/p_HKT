<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📦 Lịch sử nhập kho</h4>
    <a href="<?= BASE_URL ?>purchaseOrder/create" class="btn btn-primary">➕ Tạo phiếu nhập</a>
  </div>
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-dark"><tr>
          <th>Số phiếu</th><th>Nhà cung cấp</th><th>Nhân viên</th><th>Ngày nhập</th>
        </tr></thead>
        <tbody>
        <?php if($orders): foreach($orders as $o): ?>
        <tr>
          <td class="fw-semibold"><?= htmlspecialchars($o['so_pn']) ?></td>
          <td><?= htmlspecialchars($o['nha_cung_cap'] ?? '—') ?></td>
          <td><?= htmlspecialchars($o['ten_nv'] ?? '—') ?></td>
          <td><?= $o['ngay_nhap'] ?? '' ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="4" class="text-center text-muted py-3">Chưa có phiếu nhập nào</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

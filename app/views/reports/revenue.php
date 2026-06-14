<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
  <h4 class="mb-3">📊 Báo cáo doanh thu</h4>
  <div class="card shadow-sm mb-3">
    <div class="card-body">
      <form method="GET" class="row g-2 align-items-end">
        <input type="hidden" name="url" value="reports/revenue">
        <div class="col-md-3">
          <label class="form-label fw-semibold">Từ ngày</label>
          <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Đến ngày</label>
          <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
        </div>
        <div class="col-md-2">
          <button class="btn btn-primary w-100">🔍 Xem</button>
        </div>
      </form>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-white bg-success shadow-sm">
        <div class="card-body">
          <h6>Tổng doanh thu</h6>
          <h3><?= number_format($summary['total'] ?? 0) ?> đ</h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-primary shadow-sm">
        <div class="card-body">
          <h6>Số hóa đơn</h6>
          <h3><?= $summary['count'] ?? 0 ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-info shadow-sm">
        <div class="card-body">
          <h6>Trung bình / hóa đơn</h6>
          <h3><?= ($summary['count'] ?? 0) > 0 ? number_format(($summary['total'] ?? 0) / $summary['count']) : 0 ?> đ</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-dark">
          <tr><th>Ngày</th><th>Số hóa đơn</th><th>Doanh thu</th></tr>
        </thead>
        <tbody>
        <?php if($dailyRevenue): foreach($dailyRevenue as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td><?= $row['total_invoices'] ?></td>
          <td class="fw-semibold text-success"><?= number_format($row['total_revenue']) ?> đ</td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="3" class="text-center text-muted py-3">Không có dữ liệu trong khoảng thời gian này</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

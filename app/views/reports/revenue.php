<?php $title = $title ?? 'Báo cáo doanh thu'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Báo cáo doanh thu</h5>
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-printer me-1"></i>In báo cáo
    </button>
</div>

<!-- Bo loc -->
<div class="table-card mb-3" style="padding:14px">
    <form method="GET" class="row g-2 align-items-end">
        <input type="hidden" name="url" value="report/revenue">
        <div class="col-md-3">
            <label class="form-label fw-semibold" style="font-size:.82rem">Từ ngày</label>
            <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold" style="font-size:.82rem">Đến ngày</label>
            <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Xem</button>
        </div>
    </form>
</div>

<!-- Tong ket -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7">
                <i class="bi bi-currency-dollar" style="color:#16a34a"></i>
            </div>
            <div>
                <div class="value" style="font-size:1.1rem"><?= number_format($summary['total'] ?? 0) ?>đ</div>
                <div class="label">Tổng doanh thu</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe">
                <i class="bi bi-receipt" style="color:#1d4ed8"></i>
            </div>
            <div>
                <div class="value"><?= $summary['count'] ?? 0 ?></div>
                <div class="label">Số hóa đơn</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3">
                <i class="bi bi-tag" style="color:#ca8a04"></i>
            </div>
            <div>
                <div class="value" style="font-size:1.1rem"><?= number_format($summary['tong_giam'] ?? 0) ?>đ</div>
                <div class="label">Tổng giảm giá</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8ff">
                <i class="bi bi-graph-up" style="color:#7c3aed"></i>
            </div>
            <div>
                <div class="value" style="font-size:1.1rem">
                    <?= ($summary['count'] ?? 0) > 0
                        ? number_format(($summary['total'] ?? 0) / $summary['count'])
                        : 0 ?>đ
                </div>
                <div class="label">Trung bình / HĐ</div>
            </div>
        </div>
    </div>
</div>

<!-- Bang chi tiet -->
<div class="table-card">
    <div class="card-header-custom">
        <span><i class="bi bi-table me-2"></i>Chi tiết theo ngày</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày</th>
                    <th>Số hóa đơn</th>
                    <th>Tổng tiền hàng</th>
                    <th>Giảm giá</th>
                    <th>Doanh thu thuần</th>
                </tr>
            </thead>
            <tbody>
            <?php if($dailyRevenue): foreach($dailyRevenue as $i => $row): ?>
            <tr>
                <td class="text-muted"><?= $i + 1 ?></td>
                <td class="fw-semibold"><?= date('d/m/Y', strtotime($row['date'])) ?></td>
                <td><?= $row['total_invoices'] ?></td>
                <td><?= number_format($row['tong_hang'] ?? 0) ?>đ</td>
                <td class="text-danger">-<?= number_format($row['tong_giam'] ?? 0) ?>đ</td>
                <td class="fw-semibold text-success"><?= number_format($row['total_revenue']) ?>đ</td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                    Không có dữ liệu trong khoảng thời gian này
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
            <?php if($dailyRevenue): ?>
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2">Tổng cộng</td>
                    <td><?= array_sum(array_column($dailyRevenue,'total_invoices')) ?></td>
                    <td><?= number_format(array_sum(array_column($dailyRevenue,'tong_hang'))) ?>đ</td>
                    <td class="text-danger">-<?= number_format(array_sum(array_column($dailyRevenue,'tong_giam'))) ?>đ</td>
                    <td class="text-success"><?= number_format(array_sum(array_column($dailyRevenue,'total_revenue'))) ?>đ</td>
                </tr>
            </tfoot>
            <?php endif; ?>
        </table>
    </div>
</div>

<style>@media print { .sidebar,.topbar,.table-card:first-of-type{display:none!important} .main{margin-left:0!important} }</style>

<?php require_once 'app/views/layouts/footer.php'; ?>

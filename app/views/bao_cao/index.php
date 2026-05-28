<?php require_once 'app/views/layouts/header.php'; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Báo cáo doanh thu</h5>
</div>
<div class="form-card mb-3 py-2">
    <form method="GET" class="row g-2 align-items-end">
        <input type="hidden" name="page" value="bao_cao">
        <div class="col-md-3"><label class="form-label small mb-1">Từ ngày</label><input type="date" name="tu_ngay" class="form-control" value="<?=$tu_ngay?>"></div>
        <div class="col-md-3"><label class="form-label small mb-1">Đến ngày</label><input type="date" name="den_ngay" class="form-control" value="<?=$den_ngay?>"></div>
        <div class="col-md-2"><button class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Xem</button></div>
        <div class="col-md-2"><button type="button" onclick="window.print()" class="btn btn-outline-secondary w-100"><i class="bi bi-printer me-1"></i>In</button></div>
        <?php if($bao_cao): ?>
        <div class="col-md-2">
            <div class="p-2 bg-success text-white rounded text-center">
                <div class="small">Tổng DT</div>
                <div class="fw-bold"><?= number_format(array_sum(array_column($bao_cao,'tong_cong'))) ?> đ</div>
            </div>
        </div>
        <?php endif; ?>
    </form>
</div>

<div class="table-card" id="print-area">
    <table class="table">
        <thead class="table-primary">
            <tr>
                <th>STT</th><th>Ngày</th><th>Số HĐ</th>
                <th colspan="4" class="text-center">Doanh thu (VNĐ)</th>
                <th>Giảm giá</th><th>DT thuần</th>
            </tr>
            <tr class="table-light small">
                <th colspan="3"></th>
                <th>Tiền mặt</th><th>Chuyển khoản</th><th>QR Code</th><th>Khác</th>
                <th></th><th></th>
            </tr>
        </thead>
        <tbody>
        <?php if($bao_cao): foreach($bao_cao as $i=>$row): ?>
        <tr>
            <td><?=$i+1?></td>
            <td class="fw-semibold"><?= date('d/m/Y',strtotime($row['ngay'])) ?></td>
            <td><?=$row['tong_hd']?></td>
            <td><?= $row['tien_mat']>0 ? number_format($row['tien_mat']) : '—' ?></td>
            <td><?= $row['chuyen_khoan']>0 ? number_format($row['chuyen_khoan']) : '—' ?></td>
            <td><?= $row['qr_code']>0 ? number_format($row['qr_code']) : '—' ?></td>
            <td><?= $row['khac']>0 ? number_format($row['khac']) : '—' ?></td>
            <td class="text-danger"><?= $row['tong_giam']>0 ? number_format($row['tong_giam']) : '—' ?></td>
            <td class="fw-bold text-success"><?= number_format($row['dt_thuan']) ?></td>
        </tr>
        <?php endforeach; else: ?><tr><td colspan="9" class="text-center text-muted py-4">Không có dữ liệu</td></tr><?php endif; ?>
        </tbody>
        <?php if($bao_cao): ?>
        <tfoot class="table-secondary fw-bold">
            <tr>
                <td colspan="2">Tổng cộng</td>
                <td><?= array_sum(array_column($bao_cao,'tong_hd')) ?></td>
                <td><?= number_format(array_sum(array_column($bao_cao,'tien_mat'))) ?></td>
                <td><?= number_format(array_sum(array_column($bao_cao,'chuyen_khoan'))) ?></td>
                <td><?= number_format(array_sum(array_column($bao_cao,'qr_code'))) ?></td>
                <td><?= number_format(array_sum(array_column($bao_cao,'khac'))) ?></td>
                <td class="text-danger"><?= number_format(array_sum(array_column($bao_cao,'tong_giam'))) ?></td>
                <td class="text-success fs-5"><?= number_format(array_sum(array_column($bao_cao,'dt_thuan'))) ?></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
</div>
<style>@media print { .sidebar,.topbar,.form-card:first-child{display:none!important} .main-content{margin-left:0!important} }</style>
<?php require_once 'app/views/layouts/footer.php'; ?>

<?php require_once 'app/views/layouts/header.php'; ?>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle me-2"></i>Tạo hóa đơn thành công!
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="d-flex gap-2 mb-3">
    <a href="?page=hoa_don" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Quay lại</a>
    <button onclick="window.print()" class="btn btn-outline-primary btn-sm"><i class="bi bi-printer me-1"></i>In</button>
    <a href="?page=hoa_don&action=tao_moi" class="btn btn-primary btn-sm"><i class="bi bi-plus me-1"></i>Hóa đơn mới</a>
</div>

<div class="form-card" id="print-area">
    <div class="text-center mb-4">
        <h4 class="fw-bold">🛒 HKT SHOP</h4>
        <h5 class="fw-bold text-primary">HÓA ĐƠN BÁN HÀNG</h5>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <table class="table table-sm table-borderless">
                <tr><td class="text-muted" width="140">Số HĐ:</td><td class="fw-bold"><?=$hoa_don['so_hd']?></td></tr>
                <tr><td class="text-muted">Khách hàng:</td><td><?= htmlspecialchars($hoa_don['ten_kh'] ?? 'Khách lẻ') ?></td></tr>
                <tr><td class="text-muted">SĐT:</td><td><?= htmlspecialchars($hoa_don['sdt_kh'] ?? '—') ?></td></tr>
                <tr><td class="text-muted">Địa chỉ:</td><td><?= htmlspecialchars($hoa_don['dia_chi'] ?? '—') ?></td></tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-sm table-borderless">
                <tr><td class="text-muted" width="140">Ngày lập:</td><td><?= date('d/m/Y H:i', strtotime($hoa_don['ngay_lap'])) ?></td></tr>
                <tr><td class="text-muted">Nhân viên:</td><td><?= htmlspecialchars($hoa_don['ten_nv'] ?? '') ?></td></tr>
                <tr><td class="text-muted">Thanh toán:</td><td><span class="badge bg-primary"><?=$hoa_don['phuong_thuc_tt']?></span></td></tr>
            </table>
        </div>
    </div>

    <table class="table table-bordered invoice-table">
        <thead class="table-primary">
            <tr class="text-center">
                <th width="5%">STT</th><th>Mã SP</th><th>Tên sản phẩm</th>
                <th>ĐVT</th><th>Số lượng</th><th>Đơn giá (VNĐ)</th><th>Thành tiền (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($chi_tiet as $i=>$ct): ?>
        <tr>
            <td class="text-center"><?=$i+1?></td>
            <td><span class="badge bg-light text-dark"><?= htmlspecialchars($ct['ma_sp']) ?></span></td>
            <td><?= htmlspecialchars($ct['ten_sp']) ?></td>
            <td class="text-center"><?= htmlspecialchars($ct['don_vi_tinh']) ?></td>
            <td class="text-center"><?= number_format($ct['so_luong']) ?></td>
            <td class="text-end"><?= number_format($ct['don_gia']) ?></td>
            <td class="text-end fw-semibold"><?= number_format($ct['thanh_tien']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr><td colspan="6" class="text-end">Tổng tiền hàng:</td><td class="text-end"><?= number_format($hoa_don['tong_tien']) ?> đ</td></tr>
            <tr><td colspan="6" class="text-end text-danger">Giảm giá:</td><td class="text-end text-danger">- <?= number_format($hoa_don['giam_gia']) ?> đ</td></tr>
            <tr class="table-success"><td colspan="6" class="text-end fw-bold fs-5">Thành tiền phải trả:</td><td class="text-end fw-bold fs-5 text-success"><?= number_format($hoa_don['thanh_tien']) ?> đ</td></tr>
        </tfoot>
    </table>

    <?php if($hoa_don['ghi_chu']): ?>
    <p class="text-muted"><strong>Ghi chú:</strong> <?= htmlspecialchars($hoa_don['ghi_chu']) ?></p>
    <?php endif; ?>

    <div class="row mt-4 text-center">
        <div class="col-6">
            <p class="fw-bold">Người lập phiếu</p>
            <p class="text-muted small">(Ký, ghi rõ họ tên)</p>
        </div>
        <div class="col-6">
            <p class="fw-bold">Khách hàng</p>
            <p class="text-muted small">(Ký, ghi rõ họ tên)</p>
        </div>
    </div>
    <p class="text-center fst-italic text-muted mt-2">Cảm ơn Quý khách! Hẹn gặp lại!</p>
</div>

<style>
@media print {
    .sidebar, .topbar, .d-flex.gap-2 { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .page-content { padding: 0 !important; }
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>

<?php require_once 'app/views/layouts/header.php'; ?>
<?php if(isset($_GET['success'])): ?><div class="alert alert-success alert-dismissible fade show">Nhập kho thành công!<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-truck me-2 text-primary"></i>Phiếu nhập kho</h5>
    <a href="?page=nhap_kho&action=tao_moi" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tạo phiếu nhập</a>
</div>
<div class="table-card">
    <table class="table table-hover">
        <thead><tr><th>Số PN</th><th>Nhà cung cấp</th><th>Tổng SL nhập</th><th>Nhân viên</th><th>Lý do</th><th>Ngày nhập</th></tr></thead>
        <tbody>
        <?php if($phieu_nhaps): foreach($phieu_nhaps as $pn): ?>
        <tr>
            <td class="fw-semibold text-primary"><?=$pn['so_pn']?></td>
            <td><?= htmlspecialchars($pn['nha_cung_cap']??'—') ?></td>
            <td><span class="badge bg-success"><?=$pn['tong_sl']??0?></span></td>
            <td class="text-muted small"><?= htmlspecialchars($pn['ten_nv']??'') ?></td>
            <td class="text-muted small"><?= htmlspecialchars($pn['ly_do']??'') ?></td>
            <td class="text-muted small"><?= date('d/m/Y H:i',strtotime($pn['ngay_nhap'])) ?></td>
        </tr>
        <?php endforeach; else: ?><tr><td colspan="6" class="text-center text-muted py-4">Chưa có phiếu nhập nào</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

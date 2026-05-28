<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-receipt me-2 text-primary"></i>Hóa đơn bán hàng</h5>
    <a href="?page=hoa_don&action=tao_moi" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tạo hóa đơn</a>
</div>

<div class="form-card mb-3 py-2">
    <form method="GET" class="row g-2 align-items-end">
        <input type="hidden" name="page" value="hoa_don">
        <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Số HĐ, tên khách..." value="<?= htmlspecialchars($search) ?>"></div>
        <div class="col-md-2"><label class="form-label small mb-1">Từ ngày</label><input type="date" name="tu_ngay" class="form-control" value="<?=$tu_ngay?>"></div>
        <div class="col-md-2"><label class="form-label small mb-1">Đến ngày</label><input type="date" name="den_ngay" class="form-control" value="<?=$den_ngay?>"></div>
        <div class="col-md-2"><button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Tìm</button></div>
        <div class="col-md-2"><a href="?page=hoa_don" class="btn btn-outline-secondary w-100">Đặt lại</a></div>
        <div class="col-md-1 text-end"><span class="badge bg-success fs-6"><?= number_format($tong_doanh_thu) ?> đ</span></div>
    </form>
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead>
            <tr><th>Số HĐ</th><th>Khách hàng</th><th>Nhân viên</th><th>TT Thanh toán</th><th>Tổng tiền</th><th>Giảm giá</th><th>Thành tiền</th><th>Ngày lập</th><th></th></tr>
        </thead>
        <tbody>
        <?php if($hoa_dons): foreach($hoa_dons as $hd): ?>
        <tr>
            <td><a href="?page=hoa_don&action=chi_tiet&id=<?=$hd['id']?>" class="fw-semibold text-primary"><?=$hd['so_hd']?></a></td>
            <td><?= htmlspecialchars($hd['ten_kh'] ?? 'Khách lẻ') ?></td>
            <td class="text-muted small"><?= htmlspecialchars($hd['ten_nv'] ?? '') ?></td>
            <td><span class="badge bg-light text-dark"><?=$hd['phuong_thuc_tt']?></span></td>
            <td><?= number_format($hd['tong_tien']) ?> đ</td>
            <td class="text-danger"><?= $hd['giam_gia']>0 ? '-'.number_format($hd['giam_gia']).' đ' : '—' ?></td>
            <td class="fw-bold text-success"><?= number_format($hd['thanh_tien']) ?> đ</td>
            <td class="text-muted small"><?= date('d/m/Y H:i',strtotime($hd['ngay_lap'])) ?></td>
            <td><a href="?page=hoa_don&action=chi_tiet&id=<?=$hd['id']?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="9" class="text-center text-muted py-4">Không có hóa đơn nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php if($total_pages>1): ?>
    <div class="d-flex justify-content-between p-3 border-top">
        <span class="text-muted small">Tổng: <?=$total?> hóa đơn</span>
        <nav><ul class="pagination pagination-sm m-0">
            <?php for($i=1;$i<=$total_pages;$i++): ?>
            <li class="page-item <?=$i==$page?'active':''?>"><a class="page-link" href="?page=hoa_don&p=<?=$i?>&search=<?=urlencode($search)?>&tu_ngay=<?=$tu_ngay?>&den_ngay=<?=$den_ngay?>"><?=$i?></a></li>
            <?php endfor; ?>
        </ul></nav>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

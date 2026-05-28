<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row g-4">
    <div class="col-md-5">
        <div class="form-card h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="fw-bold m-0"><?= htmlspecialchars($san_pham['ten_sp']) ?></h5>
                <span class="badge bg-primary"><?= htmlspecialchars($san_pham['ma_sp']) ?></span>
            </div>
            <table class="table table-sm">
                <tr><td class="text-muted">Danh mục</td><td class="fw-semibold"><?= htmlspecialchars($san_pham['ten_danh_muc'] ?? '—') ?></td></tr>
                <tr><td class="text-muted">Đơn vị tính</td><td><?= htmlspecialchars($san_pham['don_vi_tinh']) ?></td></tr>
                <tr><td class="text-muted">Giá bán</td><td class="fw-bold text-success fs-5"><?= number_format($san_pham['gia_ban']) ?> đ</td></tr>
                <tr><td class="text-muted">Tồn kho</td>
                    <td><span class="badge fs-6 <?= $san_pham['so_luong_ton']<=0?'bg-danger':($san_pham['so_luong_ton']<10?'bg-warning text-dark':'bg-success') ?>">
                        <?= $san_pham['so_luong_ton'] ?>
                    </span></td>
                </tr>
                <?php if($san_pham['mo_ta']): ?>
                <tr><td class="text-muted">Mô tả</td><td><?= nl2br(htmlspecialchars($san_pham['mo_ta'])) ?></td></tr>
                <?php endif; ?>
            </table>
            <div class="d-flex gap-2 mt-3">
                <a href="?page=san_pham&action=sua&id=<?=$san_pham['id']?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Sửa</a>
                <a href="?page=san_pham" class="btn btn-outline-secondary">← Quay lại</a>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="table-card">
            <div class="p-3 border-bottom fw-bold"><i class="bi bi-clock-history me-2"></i>Lịch sử bán hàng gần đây</div>
            <table class="table table-sm">
                <thead><tr><th>Số HĐ</th><th>Số lượng</th><th>Đơn giá</th><th>Ngày</th></tr></thead>
                <tbody>
                <?php if($lich_su): foreach($lich_su as $ls): ?>
                <tr>
                    <td><a href="?page=hoa_don&action=chi_tiet&id=<?=$ls['hoa_don_id']?>"><?= htmlspecialchars($ls['so_hd']) ?></a></td>
                    <td><?=$ls['so_luong']?></td>
                    <td><?= number_format($ls['don_gia']) ?> đ</td>
                    <td class="text-muted small"><?= date('d/m/Y',strtotime($ls['ngay_lap'])) ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="4" class="text-center text-muted py-3">Chưa có giao dịch</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

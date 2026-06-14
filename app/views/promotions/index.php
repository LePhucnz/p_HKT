<?php $title = 'Khuyến mãi'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-gift me-2 text-primary"></i>Quản lý khuyến mãi</h5>
    <a href="<?= BASE_URL ?>promotion/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Thêm khuyến mãi
    </a>
</div>

<div class="table-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr><th>Tên chương trình</th><th>Loại</th><th>Giá trị</th><th>Từ ngày</th><th>Đến ngày</th><th>Trạng thái</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
        <?php if($promotions): foreach($promotions as $km): ?>
        <tr>
            <td class="fw-semibold"><?= htmlspecialchars($km['ten_km']) ?></td>
            <td><?= $km['loai_km']==='percent' ? 'Giảm %' : 'Giảm tiền' ?></td>
            <td class="fw-semibold text-danger">
                <?= $km['loai_km']==='percent' ? $km['gia_tri'].'%' : number_format($km['gia_tri']).'đ' ?>
            </td>
            <td class="text-muted"><?= date('d/m/Y', strtotime($km['ngay_bat_dau'])) ?></td>
            <td class="text-muted"><?= date('d/m/Y', strtotime($km['ngay_ket_thuc'])) ?></td>
            <td>
                <span class="badge <?= $km['trang_thai'] ? 'bg-success' : 'bg-secondary' ?>">
                    <?= $km['trang_thai'] ? 'Đang hoạt động' : 'Tạm dừng' ?>
                </span>
            </td>
            <td>
                <a href="<?= BASE_URL ?>promotion/toggleStatus/<?= $km['id'] ?>"
                   class="btn btn-sm btn-outline-info">
                   <?= $km['trang_thai'] ? 'Tắt' : 'Bật' ?>
                </a>
                <a href="<?= BASE_URL ?>promotion/destroy/<?= $km['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Xóa khuyến mãi này?')">
                   <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Chưa có khuyến mãi nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

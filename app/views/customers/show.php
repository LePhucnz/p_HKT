<?php $title = 'Chi tiết khách hàng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="mb-3">
    <a href="<?= BASE_URL ?>customer" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Quay lại
    </a>
    <a href="<?= BASE_URL ?>customer/edit/<?= $customer['id'] ?>" class="btn btn-sm btn-outline-warning ms-2">
        <i class="bi bi-pencil me-1"></i>Sửa
    </a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="table-card" style="padding:20px">
            <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2 text-primary"></i>Thông tin khách hàng</h6>
            <?php $hang = $customer['hang_thanh_vien']; ?>
            <div class="text-center mb-3">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-primary text-white"
                     style="width:64px;height:64px;font-size:1.6rem">
                    <?= mb_substr($customer['ho_ten'], 0, 1) ?>
                </div>
                <div class="fw-bold mt-2"><?= htmlspecialchars($customer['ho_ten']) ?></div>
                <span class="badge <?= $hang==='Kim cương'?'bg-info':($hang==='Vàng'?'bg-warning text-dark':'bg-secondary') ?>">
                    <?= $hang ?>
                </span>
            </div>
            <table class="table table-sm table-borderless">
                <tr><td class="text-muted" width="40%">Mã KH</td><td class="fw-semibold"><?= htmlspecialchars($customer['ma_kh']) ?></td></tr>
                <tr><td class="text-muted">SĐT</td><td><?= htmlspecialchars($customer['so_dien_thoai']) ?></td></tr>
                <tr><td class="text-muted">Email</td><td><?= htmlspecialchars($customer['email'] ?? '—') ?></td></tr>
                <tr><td class="text-muted">Ngày sinh</td><td><?= $customer['ngay_sinh'] ? date('d/m/Y', strtotime($customer['ngay_sinh'])) : '—' ?></td></tr>
                <tr><td class="text-muted">Giới tính</td><td><?= htmlspecialchars($customer['gioi_tinh'] ?? '—') ?></td></tr>
                <tr><td class="text-muted">Địa chỉ</td><td><?= htmlspecialchars($customer['dia_chi'] ?? '—') ?></td></tr>
                <tr><td class="text-muted">Đăng ký</td><td><?= $customer['ngay_dang_ky'] ? date('d/m/Y', strtotime($customer['ngay_dang_ky'])) : '—' ?></td></tr>
                <tr><td class="text-muted">Điểm</td><td><span class="fw-bold text-success fs-5"><?= number_format($customer['diem_tich_luy']) ?></span></td></tr>
                <tr><td class="text-muted">Tổng chi tiêu</td><td class="fw-bold text-danger"><?= number_format($totalSpent) ?>đ</td></tr>
            </table>
        </div>
    </div>

    <div class="col-md-8">
        <div class="table-card">
            <div class="card-header-custom">
                <span><i class="bi bi-receipt me-2 text-success"></i>Lịch sử mua hàng</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr><th>Số HĐ</th><th>Ngày</th><th>Tổng tiền</th><th>Thanh toán</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php if($invoices): foreach($invoices as $hd): ?>
                    <tr>
                        <td class="fw-semibold text-primary">
                            <a href="<?= BASE_URL ?>invoice/show/<?= $hd['id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($hd['so_hd']) ?>
                            </a>
                        </td>
                        <td class="text-muted"><?= date('d/m/Y H:i', strtotime($hd['ngay_lap'])) ?></td>
                        <td class="fw-semibold text-success"><?= number_format($hd['thanh_tien']) ?>đ</td>
                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($hd['phuong_thuc_tt']) ?></span></td>
                        <td><a href="<?= BASE_URL ?>invoice/show/<?= $hd['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Chưa có lịch sử mua hàng</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

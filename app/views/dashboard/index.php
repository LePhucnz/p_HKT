<?php require_once 'app/views/layouts/header.php'; ?>

<!-- ===== STAT CARDS ===== -->
<div class="row g-3 mb-4">

    <!-- Doanh thu hom nay -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7">
                <i class="bi bi-currency-dollar" style="color:#16a34a"></i>
            </div>
            <div>
                <div class="value" style="font-size:1.1rem"><?= number_format($doanh_thu_hom_nay) ?>đ</div>
                <div class="label">Doanh thu hôm nay</div>
            </div>
        </div>
    </div>

    <!-- Doanh thu thang -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#dbeafe">
                <i class="bi bi-graph-up-arrow" style="color:#1d4ed8"></i>
            </div>
            <div>
                <div class="value" style="font-size:1.1rem"><?= number_format($doanh_thu_thang) ?>đ</div>
                <div class="label">Doanh thu tháng</div>
            </div>
        </div>
    </div>

    <!-- HĐ hom nay -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef9c3">
                <i class="bi bi-receipt" style="color:#ca8a04"></i>
            </div>
            <div>
                <div class="value"><?= $hd_hom_nay ?></div>
                <div class="label">Hóa đơn hôm nay</div>
            </div>
        </div>
    </div>

    <!-- Tong san pham -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f3e8ff">
                <i class="bi bi-box-seam" style="color:#7c3aed"></i>
            </div>
            <div>
                <div class="value"><?= $tong_san_pham ?></div>
                <div class="label">Sản phẩm</div>
            </div>
        </div>
    </div>

    <!-- Tong khach -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe">
                <i class="bi bi-people" style="color:#0284c7"></i>
            </div>
            <div>
                <div class="value"><?= $tong_khach ?></div>
                <div class="label">Khách hàng</div>
            </div>
        </div>
    </div>

    <!-- Sap het hang -->
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2">
                <i class="bi bi-exclamation-triangle" style="color:#dc2626"></i>
            </div>
            <div>
                <div class="value text-danger"><?= $sap_het ?></div>
                <div class="label">SP sắp hết hàng</div>
            </div>
        </div>
    </div>
</div>

<!-- ===== ROW 2: HÓA ĐƠN GẦN ĐÂY + TOP SP + SẮP HẾT ===== -->
<div class="row g-3">

    <!-- Hoa don gan day -->
    <div class="col-xl-7">
        <div class="table-card h-100">
            <div class="card-header-custom">
                <span><i class="bi bi-receipt me-2 text-primary"></i>Hóa đơn gần đây</span>
                <a href="<?= BASE_URL ?>invoice" class="btn btn-sm btn-outline-primary py-0">Xem tất cả</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Số HĐ</th>
                            <th>Khách hàng</th>
                            <th>Nhân viên</th>
                            <th>Thanh toán</th>
                            <th>Thành tiền</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($hoa_don_gan_day): foreach($hoa_don_gan_day as $hd): ?>
                    <tr>
                        <td>
                            <a href="<?= BASE_URL ?>invoice/show/<?= $hd['id'] ?>" class="fw-semibold text-primary text-decoration-none">
                                <?= htmlspecialchars($hd['so_hd']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($hd['ten_kh'] ?? 'Khách lẻ') ?></td>
                        <td class="text-muted"><?= htmlspecialchars($hd['ten_nv'] ?? '—') ?></td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                <?= htmlspecialchars($hd['phuong_thuc_tt']) ?>
                            </span>
                        </td>
                        <td class="fw-semibold text-success"><?= number_format($hd['thanh_tien']) ?>đ</td>
                        <td class="text-muted">
                            <?= date('H:i d/m', strtotime($hd['ngay_lap'])) ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-4 d-block mb-1"></i>Chưa có hóa đơn nào
                        </td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right column: top SP + sap het -->
    <div class="col-xl-5">
        <div class="row g-3">

            <!-- Top sản phẩm bán chạy -->
            <div class="col-12">
                <div class="table-card">
                    <div class="card-header-custom">
                        <span><i class="bi bi-fire me-2 text-danger"></i>Bán chạy nhất</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead><tr><th>#</th><th>Sản phẩm</th><th>Đã bán</th></tr></thead>
                            <tbody>
                            <?php if($san_pham_ban_chay): foreach($san_pham_ban_chay as $i => $sp): ?>
                            <tr>
                                <td>
                                    <?php
                                    $medals = ['🥇','🥈','🥉'];
                                    echo $medals[$i] ?? ($i+1);
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($sp['ten_sp']) ?></td>
                                <td><span class="badge bg-danger"><?= $sp['tong_ban'] ?></span></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="3" class="text-center text-muted py-3">Chưa có dữ liệu</td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sap het hang -->
            <div class="col-12">
                <div class="table-card">
                    <div class="card-header-custom">
                        <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Sắp hết hàng</span>
                        <a href="<?= BASE_URL ?>product" class="btn btn-sm btn-outline-warning py-0">Xem</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead><tr><th>Sản phẩm</th><th>Tồn kho</th></tr></thead>
                            <tbody>
                            <?php if($ds_sap_het): foreach($ds_sap_het as $sp): ?>
                            <tr>
                                <td><?= htmlspecialchars($sp['ten_sp']) ?></td>
                                <td>
                                    <span class="badge <?= $sp['so_luong_ton'] <= 0 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                                        <?= $sp['so_luong_ton'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="2" class="text-center text-muted py-3">
                                <i class="bi bi-check-circle text-success me-1"></i>Tồn kho ổn định
                            </td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ===== QUICK ACTIONS ===== -->
<div class="row g-3 mt-1">
    <div class="col-12">
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?= BASE_URL ?>invoice/create" class="btn btn-primary">
                <i class="bi bi-cart-plus me-1"></i>Tạo hóa đơn
            </a>
            <a href="<?= BASE_URL ?>product/create" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-1"></i>Thêm sản phẩm
            </a>
            <a href="<?= BASE_URL ?>customer/create" class="btn btn-outline-success">
                <i class="bi bi-person-plus me-1"></i>Thêm khách hàng
            </a>
            <a href="<?= BASE_URL ?>purchaseOrder/create" class="btn btn-outline-warning">
                <i class="bi bi-truck me-1"></i>Nhập kho
            </a>
            <?php if(User::hasRole([ROLE_ADMIN, ROLE_MANAGER])): ?>
            <a href="<?= BASE_URL ?>report/revenue" class="btn btn-outline-secondary">
                <i class="bi bi-bar-chart-line me-1"></i>Báo cáo doanh thu
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

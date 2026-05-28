<?php require_once 'app/views/layouts/header.php'; ?>

<!-- Stat cards -->
<div class="row g-3 mb-4">
    <?php
    $cards = [
        ['label'=>'Doanh thu hôm nay','value'=>number_format($stats['doanh_thu_hom_nay']).' đ','icon'=>'bi-currency-dollar','color'=>'#dcfce7','icolor'=>'#16a34a'],
        ['label'=>'Doanh thu tháng','value'=>number_format($stats['doanh_thu_thang']).' đ','icon'=>'bi-graph-up-arrow','color'=>'#dbeafe','icolor'=>'#2563eb'],
        ['label'=>'Hóa đơn hôm nay','value'=>$stats['tong_hoa_don_hom_nay'],'icon'=>'bi-receipt','color'=>'#fef9c3','icolor'=>'#d97706'],
        ['label'=>'Khách hàng','value'=>$stats['tong_khach_hang'],'icon'=>'bi-people','color'=>'#f3e8ff','icolor'=>'#7c3aed'],
        ['label'=>'Sản phẩm','value'=>$stats['tong_san_pham'],'icon'=>'bi-box-seam','color'=>'#e0f2fe','icolor'=>'#0284c7'],
        ['label'=>'Sắp hết hàng','value'=>$stats['san_pham_sap_het'],'icon'=>'bi-exclamation-triangle','color'=>'#fee2e2','icolor'=>'#dc2626'],
    ];
    foreach($cards as $c): ?>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card">
            <div class="stat-icon mb-3" style="background:<?=$c['color']?>">
                <i class="bi <?=$c['icon']?>" style="color:<?=$c['icolor']?>"></i>
            </div>
            <div class="fw-bold fs-5"><?=$c['value']?></div>
            <div class="text-muted small"><?=$c['label']?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4">
    <!-- Hóa đơn gần đây -->
    <div class="col-xl-8">
        <div class="table-card">
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <h6 class="fw-bold m-0"><i class="bi bi-receipt me-2 text-primary"></i>Hóa đơn gần đây</h6>
                <a href="?page=hoa_don" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Số HĐ</th><th>Khách hàng</th><th>Nhân viên</th>
                        <th>Thanh toán</th><th>Thành tiền</th><th>Ngày</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($hoa_don_gan_day): foreach($hoa_don_gan_day as $hd): ?>
                <tr>
                    <td><a href="?page=hoa_don&action=chi_tiet&id=<?=$hd['id']?>" class="fw-semibold text-primary"><?=$hd['so_hd']?></a></td>
                    <td><?= htmlspecialchars($hd['ten_kh'] ?? 'Khách lẻ') ?></td>
                    <td><?= htmlspecialchars($hd['ten_nv'] ?? '') ?></td>
                    <td><span class="badge bg-light text-dark"><?=$hd['phuong_thuc_tt']?></span></td>
                    <td class="fw-semibold text-success"><?=number_format($hd['thanh_tien'])?> đ</td>
                    <td class="text-muted small"><?=date('d/m H:i',strtotime($hd['ngay_lap']))?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Chưa có hóa đơn nào</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sản phẩm sắp hết -->
    <div class="col-xl-4">
        <div class="table-card h-100">
            <div class="p-3 border-bottom">
                <h6 class="fw-bold m-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Sắp hết hàng</h6>
            </div>
            <table class="table">
                <thead><tr><th>Sản phẩm</th><th>Tồn</th></tr></thead>
                <tbody>
                <?php if($san_pham_sap_het): foreach($san_pham_sap_het as $sp): ?>
                <tr>
                    <td><?= htmlspecialchars($sp['ten_sp']) ?></td>
                    <td><span class="badge <?= $sp['so_luong_ton']<=0?'bg-danger':'bg-warning text-dark' ?>"><?=$sp['so_luong_ton']?></span></td>
                </tr>
                <?php endforeach; else: ?>
                <tr><td colspan="2" class="text-center text-muted py-3">Tồn kho ổn định ✓</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

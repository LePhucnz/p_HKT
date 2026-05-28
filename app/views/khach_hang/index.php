<?php require_once 'app/views/layouts/header.php'; ?>
<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success alert-dismissible fade show"><?= ['them'=>'Thêm khách hàng thành công!','sua'=>'Cập nhật thành công!'][$_GET['success']] ?? '' ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-people me-2 text-primary"></i>Khách hàng</h5>
    <a href="?page=khach_hang&action=them" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Thêm khách hàng</a>
</div>
<div class="form-card mb-3 py-2">
    <form method="GET" class="row g-2">
        <input type="hidden" name="page" value="khach_hang">
        <div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="Tên, SĐT, mã KH..." value="<?= htmlspecialchars($search) ?>"></div>
        <div class="col-md-3"><button class="btn btn-outline-primary w-100">Tìm</button></div>
        <div class="col-md-3"><a href="?page=khach_hang" class="btn btn-outline-secondary w-100">Đặt lại</a></div>
    </form>
</div>
<div class="table-card">
    <table class="table table-hover">
        <thead><tr><th>Mã KH</th><th>Họ tên</th><th>SĐT</th><th>Email</th><th>Hạng</th><th>Điểm</th><th>Ngày đăng ký</th><th></th></tr></thead>
        <tbody>
        <?php if($khach_hangs): foreach($khach_hangs as $kh): ?>
        <tr>
            <td><span class="badge bg-light text-dark"><?=$kh['ma_kh']?></span></td>
            <td class="fw-semibold"><?= htmlspecialchars($kh['ho_ten']) ?></td>
            <td><?= htmlspecialchars($kh['so_dien_thoai']??'—') ?></td>
            <td class="text-muted small"><?= htmlspecialchars($kh['email']??'—') ?></td>
            <td><span class="badge <?= ['Bạc'=>'bg-secondary','Vàng'=>'bg-warning text-dark','Kim cương'=>'bg-info'][$kh['hang_thanh_vien']] ?? 'bg-secondary' ?>"><?=$kh['hang_thanh_vien']?></span></td>
            <td><?=$kh['diem_tich_luy']?></td>
            <td class="text-muted small"><?= $kh['ngay_dang_ky'] ? date('d/m/Y',strtotime($kh['ngay_dang_ky'])) : '—' ?></td>
            <td><a href="?page=khach_hang&action=sua&id=<?=$kh['id']?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="8" class="text-center text-muted py-4">Chưa có khách hàng nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

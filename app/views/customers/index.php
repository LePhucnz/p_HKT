<?php $title = 'Khách hàng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-people me-2 text-primary"></i>Khách hàng</h5>
    <a href="<?= BASE_URL ?>customer/create" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Thêm khách hàng
    </a>
</div>

<div class="table-card mb-3" style="padding:12px">
    <form method="GET" class="d-flex gap-2">
        <input type="hidden" name="url" value="customer">
        <input type="text" name="search" class="form-control" placeholder="Tìm tên, SĐT, mã KH..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <select name="hang_thanh_vien" class="form-select" style="width:160px">
            <option value="">Tất cả hạng</option>
            <option value="Bạc"       <?= ($_GET['hang_thanh_vien']??'')==='Bạc'?'selected':'' ?>>Bạc</option>
            <option value="Vàng"      <?= ($_GET['hang_thanh_vien']??'')==='Vàng'?'selected':'' ?>>Vàng</option>
            <option value="Kim cương" <?= ($_GET['hang_thanh_vien']??'')==='Kim cương'?'selected':'' ?>>Kim cương</option>
        </select>
        <button class="btn btn-outline-primary px-3"><i class="bi bi-search"></i></button>
        <a href="<?= BASE_URL ?>customers" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
    </form>
</div>

<div class="table-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr><th>Mã KH</th><th>Họ tên</th><th>SĐT</th><th>Email</th><th>Điểm</th><th>Hạng</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
        <?php if($customers): foreach($customers as $kh): ?>
        <tr>
            <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($kh['ma_kh']) ?></span></td>
            <td class="fw-semibold"><?= htmlspecialchars($kh['ho_ten']) ?></td>
            <td><?= htmlspecialchars($kh['so_dien_thoai']) ?></td>
            <td class="text-muted"><?= htmlspecialchars($kh['email'] ?? '—') ?></td>
            <td><?= number_format($kh['diem_tich_luy']) ?></td>
            <td>
                <?php $hang = $kh['hang_thanh_vien']; ?>
                <span class="badge <?= $hang==='Kim cương'?'bg-info':($hang==='Vàng'?'bg-warning text-dark':'bg-secondary') ?>">
                    <?= $hang ?>
                </span>
            </td>
            <td>
                <a href="<?= BASE_URL ?>customer/show/<?= $kh['id'] ?>" class="btn btn-sm btn-outline-info" title="Xem"><i class="bi bi-eye"></i></a>
                <a href="<?= BASE_URL ?>customer/edit/<?= $kh['id'] ?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="bi bi-pencil"></i></a>
                <a href="<?= BASE_URL ?>customer/destroy/<?= $kh['id'] ?>"
                   class="btn btn-sm btn-outline-danger" title="Xóa"
                   onclick="return confirm('Xóa khách hàng <?= htmlspecialchars($kh['ho_ten']) ?>?')">
                   <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Chưa có khách hàng nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

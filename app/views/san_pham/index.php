<?php require_once 'app/views/layouts/header.php'; ?>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?= ['them'=>'Thêm sản phẩm thành công!','sua'=>'Cập nhật thành công!','xoa'=>'Đã xóa sản phẩm!'][$_GET['success']] ?? 'Thành công!' ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-box-seam me-2 text-primary"></i>Sản phẩm</h5>
    <a href="?page=san_pham&action=them" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Thêm sản phẩm
    </a>
</div>

<!-- Bộ lọc -->
<div class="form-card mb-3 py-2">
    <form method="GET" class="row g-2 align-items-end">
        <input type="hidden" name="page" value="san_pham">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Tìm mã SP, tên sản phẩm..." value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-3">
            <select name="danh_muc_id" class="form-select">
                <option value="">-- Tất cả danh mục --</option>
                <?php foreach($danh_mucs as $dm): ?>
                <option value="<?=$dm['id']?>" <?= $danh_muc_id==$dm['id']?'selected':'' ?>><?= htmlspecialchars($dm['ten_danh_muc']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search me-1"></i>Tìm</button>
        </div>
        <div class="col-md-2">
            <a href="?page=san_pham" class="btn btn-outline-secondary w-100">Đặt lại</a>
        </div>
    </form>
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Mã SP</th><th>Tên sản phẩm</th><th>Danh mục</th>
                <th>ĐVT</th><th>Giá bán</th><th>Tồn kho</th><th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if($san_phams): foreach($san_phams as $sp): ?>
        <tr>
            <td><span class="badge bg-light text-dark fw-semibold"><?= htmlspecialchars($sp['ma_sp']) ?></span></td>
            <td><a href="?page=san_pham&action=chi_tiet&id=<?=$sp['id']?>" class="fw-semibold text-dark"><?= htmlspecialchars($sp['ten_sp']) ?></a></td>
            <td class="text-muted"><?= htmlspecialchars($sp['ten_danh_muc'] ?? '—') ?></td>
            <td><?= htmlspecialchars($sp['don_vi_tinh']) ?></td>
            <td class="fw-semibold text-success"><?= number_format($sp['gia_ban']) ?> đ</td>
            <td>
                <span class="badge <?= $sp['so_luong_ton']<=0?'bg-danger':($sp['so_luong_ton']<10?'bg-warning text-dark':'bg-success') ?>">
                    <?= $sp['so_luong_ton'] ?>
                </span>
            </td>
            <td>
                <a href="?page=san_pham&action=chi_tiet&id=<?=$sp['id']?>" class="btn btn-sm btn-outline-info" title="Chi tiết"><i class="bi bi-eye"></i></a>
                <a href="?page=san_pham&action=sua&id=<?=$sp['id']?>" class="btn btn-sm btn-outline-warning" title="Sửa"><i class="bi bi-pencil"></i></a>
                <button onclick="confirmDelete('?page=san_pham&action=xoa&id=<?=$sp['id']?>','<?= htmlspecialchars($sp['ten_sp']) ?>')" class="btn btn-sm btn-outline-danger" title="Xóa"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Không có sản phẩm nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <?php if($total_pages > 1): ?>
    <div class="d-flex justify-content-between align-items-center p-3 border-top">
        <span class="text-muted small">Tổng: <?=$total?> sản phẩm</span>
        <nav><ul class="pagination pagination-sm m-0">
            <?php for($i=1;$i<=$total_pages;$i++): ?>
            <li class="page-item <?=$i==$page?'active':''?>">
                <a class="page-link" href="?page=san_pham&p=<?=$i?>&search=<?=urlencode($search)?>&danh_muc_id=<?=$danh_muc_id?>"><?=$i?></a>
            </li>
            <?php endfor; ?>
        </ul></nav>
    </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

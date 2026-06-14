<?php $title = 'Danh mục'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-tags me-2 text-primary"></i>Danh mục sản phẩm</h5>
    <a href="<?= BASE_URL ?>category/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Thêm danh mục
    </a>
</div>

<div class="table-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr><th>ID</th><th>Tên danh mục</th><th>Mô tả</th><th>Số SP</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
        <?php if($categories): foreach($categories as $cat): ?>
        <tr>
            <td class="text-muted"><?= $cat['id'] ?></td>
            <td class="fw-semibold"><?= htmlspecialchars($cat['ten_danh_muc']) ?></td>
            <td class="text-muted"><?= htmlspecialchars($cat['mo_ta'] ?? '—') ?></td>
            <td><span class="badge bg-info"><?= $cat['product_count'] ?></span></td>
            <td>
                <a href="<?= BASE_URL ?>category/edit/<?= $cat['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                <a href="<?= BASE_URL ?>category/destroy/<?= $cat['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Xóa danh mục <?= htmlspecialchars($cat['ten_danh_muc']) ?>?')">
                   <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="5" class="text-center text-muted py-4">Chưa có danh mục nào</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

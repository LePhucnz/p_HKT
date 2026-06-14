<?php $title = 'Báo cáo tồn kho'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>📊 Báo cáo tồn kho</h2>
    <form method="GET" class="d-inline-flex">
        <select name="category_id" class="form-select me-2" style="width: 200px;">
            <option value="">Tất cả danh mục</option>
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($_GET['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                <?= $cat['ten_danh_muc'] ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Lọc</button>
    </form>
</div>

<!-- Thống kê nhanh -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Tổng sản phẩm</h6>
                <h3><?= $stats['total_products'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Tổng giá trị tồn</h6>
                <h3><?= number_format($stats['total_value']) ?>đ</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Sắp hết hàng (&lt;10)</h6>
                <h3><?= $stats['low_stock_count'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h6>Hết hàng</h6>
                <h3><?= $stats['out_of_stock_count'] ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Bảng tồn kho -->
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-hover" id="inventoryTable">
            <thead class="table-dark">
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Đơn vị</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Giá trị tồn</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $sp): ?>
                <tr>
                    <td><?= $sp['ma_sp'] ?></td>
                    <td><?= htmlspecialchars($sp['ten_sp']) ?></td>
                    <td><?= $sp['ten_danh_muc'] ?? 'Chưa phân loại' ?></td>
                    <td><?= $sp['don_vi_tinh'] ?></td>
                    <td><?= number_format($sp['gia_ban']) ?>đ</td>
                    <td class="fw-bold <?= $sp['so_luong_ton'] < 10 ? 'text-danger' : '' ?>">
                        <?= $sp['so_luong_ton'] ?>
                    </td>
                    <td><?= number_format($sp['so_luong_ton'] * $sp['gia_ban']) ?>đ</td>
                    <td>
                        <?php if ($sp['so_luong_ton'] == 0): ?>
                            <span class="badge bg-danger">Hết hàng</span>
                        <?php elseif ($sp['so_luong_ton'] < 10): ?>
                            <span class="badge bg-warning">Sắp hết</span>
                        <?php else: ?>
                            <span class="badge bg-success">Còn hàng</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Tìm kiếm trong bảng
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#inventoryTable tbody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>
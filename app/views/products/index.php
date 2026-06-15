<?php $title = 'Sản phẩm'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-box-seam me-2 text-primary"></i>Sản phẩm</h5>
    <?php if(User::hasRole([ROLE_ADMIN, ROLE_MANAGER])): ?>
    <a href="<?= BASE_URL ?>product/create" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Thêm sản phẩm
    </a>
    <?php endif; ?>
</div>

<div class="table-card mb-3" style="padding:12px">
    <form method="GET" class="d-flex gap-2">
        <input type="hidden" name="url" value="product">
        <input type="text" name="search" class="form-control"
               placeholder="🔍 Tìm mã SP, tên sản phẩm..."
               value="<?= htmlspecialchars($keyword ?? '') ?>">
        <button class="btn btn-outline-primary px-3"><i class="bi bi-search"></i></button>
        <a href="<?= BASE_URL ?>product" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
    </form>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th width="60">Ảnh</th>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>ĐVT</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <?php if(User::hasRole([ROLE_ADMIN, ROLE_MANAGER])): ?>
                    <th>Thao tác</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php if($products): foreach($products as $p): ?>
            <tr>
                <td>
                    <?php if(!empty($p['hinh_anh']) && file_exists($p['hinh_anh'])): ?>
                        <img src="<?= BASE_URL ?><?= htmlspecialchars($p['hinh_anh']) ?>"
                             style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb"
                             alt="<?= htmlspecialchars($p['ten_sp']) ?>">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-light rounded"
                             style="width:44px;height:44px;border:1px solid #e5e7eb">
                            <i class="bi bi-image text-muted"></i>
                        </div>
                    <?php endif; ?>
                </td>
                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p['ma_sp']) ?></span></td>
                <td class="fw-semibold"><?= htmlspecialchars($p['ten_sp']) ?></td>
                <td class="text-muted"><?= htmlspecialchars($p['ten_danh_muc'] ?? '—') ?></td>
                <td><?= htmlspecialchars($p['don_vi_tinh'] ?? '') ?></td>
                <td class="fw-semibold text-success"><?= number_format($p['gia_ban']) ?>đ</td>
                <td>
                    <?php $ton = intval($p['so_luong_ton']); ?>
                    <span class="badge <?= $ton<=0?'bg-danger':($ton<10?'bg-warning text-dark':'bg-success') ?>">
                        <?= $ton ?>
                    </span>
                </td>
                <?php if(User::hasRole([ROLE_ADMIN, ROLE_MANAGER])): ?>
                <td>
                    <a href="<?= BASE_URL ?>product/edit/<?= $p['id'] ?>"
                       class="btn btn-sm btn-outline-warning" title="Sửa">
                       <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= BASE_URL ?>product/destroy/<?= $p['id'] ?>"
                       class="btn btn-sm btn-outline-danger" title="Xóa"
                       onclick="return confirm('Xóa sản phẩm <?= htmlspecialchars($p['ten_sp'], ENT_QUOTES) ?>?')">
                       <i class="bi bi-trash"></i>
                    </a>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="bi bi-box-seam fs-4 d-block mb-1"></i>Không có sản phẩm nào
                </td>
            </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

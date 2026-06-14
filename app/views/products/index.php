<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>🛍️ Danh sách sản phẩm</h4>
    <a href="<?= BASE_URL ?>product/create" class="btn btn-primary">➕ Thêm sản phẩm</a>
  </div>
  <?php if(isset($_SESSION['success'])): ?><div class="alert alert-success alert-dismissible fade show"><?= $_SESSION['success']; unset($_SESSION['success']); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
  <?php if(isset($_SESSION['error'])): ?><div class="alert alert-danger alert-dismissible fade show"><?= $_SESSION['error']; unset($_SESSION['error']); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>

  <div class="card shadow-sm mb-3">
    <div class="card-body py-2">
      <form method="GET" class="d-flex gap-2">
        <input type="hidden" name="url" value="product">
        <input type="text" name="search" class="form-control" placeholder="Tìm mã SP, tên sản phẩm..." value="<?= htmlspecialchars($keyword) ?>">
        <button class="btn btn-outline-primary">🔍</button>
        <a href="<?= BASE_URL ?>product" class="btn btn-outline-secondary">✕</a>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-dark">
          <tr><th>Mã SP</th><th>Tên sản phẩm</th><th>Danh mục</th><th>ĐVT</th><th>Giá bán</th><th>Tồn kho</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
        <?php if($products): foreach($products as $p): ?>
        <tr>
          <td><span class="badge bg-secondary"><?= htmlspecialchars($p['ma_sp']) ?></span></td>
          <td class="fw-semibold"><?= htmlspecialchars($p['ten_sp']) ?></td>
          <td><?= htmlspecialchars($p['ten_danh_muc'] ?? '—') ?></td>
          <td><?= htmlspecialchars($p['don_vi_tinh'] ?? '') ?></td>
          <td class="text-success fw-semibold"><?= number_format($p['gia_ban']) ?> đ</td>
          <td>
            <?php $ton = $p['so_luong_ton']; ?>
            <span class="badge <?= $ton<=0?'bg-danger':($ton<10?'bg-warning text-dark':'bg-success') ?>"><?= $ton ?></span>
          </td>
          <td>
            <a href="<?= BASE_URL ?>product/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-warning">✏️</a>
            <a href="<?= BASE_URL ?>product/destroy/<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Xóa sản phẩm <?= htmlspecialchars($p['ten_sp']) ?>?')">🗑️</a>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" class="text-center text-muted py-3">Không có sản phẩm nào</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>

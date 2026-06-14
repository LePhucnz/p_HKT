<?php require_once 'app/views/layouts/header.php'; ?>
<div class="container-fluid py-4">
  <h4 class="mb-3">📦 Tạo phiếu nhập kho</h4>
  <?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>
  <form method="POST" action="<?= BASE_URL ?>purchaseOrder/store">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Nhà cung cấp</label>
            <input type="text" name="nha_cung_cap" class="form-control" placeholder="Tên nhà cung cấp">
          </div>
        </div>
      </div>
    </div>
    <div class="card shadow-sm mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Danh sách sản phẩm nhập</span>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="themDong()">➕ Thêm dòng</button>
      </div>
      <div class="card-body p-0">
        <table class="table mb-0" id="bangSP">
          <thead class="table-light"><tr>
            <th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá nhập</th><th></th>
          </tr></thead>
          <tbody id="tbodySP">
            <tr>
              <td>
                <select name="product_id[]" class="form-select form-select-sm">
                  <option value="">-- Chọn sản phẩm --</option>
                  <?php foreach($products as $p): ?>
                  <option value="<?=$p['id']?>"><?= htmlspecialchars($p['ma_sp'].' - '.$p['ten_sp']) ?> (Tồn: <?=$p['so_luong_ton']?>)</option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td><input type="number" name="quantity[]" class="form-control form-control-sm" min="1" value="1"></td>
              <td><input type="number" name="price[]" class="form-control form-control-sm" min="0" value="0"></td>
              <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">✕</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="d-flex gap-2">
      <button type="submit" class="btn btn-success">💾 Lưu phiếu nhập</button>
      <a href="<?= BASE_URL ?>purchaseOrder" class="btn btn-outline-secondary">Hủy</a>
    </div>
  </form>
</div>
<script>
function themDong() {
  const first = document.querySelector('#tbodySP tr').cloneNode(true);
  first.querySelectorAll('input').forEach(i => i.value = i.getAttribute('min') || 0);
  first.querySelector('select').selectedIndex = 0;
  document.getElementById('tbodySP').appendChild(first);
}
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>

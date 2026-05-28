<?php require_once 'app/views/layouts/header.php'; ?>
<?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>
<div class="row g-4">
<div class="col-lg-8">
    <div class="form-card mb-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-truck me-2 text-primary"></i>Thông tin phiếu nhập</h6>
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nhà cung cấp</label><input type="text" name="nha_cung_cap" id="ncc" class="form-control" placeholder="Tên nhà cung cấp..."></div>
            <div class="col-md-6"><label class="form-label">Lý do nhập</label><input type="text" name="ly_do" id="ly_do" class="form-control" placeholder="Nhập hàng định kỳ..."></div>
        </div>
    </div>
    <div class="form-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold m-0"><i class="bi bi-box me-2 text-success"></i>Danh sách hàng nhập</h6>
            <button type="button" class="btn btn-sm btn-success" onclick="themDong()"><i class="bi bi-plus me-1"></i>Thêm dòng</button>
        </div>
        <table class="table" id="bang_sp">
            <thead class="table-light"><tr><th>Sản phẩm</th><th>Số lượng</th><th>Đơn giá nhập</th><th></th></tr></thead>
            <tbody id="tbody_sp">
                <tr id="row_0">
                    <td><select name="items[0][san_pham_id]" class="form-select form-select-sm"><option value="">-- Chọn SP --</option><?php foreach($san_phams as $sp): ?><option value="<?=$sp['id']?>">[<?= htmlspecialchars($sp['ma_sp']) ?>] <?= htmlspecialchars($sp['ten_sp']) ?> (tồn: <?=$sp['so_luong_ton']?>)</option><?php endforeach; ?></select></td>
                    <td><input type="number" name="items[0][so_luong]" class="form-control form-control-sm" min="1" value="1"></td>
                    <td><input type="number" name="items[0][don_gia]" class="form-control form-control-sm" min="0" value="0" placeholder="0"></td>
                    <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-lg-4">
    <form method="POST" id="form_nhap">
        <input type="hidden" name="nha_cung_cap" id="f_ncc">
        <input type="hidden" name="ly_do" id="f_ly_do">
        <div id="hidden_items"></div>
        <div class="form-card">
            <button type="button" class="btn btn-primary w-100 py-2 fw-bold" onclick="submitPhieu()"><i class="bi bi-check-circle me-2"></i>Lưu phiếu nhập</button>
            <a href="?page=nhap_kho" class="btn btn-outline-secondary w-100 mt-2">Hủy</a>
        </div>
    </form>
</div>
</div>
<?php
$extra_js = <<<'JS'
<script>
let rc = 1;
function themDong() {
    const idx = rc++;
    const opts = document.querySelector('[name="items[0][san_pham_id]"]').innerHTML;
    const tr = document.createElement('tr');
    tr.id = 'row_' + idx;
    tr.innerHTML = `<td><select name="items[${idx}][san_pham_id]" class="form-select form-select-sm">${opts}</select></td>
        <td><input type="number" name="items[${idx}][so_luong]" class="form-control form-control-sm" min="1" value="1"></td>
        <td><input type="number" name="items[${idx}][don_gia]" class="form-control form-control-sm" min="0" value="0"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x"></i></button></td>`;
    document.getElementById('tbody_sp').appendChild(tr);
}
function submitPhieu() {
    document.getElementById('f_ncc').value = document.getElementById('ncc').value;
    document.getElementById('f_ly_do').value = document.getElementById('ly_do').value;
    const hid = document.getElementById('hidden_items');
    hid.innerHTML = '';
    document.querySelectorAll('#tbody_sp tr').forEach((row, ri) => {
        const spId = row.querySelector('[name*="san_pham_id"]').value;
        const sl   = row.querySelector('[name*="so_luong"]').value;
        const gia  = row.querySelector('[name*="don_gia"]').value;
        if (!spId) return;
        hid.innerHTML += `<input type="hidden" name="items[${ri}][san_pham_id]" value="${spId}">
            <input type="hidden" name="items[${ri}][so_luong]" value="${sl}">
            <input type="hidden" name="items[${ri}][don_gia]" value="${gia}">`;
    });
    document.getElementById('form_nhap').submit();
}
</script>
JS;
?>
<?php require_once 'app/views/layouts/footer.php'; ?>

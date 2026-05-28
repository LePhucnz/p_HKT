<?php require_once 'app/views/layouts/header.php'; ?>

<?php if($error): ?><div class="alert alert-danger"><?=$error?></div><?php endif; ?>

<div class="row g-4">
    <!-- Form hóa đơn -->
    <div class="col-lg-8">
        <div class="form-card mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-receipt me-2 text-primary"></i>Thông tin hóa đơn</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Số HĐ</label>
                    <input type="text" name="so_hd" id="so_hd_input" class="form-control" value="<?=htmlspecialchars($so_hd)?>" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Khách hàng</label>
                    <select name="khach_hang_id" class="form-select">
                        <option value="">Khách lẻ</option>
                        <?php foreach($khach_hangs as $kh): ?>
                        <option value="<?=$kh['id']?>"><?= htmlspecialchars($kh['ho_ten']) ?> - <?= htmlspecialchars($kh['so_dien_thoai']??'') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Thanh toán</label>
                    <select name="phuong_thuc_tt" class="form-select">
                        <option>Tiền mặt</option><option>Chuyển khoản</option>
                        <option>QR Code</option><option>Khác</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Bảng sản phẩm -->
        <div class="form-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold m-0"><i class="bi bi-box-seam me-2 text-success"></i>Danh sách sản phẩm</h6>
                <button type="button" class="btn btn-sm btn-success" onclick="themDong()"><i class="bi bi-plus-lg me-1"></i>Thêm dòng</button>
            </div>

            <table class="table" id="bang_sp">
                <thead class="table-light">
                    <tr><th width="35%">Sản phẩm</th><th width="15%">ĐVT</th><th width="20%">Đơn giá</th><th width="15%">SL</th><th width="15%">Thành tiền</th><th></th></tr>
                </thead>
                <tbody id="tbody_sp">
                    <tr id="row_0" class="invoice-row">
                        <td>
                            <select name="items[0][san_pham_id]" class="form-select form-select-sm" onchange="chonSanPham(this,0)">
                                <option value="">-- Chọn sản phẩm --</option>
                                <?php foreach($san_phams as $sp): ?>
                                <option value="<?=$sp['id']?>" data-gia="<?=$sp['gia_ban']?>" data-dvt="<?= htmlspecialchars($sp['don_vi_tinh']) ?>">
                                    [<?= htmlspecialchars($sp['ma_sp']) ?>] <?= htmlspecialchars($sp['ten_sp']) ?> (còn <?=$sp['so_luong_ton']?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" name="items[0][dvt]" class="form-control form-control-sm" readonly></td>
                        <td><input type="number" name="items[0][don_gia]" class="form-control form-control-sm" min="0" value="0" oninput="tinhTong(0)"></td>
                        <td><input type="number" name="items[0][so_luong]" class="form-control form-control-sm" min="1" value="1" oninput="tinhTong(0)"></td>
                        <td><input type="text" id="tt_0" class="form-control form-control-sm bg-light" readonly value="0"></td>
                        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="xoaDong(0)"><i class="bi bi-x"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tóm tắt + Nút -->
    <div class="col-lg-4">
        <form method="POST" id="form_hd">
            <!-- Hidden fields -->
            <input type="hidden" name="so_hd" id="f_so_hd">
            <input type="hidden" name="khach_hang_id" id="f_kh">
            <input type="hidden" name="phuong_thuc_tt" id="f_pttt">
            <input type="hidden" name="giam_gia" id="f_giam_gia" value="0">
            <input type="hidden" name="ghi_chu" id="f_ghi_chu">
            <div id="hidden_items"></div>

            <div class="form-card mb-3">
                <h6 class="fw-bold mb-3"><i class="bi bi-calculator me-2"></i>Tổng kết</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tổng tiền hàng:</span>
                    <span id="tong_tien_hang" class="fw-semibold">0 đ</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="text-muted mb-0">Giảm giá:</label>
                    <input type="number" id="inp_giam_gia" class="form-control form-control-sm w-50 text-end" min="0" value="0" oninput="capNhatTong()">
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Thành tiền:</span>
                    <span id="thanh_tien" class="fw-bold text-success fs-5">0 đ</span>
                </div>
            </div>

            <div class="form-card mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea id="inp_ghi_chu" class="form-control" rows="2" placeholder="Ghi chú hóa đơn..."></textarea>
            </div>

            <button type="button" class="btn btn-primary w-100 py-2 fw-bold" onclick="submitHoaDon()">
                <i class="bi bi-check-circle me-2"></i>Xuất hóa đơn
            </button>
            <a href="?page=hoa_don" class="btn btn-outline-secondary w-100 mt-2">Hủy</a>
        </form>
    </div>
</div>

<?php
$extra_js = <<<'JS'
<script>
let rowCount = 1;
const sanPhams = <?= json_encode(array_column($san_phams, null, 'id')) ?>;

function chonSanPham(sel, idx) {
    const opt = sel.options[sel.selectedIndex];
    const gia = opt.dataset.gia ?? 0;
    const dvt = opt.dataset.dvt ?? '';
    document.querySelector(`[name="items[${idx}][don_gia]"]`).value = gia;
    document.querySelector(`[name="items[${idx}][dvt]"]`).value = dvt;
    tinhTong(idx);
}

function tinhTong(idx) {
    const gia = parseFloat(document.querySelector(`[name="items[${idx}][don_gia]"]`).value) || 0;
    const sl = parseInt(document.querySelector(`[name="items[${idx}][so_luong]"]`).value) || 0;
    const tt = gia * sl;
    document.getElementById(`tt_${idx}`).value = tt.toLocaleString('vi-VN') + ' đ';
    capNhatTong();
}

function capNhatTong() {
    let tong = 0;
    document.querySelectorAll('[id^="tt_"]').forEach(el => {
        tong += parseFloat(el.value.replace(/[^\d]/g,'')) || 0;
    });
    const giam = parseFloat(document.getElementById('inp_giam_gia').value) || 0;
    document.getElementById('tong_tien_hang').textContent = tong.toLocaleString('vi-VN') + ' đ';
    document.getElementById('thanh_tien').textContent = Math.max(0, tong - giam).toLocaleString('vi-VN') + ' đ';
}

function themDong() {
    const idx = rowCount++;
    const opts = document.querySelector('[name="items[0][san_pham_id]"]').innerHTML;
    const row = document.createElement('tr');
    row.id = 'row_' + idx;
    row.className = 'invoice-row';
    row.innerHTML = `
        <td><select name="items[${idx}][san_pham_id]" class="form-select form-select-sm" onchange="chonSanPham(this,${idx})">${opts}</select></td>
        <td><input type="text" name="items[${idx}][dvt]" class="form-control form-control-sm" readonly></td>
        <td><input type="number" name="items[${idx}][don_gia]" class="form-control form-control-sm" min="0" value="0" oninput="tinhTong(${idx})"></td>
        <td><input type="number" name="items[${idx}][so_luong]" class="form-control form-control-sm" min="1" value="1" oninput="tinhTong(${idx})"></td>
        <td><input type="text" id="tt_${idx}" class="form-control form-control-sm bg-light" readonly value="0"></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="xoaDong(${idx})"><i class="bi bi-x"></i></button></td>`;
    document.getElementById('tbody_sp').appendChild(row);
}

function xoaDong(idx) {
    const row = document.getElementById('row_' + idx);
    if (document.querySelectorAll('#tbody_sp tr').length <= 1) return alert('Phải có ít nhất 1 sản phẩm!');
    row.remove();
    capNhatTong();
}

function submitHoaDon() {
    // Sync hidden fields
    document.getElementById('f_so_hd').value = document.getElementById('so_hd_input').value;
    document.getElementById('f_kh').value = document.querySelector('[name="khach_hang_id"]').value;
    document.getElementById('f_pttt').value = document.querySelector('[name="phuong_thuc_tt"]').value;
    document.getElementById('f_giam_gia').value = document.getElementById('inp_giam_gia').value;
    document.getElementById('f_ghi_chu').value = document.getElementById('inp_ghi_chu').value;

    // Copy items
    const hiddenDiv = document.getElementById('hidden_items');
    hiddenDiv.innerHTML = '';
    document.querySelectorAll('#tbody_sp tr').forEach((row, ri) => {
        const spId = row.querySelector('[name*="san_pham_id"]').value;
        const dvt  = row.querySelector('[name*="dvt"]').value;
        const gia  = row.querySelector('[name*="don_gia"]').value;
        const sl   = row.querySelector('[name*="so_luong"]').value;
        if (!spId) return;
        hiddenDiv.innerHTML += `<input type="hidden" name="items[${ri}][san_pham_id]" value="${spId}">
            <input type="hidden" name="items[${ri}][dvt]" value="${dvt}">
            <input type="hidden" name="items[${ri}][don_gia]" value="${gia}">
            <input type="hidden" name="items[${ri}][so_luong]" value="${sl}">`;
    });
    document.getElementById('form_hd').submit();
}
</script>
JS;
?>
<?php require_once 'app/views/layouts/footer.php'; ?>

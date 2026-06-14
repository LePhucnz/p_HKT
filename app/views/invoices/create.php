<?php $title = 'Tạo hóa đơn'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row g-3">
    <!-- COT TRAI: San pham -->
    <div class="col-lg-7">
        <div class="table-card mb-3">
            <div class="card-header-custom">
                <span><i class="bi bi-box-seam me-2 text-primary"></i>Chọn sản phẩm</span>
            </div>
            <div style="padding:12px">
                <input type="text" id="searchProduct" class="form-control mb-3"
                       placeholder="🔍 Tìm tên hoặc mã sản phẩm...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="productTable">
                    <thead>
                        <tr><th>Mã SP</th><th>Tên sản phẩm</th><th>Giá bán</th><th>Tồn</th><th></th></tr>
                    </thead>
                    <tbody>
                    <?php foreach($products as $p): ?>
                    <tr class="product-row">
                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p['ma_sp']) ?></span></td>
                        <td class="fw-semibold"><?= htmlspecialchars($p['ten_sp']) ?></td>
                        <td class="text-success fw-semibold"><?= number_format($p['gia_ban']) ?>đ</td>
                        <td>
                            <span class="badge <?= $p['so_luong_ton']<10?'bg-warning text-dark':'bg-success' ?>">
                                <?= $p['so_luong_ton'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary btn-add"
                                    data-id="<?= $p['id'] ?>"
                                    data-name="<?= htmlspecialchars($p['ten_sp'], ENT_QUOTES) ?>"
                                    data-price="<?= $p['gia_ban'] ?>"
                                    data-max="<?= $p['so_luong_ton'] ?>">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- COT PHAI: Gio hang + thanh toan -->
    <div class="col-lg-5">
        <!-- Thong tin hoa don -->
        <div class="table-card mb-3" style="padding:16px">
            <h6 class="fw-bold mb-3"><i class="bi bi-person me-2"></i>Thông tin hóa đơn</h6>
            <div class="mb-2">
                <label class="form-label fw-semibold" style="font-size:.82rem">Khách hàng</label>
                <select id="customerSelect" class="form-select form-select-sm">
                    <option value="">Khách lẻ</option>
                    <?php foreach($customers as $kh): ?>
                    <option value="<?= $kh['id'] ?>"><?= htmlspecialchars($kh['ho_ten']) ?> — <?= $kh['so_dien_thoai'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label fw-semibold" style="font-size:.82rem">Phương thức thanh toán</label>
                <select id="paymentMethod" class="form-select form-select-sm">
                    <option value="Tiền mặt">Tiền mặt</option>
                    <option value="Chuyển khoản">Chuyển khoản</option>
                    <option value="QR Code">QR Code</option>
                    <option value="Thẻ">Thẻ</option>
                </select>
            </div>
        </div>

        <!-- Gio hang -->
        <div class="table-card mb-3">
            <div class="card-header-custom">
                <span><i class="bi bi-cart me-2 text-success"></i>Giỏ hàng</span>
                <button class="btn btn-sm btn-outline-danger py-0" onclick="clearCart()">Xóa tất cả</button>
            </div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Sản phẩm</th><th>SL</th><th>Giá</th><th>T.tiền</th><th></th></tr></thead>
                    <tbody id="cartBody">
                        <!-- Gio hang hien tai tu session -->
                        <?php
                        $cart = $_SESSION['cart'] ?? [];
                        $total = 0;
                        if($cart): foreach($cart as $id => $item):
                            $sub = $item['price'] * $item['quantity'];
                            $total += $sub;
                        ?>
                        <tr id="cart-row-<?= $id ?>">
                            <td style="font-size:.8rem"><?= htmlspecialchars($item['name']) ?></td>
                            <td>
                                <input type="number" class="form-control form-control-sm qty-input"
                                       style="width:55px" min="1" max="<?= $item['stock'] ?>"
                                       value="<?= $item['quantity'] ?>"
                                       data-id="<?= $id ?>" data-price="<?= $item['price'] ?>">
                            </td>
                            <td style="font-size:.8rem"><?= number_format($item['price']) ?>đ</td>
                            <td class="fw-semibold subtotal-<?= $id ?>" style="font-size:.8rem"><?= number_format($sub) ?>đ</td>
                            <td>
                                <a href="<?= BASE_URL ?>invoice/removeFromCart/<?= $id ?>"
                                   class="btn btn-sm btn-outline-danger py-0">✕</a>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr id="empty-row"><td colspan="5" class="text-center text-muted py-3">Chưa có sản phẩm</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tong ket -->
        <div class="table-card" style="padding:16px">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Tổng tiền hàng:</span>
                <span id="totalAmount" class="fw-semibold"><?= number_format($total) ?>đ</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="text-muted mb-0">Giảm giá (đ):</label>
                <input type="number" id="discount" class="form-control form-control-sm text-end"
                       style="width:120px" min="0" value="0" oninput="updateFinal()">
            </div>
            <hr class="my-2">
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Thành tiền:</span>
                <span id="finalAmount" class="fw-bold text-success fs-5"><?= number_format($total) ?>đ</span>
            </div>

            <form method="POST" action="<?= BASE_URL ?>invoice/store" id="checkoutForm">
                <input type="hidden" name="khach_hang_id" id="f_khach_hang_id">
                <input type="hidden" name="phuong_thuc_tt" id="f_phuong_thuc_tt">
                <input type="hidden" name="giam_gia" id="f_giam_gia">
                <button type="button" class="btn btn-danger w-100 fw-semibold" onclick="submitOrder()">
                    <i class="bi bi-credit-card me-2"></i>Thanh toán
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Du lieu gio hang hien tai
let cart = <?= json_encode($cart ?? []) ?>;
let grandTotal = <?= $total ?>;

// Tim kiem san pham
document.getElementById('searchProduct').addEventListener('input', function() {
    const kw = this.value.toLowerCase();
    document.querySelectorAll('.product-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(kw) ? '' : 'none';
    });
});

// Them vao gio hang (AJAX)
document.querySelectorAll('.btn-add').forEach(btn => {
    btn.addEventListener('click', function() {
        const id    = this.dataset.id;
        const name  = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        const max   = parseInt(this.dataset.max);

        let qty = parseInt(prompt('Số lượng (còn ' + max + '):', 1));
        if (!qty || qty < 1 || qty > max) { alert('Số lượng không hợp lệ!'); return; }

        const fd = new FormData();
        fd.append('product_id', id);
        fd.append('quantity', qty);

        fetch('<?= BASE_URL ?>invoice/addToCart', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(data => {
                if (data.success) { location.reload(); }
                else { alert(data.message); }
            })
            .catch(() => { location.reload(); });
    });
});

// Cap nhat tong tien
function updateFinal() {
    const disc = parseFloat(document.getElementById('discount').value) || 0;
    const final = Math.max(0, grandTotal - disc);
    document.getElementById('finalAmount').textContent = final.toLocaleString('vi-VN') + 'đ';
}

function clearCart() {
    if (confirm('Xóa toàn bộ giỏ hàng?')) location.href = '<?= BASE_URL ?>invoice/clearCart';
}

function submitOrder() {
    if (grandTotal <= 0) { alert('Giỏ hàng trống!'); return; }
    document.getElementById('f_khach_hang_id').value = document.getElementById('customerSelect').value;
    document.getElementById('f_phuong_thuc_tt').value = document.getElementById('paymentMethod').value;
    document.getElementById('f_giam_gia').value = document.getElementById('discount').value;
    document.getElementById('checkoutForm').submit();
}
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>

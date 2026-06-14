<?php $title = 'Đổi/Trả hàng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h5>🔄 Tìm hóa đơn cần đổi/trả</h5>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="input-group">
                        <input type="text" name="invoice_code" class="form-control" placeholder="Nhập mã hóa đơn..." value="<?= $_GET['invoice_code'] ?? '' ?>">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>
                
                <?php if (isset($invoice)): ?>
                <hr>
                <div class="alert alert-info">
                    <strong>📄 Hóa đơn: <?= $invoice['so_hd'] ?></strong><br>
                    Ngày lập: <?= date('d/m/Y H:i', strtotime($invoice['ngay_lap'])) ?><br>
                    Khách hàng: <?= $invoice['khach_ten'] ?? 'Khách lẻ' ?><br>
                    Tổng tiền: <?= number_format($invoice['thanh_tien']) ?>đ
                </div>
                
                <form method="POST" action="<?= BASE_URL ?>returns/store">
                    <input type="hidden" name="hoa_don_id" value="<?= $invoice['id'] ?>">
                    <h6>Chọn sản phẩm cần trả:</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Chọn</th><th>Sản phẩm</th><th>Đã mua</th><th>Đơn giá</th><th>Số lượng trả</th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoice['details'] as $detail): ?>
                            <tr>
                                <td><input type="checkbox" name="return_items[]" value="<?= $detail['id'] ?>"></td>
                                <td><?= $detail['ten_sp'] ?></td>
                                <td><?= $detail['so_luong'] ?></td>
                                <td><?= number_format($detail['don_gia']) ?>đ</td>
                                <td>
                                    <input type="number" name="return_qty[<?= $detail['id'] ?>]" 
                                           class="form-control form-control-sm" 
                                           style="width: 80px" 
                                           max="<?= $detail['so_luong'] ?>" 
                                           value="1">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="mb-3">
                        <label>Lý do trả hàng:</label>
                        <textarea name="ly_do" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Phương thức hoàn tiền:</label>
                        <select name="phuong_thuc_hoan" class="form-select" required>
                            <option value="Tiền mặt">Tiền mặt</option>
                            <option value="Chuyển khoản">Chuyển khoản</option>
                            <option value="Ví điện tử">Ví điện tử</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận trả hàng?')">
                        Xác nhận trả hàng
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5>📋 Lịch sử đổi/trả</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr><th>Ngày</th><th>Hóa đơn</th><th>Số tiền</th><th>Trạng thái</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($returns as $rt): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($rt['ngay_tra'])) ?></td>
                            <td><?= $rt['so_hd'] ?></td>
                            <td><?= number_format($rt['so_tien_hoan']) ?>đ</td>
                            <td>
                                <?php if ($rt['trang_thai'] == 'completed'): ?>
                                    <span class="badge bg-success">Hoàn thành</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Đang xử lý</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
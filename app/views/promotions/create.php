<?php $title = 'Thêm khuyến mãi'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>
<div class="row justify-content-center"><div class="col-md-6">
<div class="table-card" style="padding:24px">
    <h5 class="fw-bold mb-4"><i class="bi bi-gift me-2 text-primary"></i>Thêm khuyến mãi</h5>
    <form method="POST" action="<?= BASE_URL ?>promotion/store">
        <div class="mb-3">
            <label class="form-label fw-semibold">Tên chương trình *</label>
            <input type="text" name="ten_km" class="form-control" placeholder="VD: Giảm 10% dịp lễ" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Mô tả</label>
            <textarea name="mo_ta" class="form-control" rows="2"></textarea>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Loại giảm giá *</label>
                <select name="loai_km" class="form-select" id="loaiKM" onchange="updateUnit()">
                    <option value="percent">Giảm theo % </option>
                    <option value="fixed">Giảm số tiền cố định</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Giá trị * <span id="unit">(1-100%)</span></label>
                <input type="number" name="gia_tri" class="form-control" min="0" max="100" step="0.01" required>
            </div>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ngày bắt đầu *</label>
                <input type="date" name="ngay_bat_dau" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ngày kết thúc *</label>
                <input type="date" name="ngay_ket_thuc" class="form-control" required>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-lg me-1"></i>Lưu</button>
            <a href="<?= BASE_URL ?>promotions" class="btn btn-outline-secondary">Hủy</a>
        </div>
    </form>
</div>
</div></div>
<script>
function updateUnit() {
    const v = document.getElementById('loaiKM').value;
    document.getElementById('unit').textContent = v==='percent' ? '(1-100%)' : '(VNĐ)';
    document.querySelector('[name=gia_tri]').max = v==='percent' ? 100 : '';
}
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>

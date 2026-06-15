<?php $title = 'Quản lý người dùng'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold m-0"><i class="bi bi-people-fill me-2 text-primary"></i>Quản lý người dùng</h5>
    <a href="<?= BASE_URL ?>user/create" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Thêm người dùng
    </a>
</div>

<div class="table-card">
    <table class="table table-hover mb-0">
        <thead>
            <tr><th>#</th><th>Họ tên</th><th>Email</th><th>Vai trò</th><th>Ngày tạo</th><th>Thao tác</th></tr>
        </thead>
        <tbody>
        <?php foreach($users as $u): ?>
        <tr>
            <td class="text-muted"><?= $u['id'] ?></td>
            <td class="fw-semibold">
                <?= htmlspecialchars($u['ho_ten']) ?>
                <?php if($u['id'] == $_SESSION['user_id']): ?>
                    <span class="badge bg-primary ms-1" style="font-size:.65rem">Bạn</span>
                <?php endif; ?>
            </td>
            <td class="text-muted"><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <?php
                $roleLabel = [
                    'admin'        => ['Admin',    'bg-danger'],
                    'manager'      => ['Quản lý',  'bg-warning text-dark'],
                    'cashier'      => ['Thu ngân',  'bg-primary'],
                    'stock_keeper' => ['Thủ kho',   'bg-info'],
                ];
                [$label, $cls] = $roleLabel[$u['vai_tro']] ?? [$u['vai_tro'], 'bg-secondary'];
                ?>
                <span class="badge <?= $cls ?>"><?= $label ?></span>
            </td>
            <td class="text-muted"><?= date('d/m/Y', strtotime($u['ngay_tao'])) ?></td>
            <td>
                <a href="<?= BASE_URL ?>user/edit/<?= $u['id'] ?>"
                   class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                <?php if($u['id'] != $_SESSION['user_id']): ?>
                <a href="<?= BASE_URL ?>user/destroy/<?= $u['id'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('Xóa người dùng <?= htmlspecialchars($u['ho_ten'], ENT_QUOTES) ?>?')">
                   <i class="bi bi-trash"></i>
                </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Ghi chu phan quyen -->
<div class="mt-3 p-3 rounded" style="background:#fff;border:1px solid #e5e7eb;font-size:.82rem">
    <div class="fw-semibold mb-2"><i class="bi bi-shield-check me-1 text-primary"></i>Phân quyền hệ thống</div>
    <div class="row g-2">
        <div class="col-md-3">
            <span class="badge bg-danger me-1">Admin</span>
            Toàn quyền hệ thống
        </div>
        <div class="col-md-3">
            <span class="badge bg-warning text-dark me-1">Quản lý</span>
            Xem báo cáo + quản lý SP, KH, KM
        </div>
        <div class="col-md-3">
            <span class="badge bg-primary me-1">Thu ngân</span>
            Tạo hóa đơn, xem sản phẩm
        </div>
        <div class="col-md-3">
            <span class="badge bg-info me-1">Thủ kho</span>
            Nhập kho, xem sản phẩm
        </div>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

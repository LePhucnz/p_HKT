<?php $title = 'Quản lý nhân viên'; ?>
<?php require_once 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>👨‍💼 Quản lý nhân viên</h2>
    <?php if (User::hasRole(ROLE_ADMIN)): ?>
    <a href="<?= BASE_URL ?>users/create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm nhân viên
    </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <?php if (User::hasRole(ROLE_ADMIN)): ?>
                    <th>Thao tác</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['ho_ten']) ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <?php
                        $roleName = match($user['vai_tro']) {
                            'admin' => 'Quản trị viên',
                            'manager' => 'Quản lý',
                            'cashier' => 'Thu ngân',
                            'stock_keeper' => 'Thủ kho',
                            default => $user['vai_tro']
                        };
                        $roleClass = match($user['vai_tro']) {
                            'admin' => 'bg-danger',
                            'manager' => 'bg-primary',
                            'cashier' => 'bg-success',
                            'stock_keeper' => 'bg-info',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $roleClass ?>"><?= $roleName ?></span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                    <?php if (User::hasRole(ROLE_ADMIN) && $user['id'] != $_SESSION['user_id']): ?>
                    <td>
                        <a href="<?= BASE_URL ?>users/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= BASE_URL ?>users/delete/<?= $user['id'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Xóa nhân viên này?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <?php elseif (User::hasRole(ROLE_ADMIN)): ?>
                    <td><span class="text-muted">(Bạn)</span></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
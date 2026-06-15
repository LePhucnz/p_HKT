<?php
require_once 'app/models/User.php';

class UserController {

    private function checkAdmin() {
        User::requireLogin();
        if (!User::hasRole([ROLE_ADMIN]))
            die('<div class="alert alert-danger m-4">Chỉ Admin mới có quyền quản lý người dùng!</div>');
    }

    public function index() {
        $this->checkAdmin();
        $db    = Database::getConnection();
        $users = $db->query("SELECT * FROM users ORDER BY id ASC")->fetchAll();
        $title = 'Quản lý người dùng';
        require_once 'app/views/users/index.php';
    }

    public function create() {
        $this->checkAdmin();
        $title = 'Thêm người dùng';
        require_once 'app/views/users/create.php';
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'user'); exit;
        }
        $ho_ten   = trim($_POST['ho_ten'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['mat_khau'] ?? '';
        $vai_tro  = $_POST['vai_tro'] ?? 'cashier';

        if (empty($ho_ten) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            header('Location: ' . BASE_URL . 'user/create'); exit;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email đã tồn tại!';
            header('Location: ' . BASE_URL . 'user/create'); exit;
        }

        $data = [
            'ho_ten'   => $ho_ten,
            'email'    => $email,
            'mat_khau' => password_hash($password, PASSWORD_BCRYPT),
            'vai_tro'  => $vai_tro,
        ];
        if ($userModel->create($data)) {
            $_SESSION['success'] = 'Thêm người dùng thành công!';
        } else {
            $_SESSION['error'] = 'Thêm thất bại!';
        }
        header('Location: ' . BASE_URL . 'user'); exit;
    }

    public function edit($id) {
        $this->checkAdmin();
        $db   = Database::getConnection();
        $user = $db->prepare("SELECT * FROM users WHERE id=:id");
        $user->execute(['id' => $id]);
        $user = $user->fetch();
        if (!$user) die('Không tìm thấy người dùng!');
        $title = 'Sửa người dùng';
        require_once 'app/views/users/edit.php';
    }

    public function update($id) {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'user'); exit;
        }
        $db      = Database::getConnection();
        $ho_ten  = trim($_POST['ho_ten'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $vai_tro = $_POST['vai_tro'] ?? 'cashier';
        $pw      = $_POST['mat_khau'] ?? '';

        if ($pw) {
            $db->prepare("UPDATE users SET ho_ten=:n, email=:e, vai_tro=:v, mat_khau=:p WHERE id=:id")
               ->execute(['n'=>$ho_ten,'e'=>$email,'v'=>$vai_tro,'p'=>password_hash($pw, PASSWORD_BCRYPT),'id'=>$id]);
        } else {
            $db->prepare("UPDATE users SET ho_ten=:n, email=:e, vai_tro=:v WHERE id=:id")
               ->execute(['n'=>$ho_ten,'e'=>$email,'v'=>$vai_tro,'id'=>$id]);
        }
        $_SESSION['success'] = 'Cập nhật người dùng thành công!';
        header('Location: ' . BASE_URL . 'user'); exit;
    }

    public function destroy($id) {
        $this->checkAdmin();
        // Khong cho xoa chinh minh
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không thể xóa tài khoản đang đăng nhập!';
            header('Location: ' . BASE_URL . 'user'); exit;
        }
        $db = Database::getConnection();
        $db->prepare("DELETE FROM users WHERE id=:id")->execute(['id' => $id]);
        $_SESSION['success'] = 'Đã xóa người dùng!';
        header('Location: ' . BASE_URL . 'user'); exit;
    }
}

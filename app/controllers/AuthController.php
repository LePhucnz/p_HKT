<?php
require_once 'app/models/User.php';

class AuthController {

    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'dashboard'); exit;
        }
        $title = 'Đăng nhập';
        require_once 'app/views/auth/login.php';
    }

    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/login'); exit;
        }
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['mat_khau'] ?? '';

        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['mat_khau'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['ho_ten']  = $user['ho_ten'];
            $_SESSION['vai_tro'] = $user['vai_tro'];
            header('Location: ' . BASE_URL . 'dashboard');
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
            header('Location: ' . BASE_URL . 'auth/login');
        }
        exit;
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'dashboard'); exit;
        }
        $title = 'Đăng ký';
        require_once 'app/views/auth/register.php';
    }

    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/register'); exit;
        }
        $ho_ten    = trim($_POST['ho_ten'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['mat_khau'] ?? '';
        $password2 = $_POST['mat_khau2'] ?? '';

        if (empty($ho_ten) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin!';
            header('Location: ' . BASE_URL . 'auth/register'); exit;
        }
        if ($password !== $password2) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            header('Location: ' . BASE_URL . 'auth/register'); exit;
        }
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải ít nhất 6 ký tự!';
            header('Location: ' . BASE_URL . 'auth/register'); exit;
        }

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email đã được sử dụng!';
            header('Location: ' . BASE_URL . 'auth/register'); exit;
        }

        $data = [
            'ho_ten'   => $ho_ten,
            'email'    => $email,
            'mat_khau' => password_hash($password, PASSWORD_BCRYPT),
            'vai_tro'  => 'cashier',
        ];
        if ($userModel->create($data)) {
            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
            header('Location: ' . BASE_URL . 'auth/login');
        } else {
            $_SESSION['error'] = 'Đăng ký thất bại!';
            header('Location: ' . BASE_URL . 'auth/register');
        }
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}

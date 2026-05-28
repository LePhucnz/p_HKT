<?php
require_once 'config/database.php';

class AuthController {

    // Hiển thị form đăng nhập
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header('Location: ?page=home');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $mat_khau = $_POST['mat_khau'];

            global $pdo;
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($mat_khau, $user['mat_khau'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['ho_ten'] = $user['ho_ten'];
                $_SESSION['vai_tro'] = $user['vai_tro'];
                header('Location: ?page=home');
                exit;
            } else {
                $error = 'Email hoặc mật khẩu không đúng!';
            }
        }

        $title = 'Đăng nhập';
        require_once 'app/views/auth/login.php';
    }

    // Hiển thị form đăng ký
    public function register() {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ho_ten = trim($_POST['ho_ten']);
            $email = trim($_POST['email']);
            $mat_khau = $_POST['mat_khau'];
            $xac_nhan = $_POST['xac_nhan_mat_khau'];

            if (empty($ho_ten) || empty($email) || empty($mat_khau)) {
                $error = 'Vui lòng điền đầy đủ thông tin!';
            } elseif ($mat_khau !== $xac_nhan) {
                $error = 'Mật khẩu xác nhận không khớp!';
            } elseif (strlen($mat_khau) < 6) {
                $error = 'Mật khẩu phải ít nhất 6 ký tự!';
            } else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);

                if ($stmt->rowCount() > 0) {
                    $error = 'Email đã được sử dụng!';
                } else {
                    $hash = password_hash($mat_khau, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (ho_ten, email, mat_khau) VALUES (?, ?, ?)");
                    $stmt->execute([$ho_ten, $email, $hash]);
                    $success = 'Đăng ký thành công!';
                }
            }
        }

        $title = 'Đăng ký';
        require_once 'app/views/auth/register.php';
    }

    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: ?page=auth&action=login');
        exit;
    }
}
?>
<?php
// app/controllers/AuthController.php
require_once 'app/models/User.php';

class AuthController {
    
    public function login() {
        // Nếu đã đăng nhập thì chuyển về dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }
        
        // Hiển thị form login
        if (file_exists('app/views/auth/login.php')) {
            require_once 'app/views/auth/login.php';
        } else {
            echo "File view không tồn tại: app/views/auth/login.php";
            echo "<br>Đang tạo view mặc định...";
            $this->showDefaultLogin();
        }
    }
    
    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['mat_khau'] ?? '';
        
        $userModel = new User();
        $user = $userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['mat_khau'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['ho_ten'] = $user['ho_ten'];
            $_SESSION['vai_tro'] = $user['vai_tro'];
            
            header('Location: ' . BASE_URL . 'dashboard');
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
            header('Location: ' . BASE_URL . 'auth/login');
        }
        exit;
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL);
        exit;
    }
    
    private function showDefaultLogin() {
        ?>
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <title>Đăng nhập - P_HKT Shop</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>P_HKT Shop</h4>
                            <small>Đăng nhập hệ thống</small>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger"><?= $_SESSION['error'] ?><?php unset($_SESSION['error']); ?></div>
                            <?php endif; ?>
                            <form method="POST" action="<?= BASE_URL ?>auth/doLogin">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="mat_khau" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}
>>>>>>> master

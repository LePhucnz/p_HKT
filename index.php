<?php
session_start();

// Router đơn giản
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'home':
        require_once 'app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'auth':
        require_once 'app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->$action();
        break;

    case 'san_pham':
        require_once 'app/controllers/SanPhamController.php';
        $controller = new SanPhamController();
        $controller->$action();
        break;

    case 'hoa_don':
        require_once 'app/controllers/HoaDonController.php';
        $controller = new HoaDonController();
        $controller->$action();
        break;

    default:
        http_response_code(404);
        echo "Trang không tồn tại!";
}
?>
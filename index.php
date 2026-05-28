<?php
session_start();

$page   = $_GET['page']   ?? 'home';
$action = $_GET['action'] ?? 'index';

switch ($page) {
    case 'home':
        require_once 'app/controllers/HomeController.php';
        (new HomeController())->index();
        break;

    case 'auth':
        require_once 'app/controllers/AuthController.php';
        $ctrl = new AuthController();
        $ctrl->$action();
        break;

    case 'san_pham':
        require_once 'app/controllers/SanPhamController.php';
        $ctrl = new SanPhamController();
        $ctrl->$action();
        break;

    case 'hoa_don':
        require_once 'app/controllers/HoaDonController.php';
        $ctrl = new HoaDonController();
        $ctrl->$action();
        break;

    case 'khach_hang':
        require_once 'app/controllers/KhachHangController.php';
        $ctrl = new KhachHangController();
        $ctrl->$action();
        break;

    case 'nhap_kho':
        require_once 'app/controllers/NhapKhoController.php';
        $ctrl = new NhapKhoController();
        $ctrl->$action();
        break;

    case 'bao_cao':
        require_once 'app/controllers/BaoCaoController.php';
        $ctrl = new BaoCaoController();
        $ctrl->index();
        break;

    default:
        http_response_code(404);
        echo "<h2>404 - Trang không tồn tại</h2>";
}

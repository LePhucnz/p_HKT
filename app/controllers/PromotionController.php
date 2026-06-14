<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Promotion.php';

class PromotionController {

    private function check() {
        User::requireLogin();
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER]))
            die('Bạn không có quyền quản lý khuyến mãi!');
    }

    public function index() {
        $this->check();
        $promotions = (new Promotion())->all();
        require_once 'app/views/promotions/index.php';
    }

    public function create() {
        $this->check();
        require_once 'app/views/promotions/create.php';
    }

    public function store() {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . 'promotions'); exit; }
        $loai   = $_POST['loai_km'] ?? '';
        $giatri = floatval($_POST['gia_tri'] ?? 0);
        if ($loai === 'percent' && $giatri > 100) {
            $_SESSION['error'] = 'Giảm giá % không được vượt quá 100!';
            header('Location: ' . BASE_URL . 'promotions/create'); exit;
        }
        $data = [
            'ten_km'        => trim($_POST['ten_km'] ?? ''),
            'mo_ta'         => trim($_POST['mo_ta'] ?? ''),
            'loai_km'       => $loai,
            'gia_tri'       => $giatri,
            'ngay_bat_dau'  => $_POST['ngay_bat_dau'],
            'ngay_ket_thuc' => $_POST['ngay_ket_thuc'],
            'trang_thai'    => 1,
        ];
        $model = new Promotion();
        $_SESSION[$model->create($data) ? 'success' : 'error'] = $model->create($data) ? 'Thêm khuyến mãi thành công!' : 'Thêm thất bại!';
        header('Location: ' . BASE_URL . 'promotions'); exit;
    }

    public function toggleStatus($id) {
        $this->check();
        $model = new Promotion();
        $promo = $model->find($id);
        if ($promo) {
            $newStatus = $promo['trang_thai'] ? 0 : 1;
            $model->updateStatus($id, $newStatus);
            $_SESSION['success'] = $newStatus ? 'Đã kích hoạt' : 'Đã tắt';
        }
        header('Location: ' . BASE_URL . 'promotions'); exit;
    }

    public function destroy($id) {
        $this->check();
        $model = new Promotion();
        $_SESSION[$model->delete($id) ? 'success' : 'error'] = $model->delete($id) ? 'Xóa thành công!' : 'Xóa thất bại!';
        header('Location: ' . BASE_URL . 'promotions'); exit;
    }
}

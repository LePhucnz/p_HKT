<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/PurchaseOrder.php';
require_once __DIR__ . '/../models/PurchaseOrderDetail.php';

class PurchaseOrderController {

    private function check() {
        User::requireLogin();
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER, ROLE_STOCK_KEEPER]))
            die('Bạn không có quyền nhập kho!');
    }

    public function index() {
        $this->check();
        $db     = Database::getConnection();
        $orders = $db->query(
            "SELECT p.*, u.ho_ten as ten_nv FROM phieu_nhap_kho p
             LEFT JOIN users u ON p.nhan_vien_id = u.id ORDER BY p.id DESC"
        )->fetchAll();
        require_once 'app/views/purchase/index.php';
    }

    public function create() {
        $this->check();
        $products = (new Product())->all();
        require_once 'app/views/purchase/create.php';
    }

    public function store() {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'purchaseOrder/create'); exit;
        }
        $supplier   = trim($_POST['nha_cung_cap'] ?? '');
        $productIds = $_POST['product_id'] ?? [];
        $quantities = $_POST['quantity']   ?? [];
        $prices     = $_POST['price']      ?? [];

        $items = [];
        foreach ($productIds as $i => $pid) {
            if (!empty($pid) && ($quantities[$i] ?? 0) > 0) {
                $items[] = [
                    'product_id' => $pid,
                    'quantity'   => intval($quantities[$i]),
                    'price'      => floatval($prices[$i] ?? 0),
                ];
            }
        }
        if (empty($items)) {
            $_SESSION['error'] = 'Vui lòng thêm ít nhất một sản phẩm!';
            header('Location: ' . BASE_URL . 'purchaseOrder/create'); exit;
        }
        try {
            (new PurchaseOrder())->createOrder($supplier, $_SESSION['user_id'], $items);
            $_SESSION['success'] = 'Nhập kho thành công!';
            header('Location: ' . BASE_URL . 'dashboard');
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'purchaseOrder/create');
        }
        exit;
    }
}

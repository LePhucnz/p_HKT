<?php
// app/controllers/InvoiceController.php
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
require_once 'app/models/Customer.php';
require_once 'app/models/Invoice.php';
require_once 'app/models/InvoiceDetail.php';

class InvoiceController {
    
    private function checkPermission() {
        if (!User::isLoggedIn()) {
            header('Location: ' . BASE_URL);
            exit;
        }
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER, ROLE_CASHIER])) {
            die('Bạn không có quyền truy cập chức năng này!');
        }
    }
    
    // Hiển thị form bán hàng
    public function create() {
        $this->checkPermission();
        
        $productModel = new Product();
        $customerModel = new Customer();
        
        $products = $productModel->getInStock();
        $customers = $customerModel->all();
        
        // Lấy giỏ hàng từ session
        $cart = $_SESSION['cart'] ?? [];
        
        require_once 'app/views/invoices/create.php';
    }
    
    // Thêm sản phẩm vào giỏ hàng (AJAX)
    public function addToCart() {
        $this->checkPermission();
        
        $productId = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        
        $productModel = new Product();
        $product = $productModel->find($productId);
        
        if (!$product) {
            echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
            exit;
        }
        
        if ($product['so_luong_ton'] < $quantity) {
            echo json_encode(['success' => false, 'message' => 'Số lượng tồn kho không đủ']);
            exit;
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $product['ten_sp'],
                'price' => $product['gia_ban'],
                'quantity' => $quantity,
                'stock' => $product['so_luong_ton']
            ];
        }
        
        echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);
        exit;
    }
    
    // Xóa sản phẩm khỏi giỏ
    public function removeFromCart($productId) {
        $this->checkPermission();
        
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        
        header('Location: ' . BASE_URL . 'invoices/create');
        exit;
    }
    
    // Thanh toán - Lưu hóa đơn
    public function store() {
        $this->checkPermission();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'invoices/create');
            exit;
        }
        
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = 'Giỏ hàng trống!';
            header('Location: ' . BASE_URL . 'invoices/create');
            exit;
        }
        
        $customerId = $_POST['khach_hang_id'] ?: null;
        $paymentMethod = $_POST['phuong_thuc_tt'];
        $discount = (float)$_POST['giam_gia'];
        
        $invoiceModel = new Invoice();
        
        try {
            $invoiceId = $invoiceModel->createInvoice(
                $customerId,
                $_SESSION['user_id'],
                $paymentMethod,
                $cart,
                $discount
            );
            
            // Xóa giỏ hàng
            unset($_SESSION['cart']);
            
            $_SESSION['success'] = 'Tạo hóa đơn thành công!';
            header('Location: ' . BASE_URL . 'invoices/show/' . $invoiceId);
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            header('Location: ' . BASE_URL . 'invoices/create');
        }
        exit;
    }
    
    // Xem chi tiết hóa đơn
    public function show($id) {
        $this->checkPermission();
        
        $invoiceModel = new Invoice();
        $invoice = $invoiceModel->getInvoiceWithDetails($id);
        
        if (!$invoice) {
            die('Không tìm thấy hóa đơn');
        }
        
        require_once 'app/views/invoices/show.php';
    }
    
    // Danh sách hóa đơn
    public function index() {
        $this->checkPermission();
        
        $invoiceModel = new Invoice();
        $invoices = $invoiceModel->getAllWithCustomer();
        
        require_once 'app/views/invoices/index.php';
    }

    // Xoa toan bo gio hang
    public function clearCart() {
        $this->checkPermission();
        unset($_SESSION['cart']);
        header('Location: ' . BASE_URL . 'invoices/create');
        exit;
    }
}
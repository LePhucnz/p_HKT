<?php
// app/controllers/ProductController.php
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
require_once 'app/models/Category.php';

class ProductController {
    
    private function checkLogin() {
        if (!User::isLoggedIn()) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    private function checkAdminPermission() {
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER])) {
            die('Bạn không có quyền thực hiện chức năng này!');
        }
    }
    
    // Danh sách sản phẩm
    public function index() {
        $this->checkLogin();
        
        $productModel = new Product();
        $keyword = $_GET['search'] ?? '';
        
        if ($keyword) {
            $products = $productModel->search($keyword);
        } else {
            $products = $productModel->getAllWithCategory();
        }
        
        require_once 'app/views/products/index.php';
    }
    
    // Form thêm sản phẩm
    public function create() {
        $this->checkLogin();
        $this->checkAdminPermission();
        
        $categoryModel = new Category();
        $categories = $categoryModel->all();
        
        require_once 'app/views/products/create.php';
    }
    
    // Lưu sản phẩm mới
    public function store() {
        $this->checkLogin();
        $this->checkAdminPermission();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'products');
            exit;
        }
        
        $productModel = new Product();
        $data = [
            'ma_sp' => 'SP' . time(),
            'ten_sp' => $_POST['ten_sp'],
            'danh_muc_id' => $_POST['danh_muc_id'] ?: null,
            'don_vi_tinh' => $_POST['don_vi_tinh'] ?? 'cái',
            'gia_ban' => $_POST['gia_ban'],
            'so_luong_ton' => $_POST['so_luong_ton'] ?? 0,
            'mo_ta' => $_POST['mo_ta']
        ];
        
        if ($productModel->create($data)) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Thêm sản phẩm thất bại!';
        }
        
        header('Location: ' . BASE_URL . 'products');
        exit;
    }
    
    // Form sửa sản phẩm
    public function edit($id) {
        $this->checkLogin();
        $this->checkAdminPermission();
        
        $productModel = new Product();
        $categoryModel = new Category();
        
        $product = $productModel->find($id);
        $categories = $categoryModel->all();
        
        if (!$product) {
            die('Không tìm thấy sản phẩm');
        }
        
        require_once 'app/views/products/edit.php';
    }
    
    // Cập nhật sản phẩm
    public function update($id) {
        $this->checkLogin();
        $this->checkAdminPermission();
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'products');
            exit;
        }
        
        $productModel = new Product();
        $data = [
            'ten_sp' => $_POST['ten_sp'],
            'danh_muc_id' => $_POST['danh_muc_id'] ?: null,
            'don_vi_tinh' => $_POST['don_vi_tinh'],
            'gia_ban' => $_POST['gia_ban'],
            'mo_ta' => $_POST['mo_ta']
        ];
        
        if ($productModel->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật thành công!';
        } else {
            $_SESSION['error'] = 'Cập nhật thất bại!';
        }
        
        header('Location: ' . BASE_URL . 'products');
        exit;
    }
    
    // Xóa sản phẩm
    public function destroy($id) {
        $this->checkLogin();
        $this->checkAdminPermission();
        
        $productModel = new Product();
        
        if ($productModel->delete($id)) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Xóa sản phẩm thất bại!';
        }
        
        header('Location: ' . BASE_URL . 'products');
        exit;
    }
}
<?php
require_once 'app/models/User.php';
require_once 'app/models/Product.php';
require_once 'app/models/Category.php';

class ProductController {

    private function check() { User::requireLogin(); }

    private function checkAdmin() {
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER]))
            die('<div class="alert alert-danger m-4">Bạn không có quyền thực hiện chức năng này!</div>');
    }

    // Ham xu ly upload anh
    private function uploadImage($file, $oldImage = null) {
        if (empty($file['name'])) return $oldImage; // Khong upload anh moi

        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $_SESSION['error'] = 'Chỉ chấp nhận file ảnh JPG, PNG, GIF, WEBP!';
            return $oldImage;
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            $_SESSION['error'] = 'Ảnh không được vượt quá 2MB!';
            return $oldImage;
        }

        $uploadDir = 'public/uploads/products/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $fileName = 'SP_' . time() . '_' . rand(100,999) . '.' . $ext;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Xoa anh cu neu co
            if ($oldImage && file_exists($oldImage)) unlink($oldImage);
            return $uploadPath;
        }
        return $oldImage;
    }

    public function index() {
        $this->check();
        $model   = new Product();
        $keyword = $_GET['search'] ?? '';
        $products = $keyword ? $model->search($keyword) : $model->getAllWithCategory();
        $title = 'Sản phẩm';
        require_once 'app/views/products/index.php';
    }

    public function create() {
        $this->check();
        $this->checkAdmin();
        $categories = (new Category())->all();
        $title = 'Thêm sản phẩm';
        require_once 'app/views/products/create.php';
    }

    public function store() {
        $this->check();
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'product'); exit;
        }

        $hinh_anh = $this->uploadImage($_FILES['hinh_anh'] ?? []);

        $data = [
            'ma_sp'        => 'SP' . time(),
            'ten_sp'       => trim($_POST['ten_sp']),
            'danh_muc_id'  => $_POST['danh_muc_id'] ?: null,
            'don_vi_tinh'  => trim($_POST['don_vi_tinh'] ?? 'cái'),
            'gia_ban'      => floatval($_POST['gia_ban']),
            'so_luong_ton' => intval($_POST['so_luong_ton'] ?? 0),
            'mo_ta'        => trim($_POST['mo_ta'] ?? ''),
            'hinh_anh'     => $hinh_anh,
        ];

        if (empty($data['ten_sp'])) {
            $_SESSION['error'] = 'Tên sản phẩm không được trống!';
            header('Location: ' . BASE_URL . 'product/create'); exit;
        }

        $model = new Product();
        if ($model->create($data)) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Thêm sản phẩm thất bại!';
        }
        header('Location: ' . BASE_URL . 'product'); exit;
    }

    public function edit($id) {
        $this->check();
        $this->checkAdmin();
        $product    = (new Product())->find($id);
        $categories = (new Category())->all();
        if (!$product) die('Không tìm thấy sản phẩm!');
        $title = 'Sửa sản phẩm';
        require_once 'app/views/products/edit.php';
    }

    public function update($id) {
        $this->check();
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'product'); exit;
        }

        $model      = new Product();
        $product    = $model->find($id);
        $hinh_anh   = $this->uploadImage($_FILES['hinh_anh'] ?? [], $product['hinh_anh'] ?? null);

        $data = [
            'ten_sp'      => trim($_POST['ten_sp']),
            'danh_muc_id' => $_POST['danh_muc_id'] ?: null,
            'don_vi_tinh' => trim($_POST['don_vi_tinh'] ?? 'cái'),
            'gia_ban'     => floatval($_POST['gia_ban']),
            'mo_ta'       => trim($_POST['mo_ta'] ?? ''),
            'hinh_anh'    => $hinh_anh,
        ];

        if ($model->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật thành công!';
        } else {
            $_SESSION['error'] = 'Cập nhật thất bại!';
        }
        header('Location: ' . BASE_URL . 'product'); exit;
    }

    public function destroy($id) {
        $this->check();
        $this->checkAdmin();
        $model   = new Product();
        $product = $model->find($id);

        if ($model->delete($id)) {
            // Xoa anh neu co
            if (!empty($product['hinh_anh']) && file_exists($product['hinh_anh'])) {
                unlink($product['hinh_anh']);
            }
            $_SESSION['success'] = 'Xóa sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Xóa sản phẩm thất bại!';
        }
        header('Location: ' . BASE_URL . 'product'); exit;
    }
}

<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryController {

    private function check() { User::requireLogin(); }

    public function index() {
        $this->check();
        $db = Database::getConnection();
        $categories = $db->query(
            "SELECT d.*, COUNT(s.id) as product_count
             FROM danh_muc d
             LEFT JOIN san_pham s ON s.danh_muc_id = d.id
             GROUP BY d.id ORDER BY d.id ASC"
        )->fetchAll();
        $title = 'Danh mục';
        require_once 'app/views/categories/index.php';
    }

    public function create() {
        $this->check();
        $title = 'Thêm danh mục';
        require_once 'app/views/categories/create.php';
    }

    public function store() {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . 'categories'); exit; }
        $data = [
            'ten_danh_muc' => trim($_POST['ten_danh_muc'] ?? ''),
            'mo_ta'        => trim($_POST['mo_ta'] ?? ''),
        ];
        if (empty($data['ten_danh_muc'])) {
            $_SESSION['error'] = 'Tên danh mục không được trống!';
            header('Location: ' . BASE_URL . 'categories/create'); exit;
        }
        $model = new Category();
        $_SESSION[$model->create($data) ? 'success' : 'error'] = $model->create($data) ? 'Thêm danh mục thành công!' : 'Thêm danh mục thất bại!';
        header('Location: ' . BASE_URL . 'categories'); exit;
    }

    public function edit($id) {
        $this->check();
        $category = (new Category())->find($id);
        if (!$category) die('Không tìm thấy danh mục!');
        $title = 'Sửa danh mục';
        require_once 'app/views/categories/edit.php';
    }

    public function update($id) {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . 'categories'); exit; }
        $model = new Category();
        $data = [
            'ten_danh_muc' => trim($_POST['ten_danh_muc'] ?? ''),
            'mo_ta'        => trim($_POST['mo_ta'] ?? ''),
        ];
        if ($model->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Cập nhật thất bại!';
        }
        header('Location: ' . BASE_URL . 'categories'); exit;
    }

    public function destroy($id) {
        $this->check();
        $model = new Category();
        if ($model->hasProducts($id)) {
            $_SESSION['error'] = 'Không thể xóa danh mục đang có sản phẩm!';
        } elseif ($model->delete($id)) {
            $_SESSION['success'] = 'Xóa danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại!';
        }
        header('Location: ' . BASE_URL . 'categories'); exit;
    }
}

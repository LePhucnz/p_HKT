<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Customer.php';

class CustomerController {

    private function check() { User::requireLogin(); }

    public function index() {
        $this->check();
        $model    = new Customer();
        $search   = $_GET['search'] ?? '';
        $hang     = $_GET['hang_thanh_vien'] ?? '';
        $customers = $search ? $model->search($search)
                   : ($hang  ? $model->filterByRank($hang) : $model->all());
        $title = 'Khách hàng';
        require_once 'app/views/customers/index.php';
    }

    public function create() {
        $this->check();
        $title = 'Thêm khách hàng';
        require_once 'app/views/customers/create.php';
    }

    public function store() {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'customer'); exit;
        }
        $ho_ten = trim($_POST['ho_ten'] ?? '');
        $sdt    = trim($_POST['so_dien_thoai'] ?? '');
        if (empty($ho_ten) || empty($sdt)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ họ tên và số điện thoại!';
            header('Location: ' . BASE_URL . 'customer/create'); exit;
        }
        $data = [
            'ho_ten'        => $ho_ten,
            'so_dien_thoai' => $sdt,
            'email'         => trim($_POST['email'] ?? ''),
            'ngay_sinh'     => $_POST['ngay_sinh'] ?: null,
            'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
            'gioi_tinh'     => $_POST['gioi_tinh'] ?? '',
        ];
        $model = new Customer();
        if ($model->create($data)) {
            $_SESSION['success'] = 'Thêm khách hàng thành công!';
        } else {
            $_SESSION['error'] = 'Thêm khách hàng thất bại!';
        }
        header('Location: ' . BASE_URL . 'customer'); exit;
    }

    public function show($id) {
        $this->check();
        $model    = new Customer();
        $customer = $model->find($id);
        if (!$customer) die('Không tìm thấy khách hàng!');
        $invoices   = $model->getInvoices($id);
        $totalSpent = $model->getTotalSpent($id);
        $history    = $model->getPointHistory($id);
        $title = 'Chi tiết: ' . $customer['ho_ten'];
        require_once 'app/views/customers/show.php';
    }

    public function edit($id) {
        $this->check();
        $customer = (new Customer())->find($id);
        if (!$customer) die('Không tìm thấy!');
        $title = 'Sửa khách hàng';
        require_once 'app/views/customers/edit.php';
    }

    public function update($id) {
        $this->check();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'customer'); exit;
        }
        $data = [
            'ho_ten'        => trim($_POST['ho_ten'] ?? ''),
            'so_dien_thoai' => trim($_POST['so_dien_thoai'] ?? ''),
            'email'         => trim($_POST['email'] ?? ''),
            'ngay_sinh'     => $_POST['ngay_sinh'] ?: null,
            'dia_chi'       => trim($_POST['dia_chi'] ?? ''),
            'gioi_tinh'     => $_POST['gioi_tinh'] ?? '',
        ];
        $model = new Customer();
        if ($model->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật thành công!';
        } else {
            $_SESSION['error'] = 'Cập nhật thất bại!';
        }
        header('Location: ' . BASE_URL . 'customer'); exit;
    }

    public function destroy($id) {
        $this->check();
        $model = new Customer();
        if ($model->hasInvoices($id)) {
            $_SESSION['error'] = 'Không thể xóa khách hàng đã có hóa đơn!';
        } elseif ($model->delete($id)) {
            $_SESSION['success'] = 'Xóa khách hàng thành công!';
        } else {
            $_SESSION['error'] = 'Xóa thất bại!';
        }
        header('Location: ' . BASE_URL . 'customer'); exit;
    }
}

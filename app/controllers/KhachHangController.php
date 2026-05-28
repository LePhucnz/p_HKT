<?php
require_once 'config/database.php';

class KhachHangController {
    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) { header('Location: ?page=auth&action=login'); exit; }
    }

    public function index() {
        $this->checkLogin();
        global $pdo;
        $search = $_GET['search'] ?? '';
        $page = max(1, intval($_GET['p'] ?? 1));
        $per_page = 15;
        $offset = ($page - 1) * $per_page;

        $where = "WHERE 1=1";
        $params = [];
        if ($search) { $where .= " AND (ho_ten LIKE ? OR so_dien_thoai LIKE ? OR ma_kh LIKE ?)"; $params = ["%$search%","%$search%","%$search%"]; }

        $total = $pdo->prepare("SELECT COUNT(*) FROM khach_hang $where");
        $total->execute($params);
        $total = $total->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM khach_hang $where ORDER BY id DESC LIMIT $per_page OFFSET $offset");
        $stmt->execute($params);
        $khach_hangs = $stmt->fetchAll();
        $total_pages = ceil($total / $per_page);

        $title = 'Khách hàng';
        require_once 'app/views/khach_hang/index.php';
    }

    public function them() {
        $this->checkLogin();
        global $pdo;
        $error = ''; $success = '';
        $khach_hang = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ma_kh = 'KH' . date('ymd') . sprintf('%03d', rand(1,999));
            $stmt = $pdo->prepare("INSERT INTO khach_hang (ma_kh,ho_ten,so_dien_thoai,dia_chi,email,ngay_sinh,gioi_tinh,ngay_dang_ky,ghi_chu) VALUES (?,?,?,?,?,?,?,CURDATE(),?)");
            try {
                $stmt->execute([$ma_kh,$_POST['ho_ten'],$_POST['so_dien_thoai'],$_POST['dia_chi'],$_POST['email'],$_POST['ngay_sinh']?:null,$_POST['gioi_tinh'],$_POST['ghi_chu']]);
                header('Location: ?page=khach_hang&success=them'); exit;
            } catch (Exception $e) { $error = 'Lỗi: ' . $e->getMessage(); }
        }

        $title = 'Thêm khách hàng';
        require_once 'app/views/khach_hang/form.php';
    }

    public function sua() {
        $this->checkLogin();
        global $pdo;
        $id = intval($_GET['id'] ?? 0);
        $khach_hang = $pdo->prepare("SELECT * FROM khach_hang WHERE id=?");
        $khach_hang->execute([$id]);
        $khach_hang = $khach_hang->fetch();
        if (!$khach_hang) { echo "Không tìm thấy!"; return; }
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo->prepare("UPDATE khach_hang SET ho_ten=?,so_dien_thoai=?,dia_chi=?,email=?,ngay_sinh=?,gioi_tinh=?,ghi_chu=? WHERE id=?")
                ->execute([$_POST['ho_ten'],$_POST['so_dien_thoai'],$_POST['dia_chi'],$_POST['email'],$_POST['ngay_sinh']?:null,$_POST['gioi_tinh'],$_POST['ghi_chu'],$id]);
            header('Location: ?page=khach_hang&success=sua'); exit;
        }

        $title = 'Sửa khách hàng';
        require_once 'app/views/khach_hang/form.php';
    }
}

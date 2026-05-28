<?php
require_once 'config/database.php';

class SanPhamController {

    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=auth&action=login'); exit;
        }
    }

    // Danh sach san pham
    public function index() {
        $this->checkLogin();
        global $pdo;

        $search = $_GET['search'] ?? '';
        $danh_muc_id = $_GET['danh_muc_id'] ?? '';
        $page = max(1, intval($_GET['p'] ?? 1));
        $per_page = 15;
        $offset = ($page - 1) * $per_page;

        $where = "WHERE 1=1";
        $params = [];
        if ($search) { $where .= " AND (ten_sp LIKE ? OR ma_sp LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }
        if ($danh_muc_id) { $where .= " AND danh_muc_id=?"; $params[] = $danh_muc_id; }

        $total = $pdo->prepare("SELECT COUNT(*) FROM san_pham $where");
        $total->execute($params);
        $total = $total->fetchColumn();

        $stmt = $pdo->prepare("SELECT s.*, d.ten_danh_muc FROM san_pham s LEFT JOIN danh_muc d ON s.danh_muc_id=d.id $where ORDER BY s.id DESC LIMIT $per_page OFFSET $offset");
        $stmt->execute($params);
        $san_phams = $stmt->fetchAll();

        $danh_mucs = $pdo->query("SELECT * FROM danh_muc ORDER BY ten_danh_muc")->fetchAll();
        $total_pages = ceil($total / $per_page);

        $title = 'Danh sách sản phẩm';
        require_once 'app/views/san_pham/index.php';
    }

    // Chi tiet san pham
    public function chi_tiet() {
        $this->checkLogin();
        global $pdo;
        $id = intval($_GET['id'] ?? 0);
        $san_pham = $pdo->prepare("SELECT s.*, d.ten_danh_muc FROM san_pham s LEFT JOIN danh_muc d ON s.danh_muc_id=d.id WHERE s.id=?");
        $san_pham->execute([$id]);
        $san_pham = $san_pham->fetch();
        if (!$san_pham) { echo "Không tìm thấy sản phẩm!"; return; }

        // Lich su giao dich
        $lich_su = $pdo->prepare("SELECT ct.*, h.so_hd, h.ngay_lap FROM chi_tiet_hoa_don ct JOIN hoa_don h ON ct.hoa_don_id=h.id WHERE ct.san_pham_id=? ORDER BY h.ngay_lap DESC LIMIT 10");
        $lich_su->execute([$id]);
        $lich_su = $lich_su->fetchAll();

        $title = 'Chi tiết: ' . $san_pham['ten_sp'];
        require_once 'app/views/san_pham/chi_tiet.php';
    }

    // Form them/sua
    public function them() {
        $this->checkLogin();
        global $pdo;
        $danh_mucs = $pdo->query("SELECT * FROM danh_muc ORDER BY ten_danh_muc")->fetchAll();
        $error = ''; $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'ma_sp'         => trim($_POST['ma_sp']),
                'ten_sp'        => trim($_POST['ten_sp']),
                'danh_muc_id'   => intval($_POST['danh_muc_id']) ?: null,
                'don_vi_tinh'   => trim($_POST['don_vi_tinh']),
                'gia_ban'       => floatval(str_replace(',','',$_POST['gia_ban'])),
                'so_luong_ton'  => intval($_POST['so_luong_ton']),
                'mo_ta'         => trim($_POST['mo_ta']),
            ];

            if (empty($data['ma_sp']) || empty($data['ten_sp'])) {
                $error = 'Mã và tên sản phẩm không được trống!';
            } else {
                // Kiem tra ma trung
                $check = $pdo->prepare("SELECT id FROM san_pham WHERE ma_sp=?");
                $check->execute([$data['ma_sp']]);
                if ($check->rowCount()) {
                    $error = 'Mã sản phẩm đã tồn tại!';
                } else {
                    $stmt = $pdo->prepare("INSERT INTO san_pham (ma_sp,ten_sp,danh_muc_id,don_vi_tinh,gia_ban,so_luong_ton,mo_ta) VALUES (?,?,?,?,?,?,?)");
                    $stmt->execute(array_values($data));
                    header('Location: ?page=san_pham&success=them');
                    exit;
                }
            }
        }

        $title = 'Thêm sản phẩm';
        $san_pham = null;
        require_once 'app/views/san_pham/form.php';
    }

    public function sua() {
        $this->checkLogin();
        global $pdo;
        $id = intval($_GET['id'] ?? 0);
        $danh_mucs = $pdo->query("SELECT * FROM danh_muc ORDER BY ten_danh_muc")->fetchAll();
        $error = '';

        $san_pham = $pdo->prepare("SELECT * FROM san_pham WHERE id=?");
        $san_pham->execute([$id]);
        $san_pham = $san_pham->fetch();
        if (!$san_pham) { echo "Không tìm thấy!"; return; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare("UPDATE san_pham SET ten_sp=?,danh_muc_id=?,don_vi_tinh=?,gia_ban=?,so_luong_ton=?,mo_ta=? WHERE id=?");
            $stmt->execute([
                trim($_POST['ten_sp']),
                intval($_POST['danh_muc_id']) ?: null,
                trim($_POST['don_vi_tinh']),
                floatval(str_replace(',','',$_POST['gia_ban'])),
                intval($_POST['so_luong_ton']),
                trim($_POST['mo_ta']),
                $id
            ]);
            header('Location: ?page=san_pham&success=sua');
            exit;
        }

        $title = 'Sửa sản phẩm';
        require_once 'app/views/san_pham/form.php';
    }

    public function xoa() {
        $this->checkLogin();
        global $pdo;
        $id = intval($_GET['id'] ?? 0);
        try {
            $pdo->prepare("DELETE FROM san_pham WHERE id=?")->execute([$id]);
            header('Location: ?page=san_pham&success=xoa');
        } catch (Exception $e) {
            header('Location: ?page=san_pham&error=xoa');
        }
        exit;
    }
}

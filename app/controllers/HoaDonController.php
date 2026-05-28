<?php
require_once 'config/database.php';

class HoaDonController {

    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) { header('Location: ?page=auth&action=login'); exit; }
    }

    // Danh sach hoa don
    public function index() {
        $this->checkLogin();
        global $pdo;
        $search = $_GET['search'] ?? '';
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');
        $page = max(1, intval($_GET['p'] ?? 1));
        $per_page = 15;
        $offset = ($page - 1) * $per_page;

        $where = "WHERE DATE(h.ngay_lap) BETWEEN ? AND ?";
        $params = [$tu_ngay, $den_ngay];
        if ($search) { $where .= " AND (h.so_hd LIKE ? OR k.ho_ten LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }

        $total = $pdo->prepare("SELECT COUNT(*) FROM hoa_don h LEFT JOIN khach_hang k ON h.khach_hang_id=k.id $where");
        $total->execute($params);
        $total = $total->fetchColumn();

        $stmt = $pdo->prepare("SELECT h.*, k.ho_ten as ten_kh, u.ho_ten as ten_nv FROM hoa_don h LEFT JOIN khach_hang k ON h.khach_hang_id=k.id LEFT JOIN users u ON h.nhan_vien_id=u.id $where ORDER BY h.ngay_lap DESC LIMIT $per_page OFFSET $offset");
        $stmt->execute($params);
        $hoa_dons = $stmt->fetchAll();

        $tong_doanh_thu = $pdo->prepare("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don h LEFT JOIN khach_hang k ON h.khach_hang_id=k.id $where");
        $tong_doanh_thu->execute($params);
        $tong_doanh_thu = $tong_doanh_thu->fetchColumn();

        $total_pages = ceil($total / $per_page);
        $title = 'Danh sách hóa đơn';
        require_once 'app/views/hoa_don/index.php';
    }

    // Tao hoa don moi
    public function tao_moi() {
        $this->checkLogin();
        global $pdo;
        $error = '';

        // Sinh so hoa don tu dong
        $so_hd = 'HD' . date('Ymd') . sprintf('%03d', rand(1, 999));

        $san_phams = $pdo->query("SELECT * FROM san_pham WHERE so_luong_ton > 0 ORDER BY ten_sp")->fetchAll();
        $khach_hangs = $pdo->query("SELECT * FROM khach_hang ORDER BY ho_ten")->fetchAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $items = $_POST['items'] ?? [];
            if (empty($items)) { $error = 'Vui lòng thêm ít nhất 1 sản phẩm!'; }
            else {
                $tong_tien = 0;
                $sp_data = [];
                foreach ($items as $item) {
                    if (empty($item['san_pham_id']) || $item['so_luong'] < 1) continue;
                    $sp = $pdo->prepare("SELECT * FROM san_pham WHERE id=?");
                    $sp->execute([$item['san_pham_id']]);
                    $sp = $sp->fetch();
                    if (!$sp) continue;
                    $don_gia = floatval($item['don_gia']);
                    $so_luong = intval($item['so_luong']);
                    $tong_tien += $don_gia * $so_luong;
                    $sp_data[] = ['sp' => $sp, 'so_luong' => $so_luong, 'don_gia' => $don_gia, 'thanh_tien' => $don_gia * $so_luong];
                }

                if (empty($sp_data)) { $error = 'Dữ liệu sản phẩm không hợp lệ!'; }
                else {
                    $giam_gia = floatval($_POST['giam_gia'] ?? 0);
                    $thanh_tien = $tong_tien - $giam_gia;
                    $khach_hang_id = intval($_POST['khach_hang_id']) ?: null;

                    $pdo->beginTransaction();
                    try {
                        // Tao hoa don
                        $stmt = $pdo->prepare("INSERT INTO hoa_don (so_hd, khach_hang_id, nhan_vien_id, phuong_thuc_tt, tong_tien, giam_gia, thanh_tien, ghi_chu) VALUES (?,?,?,?,?,?,?,?)");
                        $stmt->execute([$_POST['so_hd'], $khach_hang_id, $_SESSION['user_id'], $_POST['phuong_thuc_tt'], $tong_tien, $giam_gia, $thanh_tien, $_POST['ghi_chu']]);
                        $hd_id = $pdo->lastInsertId();

                        // Chi tiet + tru ton kho
                        foreach ($sp_data as $item) {
                            $pdo->prepare("INSERT INTO chi_tiet_hoa_don (hoa_don_id,san_pham_id,so_luong,don_gia,thanh_tien) VALUES (?,?,?,?,?)")
                                ->execute([$hd_id, $item['sp']['id'], $item['so_luong'], $item['don_gia'], $item['thanh_tien']]);
                            $pdo->prepare("UPDATE san_pham SET so_luong_ton=so_luong_ton-? WHERE id=?")
                                ->execute([$item['so_luong'], $item['sp']['id']]);
                        }
                        $pdo->commit();
                        header("Location: ?page=hoa_don&action=chi_tiet&id=$hd_id&success=1");
                        exit;
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        $error = 'Có lỗi xảy ra: ' . $e->getMessage();
                    }
                }
            }
        }

        $title = 'Tạo hóa đơn mới';
        require_once 'app/views/hoa_don/tao_moi.php';
    }

    // Chi tiet hoa don
    public function chi_tiet() {
        $this->checkLogin();
        global $pdo;
        $id = intval($_GET['id'] ?? 0);
        $hoa_don = $pdo->prepare("SELECT h.*, k.ho_ten as ten_kh, k.so_dien_thoai as sdt_kh, k.dia_chi, u.ho_ten as ten_nv FROM hoa_don h LEFT JOIN khach_hang k ON h.khach_hang_id=k.id LEFT JOIN users u ON h.nhan_vien_id=u.id WHERE h.id=?");
        $hoa_don->execute([$id]);
        $hoa_don = $hoa_don->fetch();
        if (!$hoa_don) { echo "Không tìm thấy hóa đơn!"; return; }

        $chi_tiet = $pdo->prepare("SELECT ct.*, s.ten_sp, s.ma_sp, s.don_vi_tinh FROM chi_tiet_hoa_don ct JOIN san_pham s ON ct.san_pham_id=s.id WHERE ct.hoa_don_id=?");
        $chi_tiet->execute([$id]);
        $chi_tiet = $chi_tiet->fetchAll();

        $title = 'Hóa đơn ' . $hoa_don['so_hd'];
        require_once 'app/views/hoa_don/chi_tiet.php';
    }
}

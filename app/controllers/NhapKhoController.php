<?php
require_once 'config/database.php';

class NhapKhoController {
    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) { header('Location: ?page=auth&action=login'); exit; }
    }

    public function index() {
        $this->checkLogin();
        global $pdo;
        $phieu_nhaps = $pdo->query("SELECT p.*, u.ho_ten as ten_nv, (SELECT SUM(sl) FROM chi_tiet_nhap_kho WHERE phieu_nhap_id=p.id) as tong_sl FROM phieu_nhap_kho p LEFT JOIN users u ON p.nhan_vien_id=u.id ORDER BY p.ngay_nhap DESC LIMIT 50")->fetchAll();
        $title = 'Nhập kho';
        require_once 'app/views/nhap_kho/index.php';
    }

    public function tao_moi() {
        $this->checkLogin();
        global $pdo;
        $san_phams = $pdo->query("SELECT * FROM san_pham ORDER BY ten_sp")->fetchAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $items = array_filter($_POST['items'] ?? [], fn($i) => !empty($i['san_pham_id']) && $i['so_luong'] > 0);
            if (empty($items)) { $error = 'Vui lòng thêm sản phẩm!'; }
            else {
                $so_pn = 'PN' . date('Ymd') . sprintf('%03d', rand(1,999));
                $pdo->beginTransaction();
                try {
                    $pdo->prepare("INSERT INTO phieu_nhap_kho (so_pn,nha_cung_cap,nhan_vien_id,ly_do) VALUES (?,?,?,?)")
                        ->execute([$so_pn,$_POST['nha_cung_cap'],$_SESSION['user_id'],$_POST['ly_do']]);
                    $pn_id = $pdo->lastInsertId();
                    foreach ($items as $item) {
                        $pdo->prepare("INSERT INTO chi_tiet_nhap_kho (phieu_nhap_id,san_pham_id,so_luong,don_gia) VALUES (?,?,?,?)")
                            ->execute([$pn_id,$item['san_pham_id'],$item['so_luong'],floatval($item['don_gia']??0)]);
                        $pdo->prepare("UPDATE san_pham SET so_luong_ton=so_luong_ton+? WHERE id=?")
                            ->execute([$item['so_luong'],$item['san_pham_id']]);
                    }
                    $pdo->commit();
                    header('Location: ?page=nhap_kho&success=1'); exit;
                } catch (Exception $e) { $pdo->rollBack(); $error = $e->getMessage(); }
            }
        }

        $title = 'Tạo phiếu nhập kho';
        require_once 'app/views/nhap_kho/tao_moi.php';
    }
}

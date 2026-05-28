<?php
require_once 'config/database.php';

class HomeController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=auth&action=login');
            exit;
        }

        global $pdo;

        // Thong ke tong quan
        $stats = [];

        $stats['tong_san_pham'] = $pdo->query("SELECT COUNT(*) FROM san_pham")->fetchColumn();
        $stats['tong_hoa_don_hom_nay'] = $pdo->query("SELECT COUNT(*) FROM hoa_don WHERE DATE(ngay_lap)=CURDATE()")->fetchColumn();
        $stats['doanh_thu_hom_nay'] = $pdo->query("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don WHERE DATE(ngay_lap)=CURDATE()")->fetchColumn();
        $stats['tong_khach_hang'] = $pdo->query("SELECT COUNT(*) FROM khach_hang")->fetchColumn();
        $stats['san_pham_sap_het'] = $pdo->query("SELECT COUNT(*) FROM san_pham WHERE so_luong_ton < 10")->fetchColumn();
        $stats['doanh_thu_thang'] = $pdo->query("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don WHERE MONTH(ngay_lap)=MONTH(CURDATE()) AND YEAR(ngay_lap)=YEAR(CURDATE())")->fetchColumn();

        // Hoa don gan day
        $hoa_don_gan_day = $pdo->query(
            "SELECT h.*, k.ho_ten as ten_kh, u.ho_ten as ten_nv
             FROM hoa_don h
             LEFT JOIN khach_hang k ON h.khach_hang_id=k.id
             LEFT JOIN users u ON h.nhan_vien_id=u.id
             ORDER BY h.ngay_lap DESC LIMIT 8"
        )->fetchAll();

        // San pham sap het hang
        $san_pham_sap_het = $pdo->query(
            "SELECT * FROM san_pham WHERE so_luong_ton < 10 ORDER BY so_luong_ton ASC LIMIT 5"
        )->fetchAll();

        $title = 'Dashboard';
        require_once 'app/views/home/index.php';
    }
}

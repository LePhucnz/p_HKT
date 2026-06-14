<?php
require_once 'app/models/User.php';

class DashboardController {

    public function index() {
        User::requireLogin();

        $db = Database::getConnection();

        // Doanh thu hom nay
        $stmt = $db->prepare("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don WHERE DATE(ngay_lap)=CURDATE() AND trang_thai='completed'");
        $stmt->execute();
        $doanh_thu_hom_nay = $stmt->fetchColumn();

        // So hoa don hom nay
        $stmt = $db->prepare("SELECT COUNT(*) FROM hoa_don WHERE DATE(ngay_lap)=CURDATE()");
        $stmt->execute();
        $hd_hom_nay = $stmt->fetchColumn();

        // Tong san pham
        $stmt = $db->query("SELECT COUNT(*) FROM san_pham");
        $tong_san_pham = $stmt->fetchColumn();

        // San pham sap het (ton < 10)
        $stmt = $db->query("SELECT COUNT(*) FROM san_pham WHERE so_luong_ton < 10");
        $sap_het = $stmt->fetchColumn();

        // Tong khach hang
        $stmt = $db->query("SELECT COUNT(*) FROM khach_hang");
        $tong_khach = $stmt->fetchColumn();

        // Doanh thu thang nay
        $stmt = $db->prepare("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don WHERE MONTH(ngay_lap)=MONTH(CURDATE()) AND YEAR(ngay_lap)=YEAR(CURDATE()) AND trang_thai='completed'");
        $stmt->execute();
        $doanh_thu_thang = $stmt->fetchColumn();

        // Hoa don gan day (8 cai)
        $stmt = $db->query("SELECT h.*, kh.ho_ten as ten_kh, u.ho_ten as ten_nv
            FROM hoa_don h
            LEFT JOIN khach_hang kh ON h.khach_hang_id=kh.id
            LEFT JOIN users u ON h.nhan_vien_id=u.id
            ORDER BY h.ngay_lap DESC LIMIT 8");
        $hoa_don_gan_day = $stmt->fetchAll();

        // San pham ban chay (top 5)
        $stmt = $db->query("SELECT sp.ten_sp, SUM(ct.so_luong) as tong_ban
            FROM chi_tiet_hoa_don ct
            JOIN san_pham sp ON ct.san_pham_id=sp.id
            JOIN hoa_don h ON ct.hoa_don_id=h.id
            WHERE h.trang_thai='completed'
            GROUP BY sp.id ORDER BY tong_ban DESC LIMIT 5");
        $san_pham_ban_chay = $stmt->fetchAll();

        // San pham sap het hang (ton < 10)
        $stmt = $db->query("SELECT * FROM san_pham WHERE so_luong_ton < 10 ORDER BY so_luong_ton ASC LIMIT 5");
        $ds_sap_het = $stmt->fetchAll();

        $title = 'Dashboard';
        require_once 'app/views/dashboard/index.php';
    }
}

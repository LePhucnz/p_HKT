<?php
require_once 'config/database.php';

class BaoCaoController {
    private function checkLogin() {
        if (!isset($_SESSION['user_id'])) { header('Location: ?page=auth&action=login'); exit; }
    }

    public function index() {
        $this->checkLogin();
        global $pdo;
        $tu_ngay = $_GET['tu_ngay'] ?? date('Y-m-01');
        $den_ngay = $_GET['den_ngay'] ?? date('Y-m-d');

        $bao_cao = $pdo->prepare(
            "SELECT DATE(ngay_lap) as ngay,
                COUNT(*) as tong_hd,
                SUM(CASE WHEN phuong_thuc_tt='Tiền mặt' THEN thanh_tien ELSE 0 END) as tien_mat,
                SUM(CASE WHEN phuong_thuc_tt='Chuyển khoản' THEN thanh_tien ELSE 0 END) as chuyen_khoan,
                SUM(CASE WHEN phuong_thuc_tt='QR Code' THEN thanh_tien ELSE 0 END) as qr_code,
                SUM(CASE WHEN phuong_thuc_tt='Khác' THEN thanh_tien ELSE 0 END) as khac,
                SUM(thanh_tien) as tong_cong,
                SUM(giam_gia) as tong_giam,
                SUM(thanh_tien) as dt_thuan
             FROM hoa_don WHERE DATE(ngay_lap) BETWEEN ? AND ?
             GROUP BY DATE(ngay_lap) ORDER BY ngay DESC"
        );
        $bao_cao->execute([$tu_ngay, $den_ngay]);
        $bao_cao = $bao_cao->fetchAll();

        $title = 'Báo cáo doanh thu';
        require_once 'app/views/bao_cao/index.php';
    }
}

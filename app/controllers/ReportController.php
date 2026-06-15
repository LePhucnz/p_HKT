<?php
require_once 'app/models/User.php';

class ReportController {

    private function checkPermission() {
        User::requireLogin();
        if (!User::hasRole([ROLE_ADMIN, ROLE_MANAGER])) {
            die('Bạn không có quyền xem báo cáo!');
        }
    }

    public function revenue() {
        $this->checkPermission();

        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate   = $_GET['end_date']   ?? date('Y-m-d');

        $db = Database::getConnection();

        // Doanh thu theo ngay
        $stmt = $db->prepare(
            "SELECT DATE(ngay_lap) as date,
                    COUNT(*) as total_invoices,
                    SUM(tong_tien) as tong_hang,
                    SUM(giam_gia) as tong_giam,
                    SUM(thanh_tien) as total_revenue
             FROM hoa_don
             WHERE DATE(ngay_lap) BETWEEN :start AND :end
             GROUP BY DATE(ngay_lap)
             ORDER BY date DESC"
        );
        $stmt->execute(['start' => $startDate, 'end' => $endDate]);
        $dailyRevenue = $stmt->fetchAll();

        // Tong hop
        $stmt = $db->prepare(
            "SELECT COALESCE(SUM(thanh_tien),0) as total,
                    COUNT(*) as count,
                    COALESCE(SUM(giam_gia),0) as tong_giam
             FROM hoa_don
             WHERE DATE(ngay_lap) BETWEEN :start AND :end"
        );
        $stmt->execute(['start' => $startDate, 'end' => $endDate]);
        $summary = $stmt->fetch();

        $title = 'Báo cáo doanh thu';
        require_once 'app/views/reports/revenue.php';
    }

    public function inventory() {
        $this->checkPermission();

        $db    = Database::getConnection();
        $catId = $_GET['category_id'] ?? '';
        $where  = $catId ? "WHERE sp.danh_muc_id = :cid" : "";
        $params = $catId ? ['cid' => $catId] : [];

        $stmt = $db->prepare(
            "SELECT sp.*, dm.ten_danh_muc FROM san_pham sp
             LEFT JOIN danh_muc dm ON sp.danh_muc_id=dm.id
             $where ORDER BY sp.so_luong_ton ASC"
        );
        $stmt->execute($params);
        $products   = $stmt->fetchAll();
        $categories = $db->query("SELECT * FROM danh_muc ORDER BY ten_danh_muc")->fetchAll();

        $stats = $db->query(
            "SELECT COUNT(*) as total_products,
             COALESCE(SUM(so_luong_ton * gia_ban),0) as total_value,
             SUM(CASE WHEN so_luong_ton < 10 AND so_luong_ton > 0 THEN 1 ELSE 0 END) as low_stock_count,
             SUM(CASE WHEN so_luong_ton = 0 THEN 1 ELSE 0 END) as out_of_stock_count
             FROM san_pham"
        )->fetch();

        $title = 'Báo cáo tồn kho';
        require_once 'app/views/reports/inventory.php';
    }
}

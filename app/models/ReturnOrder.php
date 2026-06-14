<?php
require_once __DIR__ . '/BaseModel.php';

class ReturnOrder extends BaseModel {
    protected $table = 'tra_hang';

    public function create($data) {
        $sql = "INSERT INTO tra_hang (hoa_don_id, ngay_tra, ly_do, so_tien_hoan, phuong_thuc_hoan, trang_thai)
                VALUES (:hoa_don_id, :ngay_tra, :ly_do, :so_tien_hoan, :phuong_thuc_hoan, :trang_thai)";
        return $this->db->prepare($sql)->execute($data);
    }

    public function getWithInvoice($id) {
        $stmt = $this->db->prepare(
            "SELECT th.*, hd.so_hd FROM tra_hang th
             LEFT JOIN hoa_don hd ON th.hoa_don_id=hd.id WHERE th.id=:id"
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}

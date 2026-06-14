<?php
// app/models/PurchaseOrder.php
require_once 'BaseModel.php';

class PurchaseOrder extends BaseModel {
    protected $table = 'phieu_nhap_kho';
    
    public function createOrder($supplier, $userId, $items) {
        try {
            $this->db->beginTransaction();
            
            // Tạo phiếu nhập
            $orderNumber = 'PN' . date('YmdHis');
            $sql = "INSERT INTO phieu_nhap_kho (so_pn, nha_cung_cap, nhan_vien_id) 
                    VALUES (:so_pn, :nha_cung_cap, :nhan_vien_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'so_pn' => $orderNumber,
                'nha_cung_cap' => $supplier,
                'nhan_vien_id' => $userId
            ]);
            
            $orderId = $this->db->lastInsertId();
            
            // Thêm chi tiết và cộng tồn kho
            $detailModel = new PurchaseOrderDetail();
            $productModel = new Product();
            
            foreach ($items as $item) {
                $detailModel->create([
                    'phieu_nhap_id' => $orderId,
                    'san_pham_id' => $item['product_id'],
                    'so_luong' => $item['quantity'],
                    'don_gia_nhap' => $item['price']
                ]);
                
                $productModel->increaseStock($item['product_id'], $item['quantity']);
            }
            
            $this->db->commit();
            return $orderId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
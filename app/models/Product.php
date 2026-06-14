<?php
// app/models/Product.php
require_once 'BaseModel.php';

class Product extends BaseModel {
    protected $table = 'san_pham';
    
    // Lấy sản phẩm kèm tên danh mục
    public function getAllWithCategory() {
        $sql = "SELECT sp.*, dm.ten_danh_muc 
                FROM san_pham sp 
                LEFT JOIN danh_muc dm ON sp.danh_muc_id = dm.id 
                ORDER BY sp.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Tìm kiếm sản phẩm
    public function search($keyword) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE ten_sp LIKE :keyword OR ma_sp LIKE :keyword 
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll();
    }
    
    // Thêm sản phẩm
    public function create($data) {
        $sql = "INSERT INTO san_pham (ma_sp, ten_sp, danh_muc_id, don_vi_tinh, gia_ban, so_luong_ton, mo_ta) 
                VALUES (:ma_sp, :ten_sp, :danh_muc_id, :don_vi_tinh, :gia_ban, :so_luong_ton, :mo_ta)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    // Cập nhật sản phẩm
    public function update($id, $data) {
        $sql = "UPDATE san_pham 
                SET ten_sp = :ten_sp, danh_muc_id = :danh_muc_id, 
                    don_vi_tinh = :don_vi_tinh, gia_ban = :gia_ban, mo_ta = :mo_ta 
                WHERE id = :id";
        $data['id'] = $id;
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    // Giảm tồn kho
    public function decreaseStock($productId, $quantity) {
        $sql = "UPDATE san_pham SET so_luong_ton = so_luong_ton - :quantity WHERE id = :id AND so_luong_ton >= :quantity";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $productId, 'quantity' => $quantity]);
    }
    
    // Tăng tồn kho
    public function increaseStock($productId, $quantity) {
        $sql = "UPDATE san_pham SET so_luong_ton = so_luong_ton + :quantity WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $productId, 'quantity' => $quantity]);
    }
    
    // Lấy sản phẩm còn hàng
    public function getInStock() {
        $sql = "SELECT * FROM {$this->table} WHERE so_luong_ton > 0 ORDER BY ten_sp ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
<?php
// app/models/Customer.php
require_once 'BaseModel.php';

class Customer extends BaseModel {
    protected $table = 'khach_hang';
    
    // Tạo mã khách hàng tự động
    public function generateCustomerCode() {
        $stmt = $this->db->query("SELECT MAX(id) as max_id FROM khach_hang");
        $result = $stmt->fetch();
        $nextId = ($result['max_id'] ?? 0) + 1;
        return 'KH' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }
    
    // Thêm khách hàng
    public function create($data) {
        $data['ma_kh'] = $this->generateCustomerCode();
        $sql = "INSERT INTO khach_hang (ma_kh, ho_ten, so_dien_thoai, dia_chi, email, ngay_sinh, gioi_tinh) 
                VALUES (:ma_kh, :ho_ten, :so_dien_thoai, :dia_chi, :email, :ngay_sinh, :gioi_tinh)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    
    // Cập nhật điểm tích lũy
    public function addPoints($id, $points) {
        $sql = "UPDATE khach_hang SET diem_tich_luy = diem_tich_luy + :points WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'points' => $points]);
        
        // Cập nhật hạng thành viên
        $this->updateMembership($id);
    }
    
    // Cập nhật hạng dựa trên điểm
    public function updateMembership($id) {
        $customer = $this->find($id);
        $points = $customer['diem_tich_luy'];
        
        if ($points >= 1000) {
            $rank = 'Kim cương';
        } elseif ($points >= 500) {
            $rank = 'Vàng';
        } else {
            $rank = 'Bạc';
        }
        
        $sql = "UPDATE khach_hang SET hang_thanh_vien = :rank WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id, 'rank' => $rank]);
    }
    
    // Tìm kiếm khách hàng
    public function search($keyword) {
        $sql = "SELECT * FROM khach_hang 
                WHERE ho_ten LIKE :keyword OR so_dien_thoai LIKE :keyword OR ma_kh LIKE :keyword
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll();
    }

    public function filterByRank($rank) {
        $stmt = $this->db->prepare("SELECT * FROM khach_hang WHERE hang_thanh_vien=:rank ORDER BY id DESC");
        $stmt->execute(['rank' => $rank]);
        return $stmt->fetchAll();
    }

    public function update($id, $data) {
        $sql = "UPDATE khach_hang SET ho_ten=:ho_ten, so_dien_thoai=:so_dien_thoai,
                email=:email, ngay_sinh=:ngay_sinh, dia_chi=:dia_chi, gioi_tinh=:gioi_tinh
                WHERE id=:id";
        $data['id'] = $id;
        return $this->db->prepare($sql)->execute($data);
    }

    public function hasInvoices($id) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM hoa_don WHERE khach_hang_id=:id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn() > 0;
    }

    public function getInvoices($id) {
        $stmt = $this->db->prepare("SELECT * FROM hoa_don WHERE khach_hang_id=:id ORDER BY ngay_lap DESC");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }

    public function getTotalSpent($id) {
        $stmt = $this->db->prepare("SELECT COALESCE(SUM(thanh_tien),0) FROM hoa_don WHERE khach_hang_id=:id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getPointHistory($id) {
        $stmt = $this->db->prepare("SELECT * FROM hoa_don WHERE khach_hang_id=:id ORDER BY ngay_lap DESC LIMIT 10");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }
}
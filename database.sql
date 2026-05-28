-- =============================================
-- HKT SHOP - Database Schema
-- Chạy file này trong phpMyAdmin hoặc MySQL CLI
-- =============================================

CREATE DATABASE IF NOT EXISTS ban_hang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ban_hang;

-- Users
CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten     VARCHAR(100) NOT NULL,
    email      VARCHAR(100) UNIQUE NOT NULL,
    mat_khau   VARCHAR(255) NOT NULL,
    vai_tro    ENUM('admin','nhan_vien') DEFAULT 'nhan_vien',
    ngay_tao   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Danh muc
CREATE TABLE IF NOT EXISTS danh_muc (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc   VARCHAR(100) NOT NULL,
    mo_ta          TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- San pham
CREATE TABLE IF NOT EXISTS san_pham (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    ma_sp          VARCHAR(50) UNIQUE NOT NULL,
    ten_sp         VARCHAR(200) NOT NULL,
    danh_muc_id    INT,
    don_vi_tinh    VARCHAR(50),
    gia_ban        DECIMAL(15,2) DEFAULT 0,
    so_luong_ton   INT DEFAULT 0,
    mo_ta          TEXT,
    ngay_tao       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (danh_muc_id) REFERENCES danh_muc(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Khach hang
CREATE TABLE IF NOT EXISTS khach_hang (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    ma_kh            VARCHAR(50) UNIQUE NOT NULL,
    ho_ten           VARCHAR(100) NOT NULL,
    so_dien_thoai    VARCHAR(20),
    dia_chi          TEXT,
    email            VARCHAR(100),
    ngay_sinh        DATE,
    gioi_tinh        ENUM('Nam','Nữ','Khác'),
    ngay_dang_ky     DATE DEFAULT (CURDATE()),
    diem_tich_luy    INT DEFAULT 0,
    hang_thanh_vien  ENUM('Bạc','Vàng','Kim cương') DEFAULT 'Bạc',
    ghi_chu          TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Hoa don
CREATE TABLE IF NOT EXISTS hoa_don (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    so_hd            VARCHAR(50) UNIQUE NOT NULL,
    khach_hang_id    INT,
    nhan_vien_id     INT,
    ngay_lap         DATETIME DEFAULT NOW(),
    phuong_thuc_tt   ENUM('Tiền mặt','Chuyển khoản','QR Code','Khác') DEFAULT 'Tiền mặt',
    tong_tien        DECIMAL(15,2) DEFAULT 0,
    giam_gia         DECIMAL(15,2) DEFAULT 0,
    thanh_tien       DECIMAL(15,2) DEFAULT 0,
    ghi_chu          TEXT,
    FOREIGN KEY (khach_hang_id) REFERENCES khach_hang(id) ON DELETE SET NULL,
    FOREIGN KEY (nhan_vien_id)  REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Chi tiet hoa don
CREATE TABLE IF NOT EXISTS chi_tiet_hoa_don (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    hoa_don_id     INT NOT NULL,
    san_pham_id    INT NOT NULL,
    so_luong       INT NOT NULL,
    don_gia        DECIMAL(15,2) NOT NULL,
    thanh_tien     DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (hoa_don_id)  REFERENCES hoa_don(id)  ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Phieu nhap kho
CREATE TABLE IF NOT EXISTS phieu_nhap_kho (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    so_pn           VARCHAR(50) UNIQUE NOT NULL,
    nha_cung_cap    VARCHAR(200),
    nhan_vien_id    INT,
    ngay_nhap       DATETIME DEFAULT NOW(),
    ly_do           TEXT,
    FOREIGN KEY (nhan_vien_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Chi tiet nhap kho
CREATE TABLE IF NOT EXISTS chi_tiet_nhap_kho (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    phieu_nhap_id   INT NOT NULL,
    san_pham_id     INT NOT NULL,
    so_luong        INT NOT NULL,
    don_gia         DECIMAL(15,2) DEFAULT 0,
    FOREIGN KEY (phieu_nhap_id) REFERENCES phieu_nhap_kho(id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id)   REFERENCES san_pham(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- DỮ LIỆU MẪU
-- =============================================

-- Admin: email=admin@hkt.com | password=123456
INSERT INTO users (ho_ten, email, mat_khau, vai_tro) VALUES
('Quản trị viên', 'admin@hkt.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Nguyễn Văn A',  'nv1@hkt.com',   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nhan_vien');

INSERT INTO danh_muc (ten_danh_muc, mo_ta) VALUES
('Điện tử',   'Thiết bị điện tử, điện thoại, máy tính'),
('Thời trang','Quần áo, giày dép, phụ kiện'),
('Thực phẩm', 'Đồ ăn, thức uống'),
('Gia dụng',  'Đồ dùng gia đình');

INSERT INTO san_pham (ma_sp, ten_sp, danh_muc_id, don_vi_tinh, gia_ban, so_luong_ton) VALUES
('SP001','Điện thoại Samsung A54',1,'Cái',8990000,50),
('SP002','Tai nghe JBL T450',    1,'Cái',1200000,100),
('SP003','Áo thun nam basic',     2,'Cái',150000,200),
('SP004','Quần jeans nữ',         2,'Cái',350000,80),
('SP005','Nồi cơm điện Sunhouse', 4,'Cái',850000,30),
('SP006','Cà phê Highlands 500g', 3,'Gói',189000,150);

INSERT INTO khach_hang (ma_kh,ho_ten,so_dien_thoai,email,ngay_dang_ky,hang_thanh_vien) VALUES
('KH001','Trần Thị Bình','0901234567','binh@gmail.com',CURDATE(),'Vàng'),
('KH002','Lê Văn Cường', '0912345678','cuong@gmail.com',CURDATE(),'Bạc');

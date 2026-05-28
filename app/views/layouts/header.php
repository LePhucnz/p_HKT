<?php
$current_page = $_GET['page'] ?? 'home';
$current_action = $_GET['action'] ?? 'index';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HKT Shop' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/p_HKT-main/public/css/style.css" rel="stylesheet">
</head>
<body>

<!-- SIDEBAR -->
<nav class="sidebar">
    <a class="sidebar-brand" href="?page=home">
        <i class="bi bi-shop text-primary fs-5"></i> HKT Shop
    </a>

    <div class="nav-section">Tổng quan</div>
    <a href="?page=home" class="nav-link <?= $current_page==='home'?'active':'' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="nav-section">Bán hàng</div>
    <a href="?page=hoa_don&action=tao_moi" class="nav-link <?= $current_page==='hoa_don'&&$current_action==='tao_moi'?'active':'' ?>">
        <i class="bi bi-plus-circle"></i> Tạo hóa đơn
    </a>
    <a href="?page=hoa_don" class="nav-link <?= $current_page==='hoa_don'&&$current_action==='index'?'active':'' ?>">
        <i class="bi bi-receipt"></i> Danh sách hóa đơn
    </a>

    <div class="nav-section">Kho hàng</div>
    <a href="?page=san_pham" class="nav-link <?= $current_page==='san_pham'&&in_array($current_action,['index',''])?'active':'' ?>">
        <i class="bi bi-box-seam"></i> Sản phẩm
    </a>
    <a href="?page=nhap_kho" class="nav-link <?= $current_page==='nhap_kho'?'active':'' ?>">
        <i class="bi bi-truck"></i> Nhập kho
    </a>

    <div class="nav-section">Khách hàng</div>
    <a href="?page=khach_hang" class="nav-link <?= $current_page==='khach_hang'?'active':'' ?>">
        <i class="bi bi-people"></i> Khách hàng
    </a>

    <div class="nav-section">Báo cáo</div>
    <a href="?page=bao_cao" class="nav-link <?= $current_page==='bao_cao'?'active':'' ?>">
        <i class="bi bi-bar-chart-line"></i> Doanh thu
    </a>

    <?php if(isset($_SESSION['vai_tro']) && $_SESSION['vai_tro']==='admin'): ?>
    <div class="nav-section">Hệ thống</div>
    <a href="?page=users" class="nav-link <?= $current_page==='users'?'active':'' ?>">
        <i class="bi bi-people-fill"></i> Người dùng
    </a>
    <?php endif; ?>
</nav>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="fw-semibold text-secondary"><?= $title ?? 'Dashboard' ?></div>
        <div class="d-flex align-items-center gap-3">
            <?php if(isset($_SESSION['user_id'])): ?>
            <span class="text-secondary small">
                <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['ho_ten']) ?>
                <span class="badge bg-primary ms-1"><?= $_SESSION['vai_tro'] ?></span>
            </span>
            <a href="?page=auth&action=logout" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
            <?php else: ?>
            <a href="?page=auth&action=login" class="btn btn-sm btn-primary">Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="page-content">

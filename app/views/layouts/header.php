<?php
require_once 'app/models/User.php';
$current_url = $_GET['url'] ?? 'dashboard';
$current_page = explode('/', $current_url)[0];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'HKT Shop') ?> — HKT Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --sidebar-w: 230px; --topbar-h: 56px; --blue: #1a56db; --dark: #111827; }

        body { background: #f3f4f6; font-family: 'Segoe UI', sans-serif; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--dark);
            position: fixed;
            top: 0; left: 0;
            display: flex; flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 16px 20px;
            border-bottom: 1px solid #1f2937;
            text-decoration: none;
        }
        .sidebar-brand h6 { color: #fff; font-size: 1rem; font-weight: 700; margin: 0; }
        .sidebar-brand small { color: #6b7280; font-size: .72rem; }

        .sidebar-section {
            padding: 14px 20px 4px;
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #4b5563;
            font-weight: 600;
        }
        .sidebar a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 20px;
            color: #9ca3af;
            text-decoration: none;
            font-size: .85rem;
            border-left: 3px solid transparent;
            transition: .15s;
        }
        .sidebar a:hover { background: #1f2937; color: #fff; }
        .sidebar a.active { background: #1f2937; color: #fff; border-left-color: var(--blue); }
        .sidebar a i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-divider { border-color: #1f2937; margin: 4px 0; }

        /* ===== MAIN ===== */
        .main { margin-left: var(--sidebar-w); min-height: 100vh; }

        /* ===== TOPBAR ===== */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        .topbar-title { font-weight: 600; color: #374151; font-size: .9rem; }

        /* ===== PAGE CONTENT ===== */
        .page-body { padding: 24px; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            display: flex; align-items: center; gap: 16px;
            transition: box-shadow .2s;
        }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.08); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0;
        }
        .stat-card .value { font-size: 1.5rem; font-weight: 700; color: #111827; line-height: 1.2; }
        .stat-card .label { font-size: .78rem; color: #6b7280; margin-top: 2px; }

        /* ===== TABLE CARD ===== */
        .table-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .table-card .card-header-custom {
            padding: 14px 20px;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 600;
            font-size: .88rem;
            color: #374151;
            display: flex; align-items: center; justify-content: space-between;
        }
        .table-card table { margin: 0; font-size: .83rem; }
        .table-card thead th {
            background: #f9fafb;
            color: #6b7280;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            font-weight: 600;
            border-top: none;
            padding: 10px 16px;
        }
        .table-card td { padding: 10px 16px; vertical-align: middle; }

        /* ===== BADGE ===== */
        .badge-rank-bac      { background: #e5e7eb; color: #374151; }
        .badge-rank-vang     { background: #fef3c7; color: #92400e; }
        .badge-rank-kimcuong { background: #dbeafe; color: #1e40af; }

        /* form controls */
        .form-control, .form-select { font-size: .875rem; border-radius: 8px; border-color: #d1d5db; }
        .form-control:focus, .form-select:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,86,219,.12); }
        .btn { border-radius: 8px; font-size: .85rem; font-weight: 500; }
        .btn-primary { background: var(--blue); border-color: var(--blue); }
        .btn-primary:hover { background: #1447b2; border-color: #1447b2; }

        @media print { .sidebar, .topbar { display: none !important; } .main { margin-left: 0 !important; } }
    </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar">
    <a href="<?= BASE_URL ?>dashboard" class="sidebar-brand text-decoration-none">
        <h6><i class="bi bi-shop me-2 text-primary"></i>HKT Shop</h6>
        <small><?= htmlspecialchars($_SESSION['ho_ten'] ?? '') ?></small>
    </a>

    <div class="sidebar-section">Tổng quan</div>
    <a href="<?= BASE_URL ?>dashboard" class="<?= $current_page==='dashboard'?'active':'' ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="sidebar-section">Bán hàng</div>
    <a href="<?= BASE_URL ?>invoice/create" class="<?= $current_page==='invoice'?'active':'' ?>">
        <i class="bi bi-cart-plus"></i> Tạo hóa đơn
    </a>
    <a href="<?= BASE_URL ?>invoice" class="">
        <i class="bi bi-receipt"></i> Danh sách HĐ
    </a>

    <div class="sidebar-section">Kho hàng</div>
    <a href="<?= BASE_URL ?>product" class="<?= $current_page==='product'?'active':'' ?>">
        <i class="bi bi-box-seam"></i> Sản phẩm
    </a>
    <a href="<?= BASE_URL ?>category" class="<?= $current_page==='category'?'active':'' ?>">
        <i class="bi bi-tags"></i> Danh mục
    </a>
    <a href="<?= BASE_URL ?>purchaseOrder" class="<?= $current_page==='purchaseOrder'?'active':'' ?>">
        <i class="bi bi-truck"></i> Nhập kho
    </a>

    <div class="sidebar-section">Khách hàng</div>
    <a href="<?= BASE_URL ?>customer" class="<?= $current_page==='customer'?'active':'' ?>">
        <i class="bi bi-people"></i> Khách hàng
    </a>

    <?php if(User::hasRole([ROLE_ADMIN, ROLE_MANAGER])): ?>
    <div class="sidebar-section">Báo cáo</div>
    <a href="<?= BASE_URL ?>report/revenue" class="<?= $current_page==='report'?'active':'' ?>">
        <i class="bi bi-bar-chart-line"></i> Doanh thu
    </a>
    <a href="<?= BASE_URL ?>promotion" class="<?= $current_page==='promotion'?'active':'' ?>">
        <i class="bi bi-gift"></i> Khuyến mãi
    </a>
    <?php endif; ?>

        <div class="sidebar-section">Hệ thống</div>
    <a href="<?= BASE_URL ?>user" class="<?= $current_page==='user'?'active':'' ?>">
        <i class="bi bi-people-fill"></i> Người dùng
    </a>

    
    <?php if(User::hasRole([ROLE_ADMIN])): ?>
    <div class="sidebar-section">Hệ thống</div>
    <a href="<?= BASE_URL ?>user" class="<?= $current_page==='user'?'active':'' ?>">
        <i class="bi bi-people-fill"></i> Người dùng
    </a>
    <?php endif; ?>

<hr class="sidebar-divider">
    <a href="<?= BASE_URL ?>auth/logout" class="text-danger mt-auto">
        <i class="bi bi-box-arrow-right"></i> Đăng xuất
    </a>
</aside>

<!-- ===== MAIN ===== -->
<div class="main">
    <!-- Topbar -->
    <div class="topbar">
        <span class="topbar-title"><?= htmlspecialchars($title ?? 'Dashboard') ?></span>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted" style="font-size:.8rem">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($_SESSION['ho_ten'] ?? '') ?>
                <span class="badge bg-primary ms-1" style="font-size:.68rem">
                    <?= htmlspecialchars($_SESSION['vai_tro'] ?? '') ?>
                </span>
            </span>
            <a href="<?= BASE_URL ?>auth/logout" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

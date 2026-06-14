<?php
// config/constants.php
session_start();

// QUAN TRỌNG: BASE_URL phải đúng với tên thư mục p_HKT
define('BASE_URL', 'http://localhost/p_HKT/');
define('ROOT_PATH', dirname(__DIR__));

// Định nghĩa vai trò
define('ROLE_ADMIN', 'admin');
define('ROLE_MANAGER', 'manager');
define('ROLE_CASHIER', 'cashier');
define('ROLE_STOCK_KEEPER', 'stock_keeper');
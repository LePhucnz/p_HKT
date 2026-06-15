<?php
// index.php - thư mục gốc p_HKT
require_once 'config/database.php';
require_once 'config/constants.php';

// Tự động load file
spl_autoload_register(function($className) {
    $paths = [
        'app/controllers/' . $className . '.php',
        'app/models/' . $className . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// ===== SỬA PHẦN NÀY =====
// Lấy URL từ GET parameter 'url'
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Nếu URL rỗng -> vào dashboard
if (empty($url)) {
    $urlParts = ['dashboard'];
} else {
    $urlParts = explode('/', rtrim($url, '/'));
}

$controllerName = ucfirst($urlParts[0]) . 'Controller';
$action = isset($urlParts[1]) ? $urlParts[1] : 'index';
$params = array_slice($urlParts, 2);

$controllerFile = 'app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], $params);
    } else {
        die("Không tìm thấy action: $action trong controller $controllerName");
    }
} else {
    die("Không tìm thấy controller: $controllerName - File: $controllerFile");
}
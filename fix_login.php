<?php
require_once 'config/database.php';
require_once 'config/constants.php';

$db = Database::getConnection();

// Lay danh sach users hien tai
$users = $db->query("SELECT id, ho_ten, email, LEFT(mat_khau,20) as hash_preview, vai_tro FROM users")->fetchAll();

echo "<h3>Users trong DB hiện tại:</h3><pre>";
foreach($users as $u) {
    echo "ID:{$u['id']} | {$u['email']} | role:{$u['vai_tro']} | hash:{$u['hash_preview']}...\n";
}
echo "</pre>";

// Thu verify mat khau "password" va "123456"
$u0 = $db->query("SELECT * FROM users LIMIT 1")->fetch();
echo "<h3>Test verify với user đầu tiên ({$u0['email']}):</h3>";
echo "'password' → " . (password_verify('password', $u0['mat_khau']) ? '✅ ĐÚNG' : '❌ SAI') . "<br>";
echo "'123456'   → " . (password_verify('123456',  $u0['mat_khau']) ? '✅ ĐÚNG' : '❌ SAI') . "<br>";

echo "<hr><h3>Reset mật khẩu = 123456 cho tất cả:</h3>";
$hash = password_hash('123456', PASSWORD_BCRYPT);
$db->prepare("UPDATE users SET mat_khau=:h")->execute(['h' => $hash]);
echo "✅ Đã cập nhật! Hash mới: <code>$hash</code><br><br>";

// Xac nhan lai
$u0 = $db->query("SELECT * FROM users LIMIT 1")->fetch();
echo "Verify lại '123456' → " . (password_verify('123456', $u0['mat_khau']) ? '✅ ĐÚNG' : '❌ VẪN SAI') . "<br><br>";
echo "<a href='index.php?url=auth/login'><b>→ Đăng nhập ngay với mật khẩu 123456</b></a><br><br>";
echo "<b style='color:red'>⚠️ Xóa file fix_login.php sau khi đăng nhập được!</b>";

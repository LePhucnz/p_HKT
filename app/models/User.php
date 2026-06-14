<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function all() {
        return $this->db->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO users (ho_ten, email, mat_khau, vai_tro) VALUES (:ho_ten, :email, :mat_khau, :vai_tro)"
        );
        return $stmt->execute($data);
    }

    // Kiem tra da dang nhap
    public static function isLoggedIn(): bool {
        return !empty($_SESSION['user_id']);
    }

    // Kiem tra quyen
    public static function hasRole($roles): bool {
        if (!self::isLoggedIn()) return false;
        if (is_string($roles)) $roles = [$roles];
        return in_array($_SESSION['vai_tro'] ?? '', $roles);
    }

    // Bat buoc dang nhap, redirect neu chua
    public static function requireLogin(): void {
        if (!self::isLoggedIn()) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }
    }
}

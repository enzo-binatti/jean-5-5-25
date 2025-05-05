<?php
require_once __DIR__ . '/../service/Database.php';
class User {
    public static function findByEmail($email) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public static function updatePassword($id, $novaSenhaHash) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('UPDATE users SET senha = ? WHERE id = ?');
        return $stmt->execute([$novaSenhaHash, $id]);
    }
}

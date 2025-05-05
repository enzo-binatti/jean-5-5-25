<?php
require_once __DIR__ . '/../service/Database.php';
class Code {
    public static function create($usuario_id, $code) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO codes (usuario_id, code) VALUES (?, ?)');
        return $stmt->execute([$usuario_id, $code]);
    }
    public static function verify($usuario_id, $code) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT * FROM codes WHERE usuario_id = ? AND code = ? ORDER BY id DESC LIMIT 1');
        $stmt->execute([$usuario_id, $code]);
        return $stmt->fetch() ? true : false;
    }
}

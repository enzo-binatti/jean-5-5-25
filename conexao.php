<?php
$host = 'localhost';
$db = 'tarefa_do_jean';
$user = 'root'; // ou seu usuário do MySQL
$pass = '';     // ou sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
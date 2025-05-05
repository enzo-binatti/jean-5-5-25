<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $email = $_SESSION['email_recuperacao'];

    $stmt = $phpMyAdmin->prepare("SELECT * FROM codigos WHERE email = ? AND codigo = ? AND expira > NOW()");
    $stmt->execute([$email, $codigo]);
    $registro = $stmt->fetch();

    if (!$registro) {
        $_SESSION['erro'] = "Código inválido ou expirado.";
        header("Location: verificar_codigo.php");
        exit();
    }

    // Deletar o código após uso
    $phpMyAdmin->prepare("DELETE FROM codigos WHERE email = ?")->execute([$email]);

    header("Location: reset-password.php");
    exit();
}
?>
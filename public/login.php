<?php
session_start();
require 'conexao.php'; // Caminho corrigido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';

    if (empty($email) || empty($senha)) {
        $_SESSION['erro'] = 'Preencha todos os campos.';
        header('Location: /tarefa_do_jean/views/login.html');
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// ... código de validação do login
if ($login_sucesso) {
    header("Location: ../view/bem vindo.html");
    exit();
} else {
        $_SESSION['erro'] = 'E-mail ou senha inválidos.';
        header('Location: /tarefa_do_jean/views/login.html');
        exit();
    }
}
?>
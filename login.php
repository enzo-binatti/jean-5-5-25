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

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        header('Location: /tarefa_do_jean/views/bem vindo.html'); // ✅ Redireciona para página de boas-vindas
        exit();
    } else {
        $_SESSION['erro'] = 'E-mail ou senha inválidos.';
        header('Location: /tarefa_do_jean/views/login.html');
        exit();
    }
}
?>
<?php
session_start();
require 'conexao.php'; // Caminho corrigido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';

    // Validações
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)) {
        $_SESSION['erro'] = 'Preencha todos os campos.';
        header('Location: /tarefa_do_jean/views/Cadastro.html');
        exit();
    }
    if ($senha !== $confirmarSenha) {
        $_SESSION['erro'] = 'As senhas não coincidem.';
        header('Location: /tarefa_do_jean/views/Cadastro.html');
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = 'E-mail inválido.';
        header('Location: /tarefa_do_jean/views/Cadastro.html');
        exit();
    }

    // Verificar se email já existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['erro'] = 'E-mail já cadastrado.';
        header('Location: /tarefa_do_jean/views/Cadastro.html');
        exit();
    }

    // Criar usuário
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)")
        ->execute([$nome, $email, $senhaHash]);

    $_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
    header('Location: /tarefa_do_jean/views/bem vindo.html'); // ✅ Redireciona para página de boas-vindas
    exit();
}
?>
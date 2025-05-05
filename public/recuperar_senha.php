<?php
session_start();
require 'conexao.php'; // Caminho corrigido

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $novaSenha = $_POST['novaSenha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($novaSenha !== $confirmarSenha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: /tarefa_do_jean/views/recuperacao.html");
        exit();
    }

    // Verificar token
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $_SESSION['erro'] = "Token inválido ou expirado.";
        header("Location: /tarefa_do_jean/views/recuperacao.html");
        exit();
    }

    // Atualizar senha
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE usuarios SET senha = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?")
        ->execute([$senhaHash, $usuario['id']]);

    $_SESSION['sucesso'] = "Senha alterada com sucesso!";
    header("Location: /tarefa_do_jean/views/bem vindo.html"); // ✅ Redireciona após sucesso
    exit();
} else {
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        header("Location: /tarefa_do_jean/views/recuperacao.html");
        exit();
    }
}
?>
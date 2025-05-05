<?php
session_start();
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $novaSenha = $_POST['novaSenha'];
    $confirmarSenha = $_POST['confirmarSenha'];

    if ($novaSenha !== $confirmarSenha) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: reset-password.php?token=$token");
        exit();
    }

    // Verificar se o token é válido e ainda não expirou
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $_SESSION['erro'] = "Token inválido ou expirado.";
        header("Location: recuperacao.html");
        exit();
    }

    // Criptografar a nova senha
    $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

    // Atualizar a senha e limpar o token no banco
    $pdo->prepare("UPDATE usuarios SET senha = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?")
        ->execute([$senhaHash, $usuario['id']]);

    // Mensagem de sucesso
    $_SESSION['sucesso'] = "Senha alterada com sucesso!";
    header("Location: login.html");
    exit();

} else {
    $token = $_GET['token'] ?? '';

    if (empty($token)) {
        header("Location: recuperacao.html");
        exit();
    }

    // Exibir formulário para nova senha
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Redefinir Senha</h2>

    <?php
    if (isset($_SESSION['erro'])) {
        echo '<p class="error">' . $_SESSION['erro'] . '</p>';
        unset($_SESSION['erro']);
    }
    ?>

    <form method="post">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
        
        <label for="novaSenha">Nova Senha:</label>
        <input type="password" id="novaSenha" name="novaSenha" required>

        <label for="confirmarSenha">Confirmar Nova Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmarSenha" required>

        <button type="submit">Redefinir Senha</button>
    </form>
</div>
</body>
</html>
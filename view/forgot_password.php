<?php
session_start();
$msg = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
$cor = (stripos($msg, 'sucesso') !== false) ? 'green' : 'red';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Recuperar Senha</title>
    <style>
        body {background: #f2f2f2; font-family: Arial, sans-serif;}
        .container {max-width: 350px; margin: 60px auto; background: #fff; padding: 32px 28px 20px 28px; box-shadow: 0 2px 16px #0001; border-radius: 10px;}
        h2 {text-align: center; margin-bottom: 22px;}
        .msg {text-align:center; margin-bottom:16px; font-weight:bold; border-radius:4px; padding:8px;}
        .msg.green {background:#e6faea; color:#218838;}
        .msg.red {background:#fae6e6; color:#a94442;}
        input {width:100%; padding:8px 10px; margin:8px 0 16px 0; border:1px solid #ccc; border-radius:4px;}
        button {width:100%; padding:10px; background:#2186eb; color:#fff; border:none; border-radius:4px; font-size:16px; cursor:pointer;}
        button:hover {background:#1864ab;}
        .link {display:block; text-align:center; margin-top:12px; color:#2186eb; text-decoration:none;}
        .link:hover {text-decoration:underline;}
    </style>
</head>
<body>
<div class="container">
    <h2>Recuperar Senha</h2>
    <?php // ... código de recuperação de senha
if ($recuperacao_sucesso) {
    header("Location: ../view/bem vindo.html");
    exit();
}
    <?php endif; ?>
    <form method="POST" action="../public/index.php?action=forgot_password">
        <input type="email" name="email" placeholder="E-mail" required autofocus>
        <button type="submit">Enviar Código</button>
    </form>
    <a class="link" href="login.php">Voltar ao Login</a>
</div>
</body>
</html>

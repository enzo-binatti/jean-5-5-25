<?php
session_start();
$msg = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
$cor = (stripos($msg, 'sucesso') !== false) ? 'green' : 'red';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nova Senha</title>
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
    </style>
</head>
<body>
<div class="container">
    <h2>Defina sua Nova Senha</h2>
    <?php if ($msg): ?>
        <div class="msg <?= $cor ?>"> <?= htmlspecialchars($msg) ?> </div>
    <?php endif; ?>
    <form method="POST" action="../public/index.php?action=new_password">
        <input type="password" name="senha1" placeholder="Nova Senha" required autofocus>
        <input type="password" name="senha2" placeholder="Repita a Nova Senha" required>
        <button type="submit">Alterar Senha</button>
    </form>
</div>
</body>
</html>

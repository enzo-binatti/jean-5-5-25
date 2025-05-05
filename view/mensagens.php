<?php
session_start();
$msg = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
$cor = (stripos($msg, 'sucesso') !== false) ? 'green' : 'red';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mensagem</title>
    <style>
        body {background: #f2f2f2; font-family: Arial, sans-serif;}
        .container {max-width: 350px; margin: 60px auto; background: #fff; padding: 32px 28px 20px 28px; box-shadow: 0 2px 16px #0001; border-radius: 10px; text-align:center;}
        .msg {margin-bottom:16px; font-weight:bold; border-radius:4px; padding:8px;}
        .msg.green {background:#e6faea; color:#218838;}
        .msg.red {background:#fae6e6; color:#a94442;}
        .link {display:block; text-align:center; margin-top:12px; color:#2186eb; text-decoration:none;}
        .link:hover {text-decoration:underline;}
    </style>
</head>
<body>
<div class="container">
    <?php if ($msg): ?>
        <div class="msg <?= $cor ?>"> <?= htmlspecialchars($msg) ?> </div>
    <?php endif; ?>
    <a class="link" href="login.php">Voltar ao Login</a>
</div>
</body>
</html>

<?php
session_start();

$host = "localhost";
$db = "sistema_login";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email && $senha) {
    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ? OR nome = ?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_nome'] = $user['nome'];
            echo "success";
        } else {
            echo "senha_incorreta";
        }
    } else {
        echo "usuario_nao_encontrado";
    }
} else {
    echo "faltam_dados";
}

$conn->close();
?>

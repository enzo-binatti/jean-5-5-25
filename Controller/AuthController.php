<?php
session_start();
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Code.php';

class AuthController {
    public static function login() {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $user = User::findByEmail($email);
        if (!$user) {
            $_SESSION['mensagem'] = 'E-mail não cadastrado.';
            header('Location: ../view/login.php');
            exit;
        }
        if (!password_verify($senha, $user['senha'])) {
            $_SESSION['mensagem'] = 'Senha incorreta.';
            header('Location: ../view/login.php');
            exit;
        }
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['mensagem'] = 'Login realizado com sucesso!';
        header('Location: ../view/mensagens.php');
        exit;
    }

    public static function forgotPassword() {
        $email = $_POST['email'] ?? '';
        $user = User::findByEmail($email);
        if (!$user) {
            $_SESSION['mensagem'] = 'E-mail não cadastrado.';
            header('Location: ../view/forgot_password.php');
            exit;
        }
        $code = rand(100000, 999999);
        Code::create($user['id'], $code);
        // Aqui você enviaria o código por e-mail (simulação)
        $_SESSION['mensagem'] = 'Código enviado para seu e-mail.';
        $_SESSION['usuario_id'] = $user['id'];
        header('Location: ../view/verify_code.php');
        exit;
    }

    public static function verifyCode() {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        $code = $_POST['code'] ?? '';
        if (Code::verify($usuario_id, $code)) {
            $_SESSION['mensagem'] = 'Código verificado. Digite a nova senha.';
            header('Location: ../view/new_password.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Código inválido.';
            header('Location: ../view/verify_code.php');
            exit;
        }
    }

    public static function newPassword() {
        $usuario_id = $_SESSION['usuario_id'] ?? null;
        $senha1 = $_POST['senha1'] ?? '';
        $senha2 = $_POST['senha2'] ?? '';
        if ($senha1 !== $senha2) {
            $_SESSION['mensagem'] = 'As senhas não coincidem.';
            header('Location: ../view/new_password.php');
            exit;
        }
        $novaSenhaHash = password_hash($senha1, PASSWORD_DEFAULT);
        if (User::updatePassword($usuario_id, $novaSenhaHash)) {
            $_SESSION['mensagem'] = 'Senha alterada com sucesso!';
            header('Location: ../view/mensagens.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro ao alterar senha.';
            header('Location: ../view/new_password.php');
            exit;
        }
    }
}

<?php
session_start();
require_once "AuthController.php";
class AuthController {
    private $model;

    public function __construct() {
        $this->model = new AuthModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmarSenha'] ?? '';

            // Validações...
            if ($this->model->registerUser($nome, $email, $senha)) {
                $_SESSION['sucesso'] = 'Cadastro realizado!';
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['erro'] = 'Erro ao cadastrar.';
                header("Location: cadastro.php");
                exit();
            }
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['password'];

            $user = $this->model->getUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];
                $_SESSION['user_email'] = $user['email'];
                header("Location: welcome.php");
                exit();
            } else {
                $_SESSION['erro'] = 'Credenciais inválidas.';
                header("Location: login.php");
                exit();
            }
        }
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            
            if ($this->model->emailExists($email)) {
                $token = bin2hex(random_bytes(50));
                if ($this->model->setRecoveryToken($email, $token)) {
                    // Enviar email (implementação real necessária)
                    $_SESSION['sucesso'] = 'Link enviado por e-mail.';
                }
            }
            header("Location: login.php");
            exit();
        }
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $novaSenha = $_POST['novaSenha'] ?? '';
            $confirmarSenha = $_POST['confirmarSenha'] ?? '';

            if ($novaSenha === $confirmarSenha) {
                $user = $this->model->validateToken($token);
                if ($user && $this->model->updatePassword($user['id'], $novaSenha)) {
                    $_SESSION['sucesso'] = 'Senha alterada com sucesso.';
                    header("Location: login.php");
                    exit();
                }
            }
            $_SESSION['erro'] = 'Erro ao redefinir senha.';
            header("Location: reset-password.php?token=$token");
            exit();
        }
    }
}

// Uso do controller
$auth = new AuthController();
$action = $_GET['action'] ?? '';

if ($action === 'register') {
    $auth->register();
} elseif ($action === 'login') {
    $auth->login();
} elseif ($action === 'forgot') {
    $auth->forgotPassword();
} elseif ($action === 'reset') {
    $auth->resetPassword();
}
?>
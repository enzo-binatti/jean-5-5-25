<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/AuthController.php';

session_start();

// Verifica se usuário está logado
$authController = new AuthController();
if (!$authController->isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Inclui o template do dashboard
require_once __DIR__ . '/../views/home/dashboard.php';

<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Dashboard</h4>
                </div>
                <div class="card-body">
                    <h5>Bem-vindo, <?= htmlspecialchars($_SESSION['user_nome']) ?>!</h5>
                    <p>Email: <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    <a href="../logout.php" class="btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
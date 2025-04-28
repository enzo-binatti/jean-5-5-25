<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/AuthController.php';

session_start();

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $authController->forgotPassword();
    
    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header("Location: forgot-password.php");
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: forgot-password.php");
        exit();
    }
}

require_once __DIR__ . '/views/auth/forgot-password.php';
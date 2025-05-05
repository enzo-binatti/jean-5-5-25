<?php
session_start();
$action = $_GET['action'] ?? '';
require_once __DIR__ . '/../Controller/AuthController.php';

switch ($action) {
    case 'login':
        AuthController::login();
        break;
    case 'forgot_password':
        AuthController::forgotPassword();
        break;
    case 'verify_code':
        AuthController::verifyCode();
        break;
    case 'new_password':
        AuthController::newPassword();
        break;
    default:
        header('Location: ../view/login.php');
        exit;
}
<?php
require '../model/CadastroModel.php';
function register($fullname, $email, $password)
{
    $conn = new usephpmyadmin()
    $istace = $conn-> getInstace();


    //criptografa senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $sql = "INSERT INTO pessoa (full_name, email)
    VALUES (?, ?)";

    $stmt = $instace->prepare ($sql)
    $stmt->execute([$fullname, $email, $username, $hashed_password]);

    $result = $stmt-> rowCount();
    return $result;
}
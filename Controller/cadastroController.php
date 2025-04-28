<?php

require '../model/CadastroModel.php'

if($_POST){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confrmPassword = $_POST['confirmPassword']

    register($fullName, $email, $username, $password);

    echo $result

    if($result){
        echo "cadastro realizado com sucesso! ";
    }else{
        echo "não foi possivel se caastrar.
    }
}
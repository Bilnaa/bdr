<?php
require_once ("../models/database.php");
require_once ("../utils/integrity.php");
session_start();

if (isset($_POST['matricule']) && isset($_POST['password']) && !empty($_POST['matricule']) && !empty($_POST['password']) ){
    $username = $_POST['matricule'];
    $password = $_POST['password'];
    $integrity = new Integrity();
    $hashed_password = $integrity->hashPassword($password);
    $pdo = new Database();
    $pdo = $pdo->connect();

    $sql = 'SELECT * FROM `employe` WHERE `matriculeemploye` = :matricule AND `passwordemploye` = :password';
    $exec = $pdo->prepare($sql);
    $exec->bindValue(':matricule', $username);
    $exec->bindValue(':password', $password);
    $exec->execute();
    $result = $exec->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $sql = 'SELECT * FROM `employe` WHERE `matriculeemploye` = :matricule';
        $exec = $pdo->prepare($sql);
        $exec->bindValue(':matricule', $username);
        $exec->execute();
        $result = $exec->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $hashed_password = $result['passwordemploye'];
            $is_password_correct = $integrity->verify_password($password, $hashed_password);
            if ($is_password_correct) {
                // Update the password with the new hashed password
                $integrity->store_hashed_password($username, $hashed_password);
                // Check if it's the first connexion
                if ($result['DDERNIERECOEMPLOYE'] == null) {
                    echo "ok, first connexion";
                    http_response_code(200);
                    header('Location: http://localhost/bdr/login/premiereConnexion.php');
                } else {
                    echo "ok, not first connexion";
                    http_response_code(200);
                    header('Location: http://localhost/bdr/dashboard');
                }
            } else {
                $error = 'Wrong username or password!';
                echo $error;
                http_response_code(403);
                header('Location: http://localhost/bdr/login?error=1');
            }
        } else {
            $error = 'Wrong username or password!';
            echo $error;
            http_response_code(403);
            header('Location: http://localhost/bdr/login?error=1');
        }
    } else {
        if ($result['DDERNIERECOEMPLOYE'] == null) {
            echo "ok, first connexion";
            http_response_code(200);
            header('Location: http://localhost/bdr/login/premiereConnexion.php');
        } else {
            echo "ok, not first connexion";
            http_response_code(200);
            header('Location: http://localhost/bdr/dashboard');
        }
    }
}
?>


    
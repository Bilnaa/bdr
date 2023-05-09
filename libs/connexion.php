<?php
session_start();
require_once ("../models/database.php");
require_once ("../utils/integrity.php");

$URL = "/";
if (isset($_POST['matricule']) && isset($_POST['password']) && !empty($_POST['matricule']) && !empty($_POST['password']) ){

    $username = $_POST['matricule'];
    $password = $_POST['password'];
    $db = new Database();
    $connection = $db->connect();
    $sql = "SELECT * FROM employe WHERE matriculeemploye = :matricule"; // check if the user exists
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':matricule', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        $user = $result;
        $integrity = new Integrity();
        $hashed_password = $result['PASSWORDEMPLOYE'];
        $result = $integrity->verify_password($password, $hashed_password);
        if($result){
            $_SESSION['matricule'] = $_POST['matricule'];
            $changed_password = $user['DDERNIERECOEMPLOYE'];
            if($changed_password == null){
                echo "You connected succesfully but you have to change your password !";
                header('Location: '.$URL.'login/premiereConnexion.php');
            } else {
                echo "You have already changed your password !";
                header('Location: '.$URL.'dashboard');
            }
        } else {
            echo "The password is incorrect !";
            header('Location: '.$URL.'login?error=1');
        }
    } else {
        echo "The user does not exist !";
        header('Location: '.$URL.'login?error=2');
    }
}
?>


    
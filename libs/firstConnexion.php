<?php

require_once './utils/integrity.php';
include("database.php");
$pdo = new Database();
$pdo = $pdo->connect();
$sql = "UPDATE `employe` SET `DDERNIERECOEMPLOYE` = :date, `passwordemploye` = :password WHERE `matriculeemploye` = :matricule";
$exec = $pdo->prepare($sql);
$exec->bindValue(':matricule', $_SESSION['matricule']);
$exec->bindValue(':password', $_POST['mdp']);
$exec->bindValue(':date', date("Y-m-d"));
$exec->execute();

if ($exec) {
    echo "The password has been changed successfully !";
    header('Location: http://localhost/bdr/dashboard');
} else {
    echo "The password has not been changed !";
    header('Location: http://localhost/bdr/login/premiereConnexion.html');
}

?>
<?php
session_start();
require_once('../utils/integrity.php');
require_once('../models/database.php');
$integrity = new Integrity();
$pdo = new Database();
$pdo = $pdo->connect();
$sql = "UPDATE `employe` SET `DDERNIERECOEMPLOYE` = :date, `passwordemploye` = :password WHERE `matriculeemploye` = :matricule";
$exec = $pdo->prepare($sql);
$exec->bindValue(':matricule', $_SESSION['matricule']);
$exec->bindValue(':password', $integrity->hashPassword($_POST['mdp']));
$exec->bindValue(':date', date("Y-m-d"));
$exec->execute();

$sql = "SELECT * FROM employe WHERE matriculeemploye = :matricule";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':matricule', $_SESSION['matricule']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$derniereco = $user['DDERNIERECOEMPLOYE'];
if ($derniereco != null) {
    $sql = "UPDATE `employe` SET `DDERNIERECOEMPLOYE` = :date WHERE `matriculeemploye` = :matricule";
    $exec = $pdo->prepare($sql);
    $exec->bindValue(':matricule', $_SESSION['matricule']);
    $exec->bindValue(':date', date("Y-m-d"));
    $exec->execute();
    header('Location: /dashboard');
    echo "You have successfully changed your password !";
} else {
    echo "An error occured !";
}

?>
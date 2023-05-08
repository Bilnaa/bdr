<?php
session_start();
require_once '../utils/integrity.php';

// check if the user is connected through the session
if (!isset($_SESSION['matricule'])) {
    header('Location:  /login');
}

if(isset($_POST['mdp']) && is_string($_POST['mdp'])){
    $integrity = new Integrity();
    $hashed_password = $integrity->hashPassword($_POST['mdp']);
    $integrity->store_hashed_password($_SESSION['matricule'], $hashed_password);
    if($integrity == true){
        header('Location: /dashboard');
        echo "You have successfully changed your password !";
    } else {
        echo "An error occured !";
    }
} else {
    echo "An error occured !";
}

?>
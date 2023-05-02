<?php 
    session_start();
    if (isset($_SESSION['matricule'])) {
        header('Location: http://localhost/bdr/dashboard');
    } else {
        header('Location: http://localhost/bdr/login');
    }
?>
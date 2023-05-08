<?php

require_once 'router.php';

session_start();
$router = new Router();

$router->add('/', function () {
    if (isset($_SESSION['matricule'])) {
        header('Location:  /dashboard');
    } else {
        header('Location:  /login');
    }
});

$router->add('/login', function () {
    if (isset($_SESSION['matricule'])) {
        header('Location:  /dashboard');
    }
    include("login/index.php");
});

$router->add('/dashboard', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/dashboard.php');
});

$router->add('/logout', function () {
    session_destroy();
    header('Location:  /login');
});

$router->add('/profile', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/profile.php');
});

$router->add('/demandes', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/demandes.php');
});

$router->add('/annuaire', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/annuaire.php');
});

$router->add('/formulaire', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/demande_conge.php');
});

$router ->add('/validation', function () {
    if (!isset($_SESSION['matricule'])) {
        header('Location:  /login');
    }
    include('pages/validation.php');
});

$router->dispatch($_SERVER['REQUEST_URI']);

?>
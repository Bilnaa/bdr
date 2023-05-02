<?php

session_start();

require_once 'router.php';

$router = new Router();

$router->add('/bdr/home', function () {
    echo "Welcome to the home page!";
});

$router->add('/bdr/login', function () {
    include("login/index.html");
});

$router->add('/bdr/dashboard', function () {
    include('pages/dashboard.php');
});

$router->dispatch($_SERVER['REQUEST_URI']);

?>
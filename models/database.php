<?php
class Database {

    public function __construct() {
    }

    public function connect() {
        $pdo = new PDO('mysql:host=localhost;dbname=gestionconge;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }

    

}

?>
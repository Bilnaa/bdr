<?php
class Database {

    public function __construct() {
    }

    public function connect() {
        $ip = getenv('MYSQL_HOST');
        $passwd = getenv('MYSQL_PASSWORD');
        $dbname = getenv('MYSQL_DATABASE');
        $pdo = new PDO('mysql:host='.$ip.'dbname=gestionConge;charset=utf8', $dbname, $passwd);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }

    

}

?>
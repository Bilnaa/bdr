<?php
class Database {

    public function __construct() {
    }

    public function connect() {
        /* $ip = getenv('MYSQL_HOST');
        $passwd = getenv('MYSQL_PASSWORD');
        $user = getenv('MYSQL_USER'); */
        // get from .env file
        $ip = '192.168.133.2';
        $user = 'csharp';
        $passwd = '^nGf070YW$*rk2eP8dQm';

        try{
            $pdo = new PDO('mysql:host='.$ip.';dbname=gestionConge;charset=utf8', $user, $passwd);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
        }
        return $pdo;
    }
}

?>
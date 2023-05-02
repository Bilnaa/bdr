<?php

require_once '../models/database.php';

class Integrity
{

    public function __construct() {
    }

    public function check_session()
    {
        if (isset($_SESSION['matricule'])) {
            return true;
        } else {
            return false;
        }
    }

    public function hashPassword($password, $salt = null)
    {
        $options = [
            'cost' => 12,
        ];

        if ($salt) {
            $options['salt'] = $salt;
        }

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verify_password($password, $hashed_password)
    {
        return password_verify($password, $hashed_password);
    }

    public function store_hashed_password($username, $hashed_password)
    {
        $db = new Database();
        $connection = $db->connect();

        $sql = "UPDATE employe SET passwordemploye = :password WHERE matriculeemploye = :matricule";
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':matricule', $username);
        $stmt->bindValue(':password', $hashed_password);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function generate_salt($length = 22)
    {
        $bytes = random_bytes($length);
        $encoded = base64_encode($bytes);
        $salt = strtr($encoded, '+', '.');

        return substr($salt, 0, $length);
    }
}

<?php
require_once "../models/database.php";
if ( isset($_POST['validation']) && isset($_POST['demande_id']) ) {
    $db = new Database();
    $connection = $db->connect();
    $validation = $_POST['validation'];
    if($validation == "yes"){
        $validation = 1;
    } else {
        $validation = 3;
    }
    $demande_id = $_POST['demande_id'];
    $sql = "UPDATE conge SET IDSTATUTCONGE = :idstatutconge WHERE IDCONGE = :idconge";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':idstatutconge', $validation);
    $stmt->bindValue(':idconge', $demande_id);
    try {
        $stmt->execute();
        header('Location: /validation?success=1');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Une erreur est survenue !";
    header('Location: /validation?error=1');
}
?>
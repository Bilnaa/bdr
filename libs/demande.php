 
<?php
session_start();
require_once '../models/database.php';

$db = new Database();

if ( isset($_POST['ddebut']) && isset($_POST['dfin']) && isset($_POST['hdebut']) && isset($_POST['hfin']) && isset($_POST['nbcp']) && isset($_POST['nbrtt']) ) {
    $queryemploye = "SELECT * FROM employe WHERE matriculeemploye = :matricule";
    $stmtemploye = $db->connect()->prepare($queryemploye);
    $stmtemploye->bindValue(':matricule', $_SESSION['matricule']);
    $stmtemploye->execute();
    $employe = $stmtemploye->fetch(PDO::FETCH_ASSOC);

    $nbcbbefore = $employe['NBCP'];
    $nbrttbbefore = $employe['NBRTT'];

    $query = "INSERT INTO conge (MATRICULEEMPLOYE, DDEBUTCONGE, DFINCONGE, HDEBUTCONGE, HFINCONGE, NBCP, NBRTT, IDSTATUTCONGE) VALUES (:matriculeemploye, :ddebutconge, :dfinconge, :hdebutconge, :hfinconge, :nbcpconge, :nbrttconge, :idstatutconge);";
    $matricule = $_SESSION['matricule'];
    $ddebut = $_POST['ddebut'];
    $dfin = $_POST['dfin'];
    $hdebut = $_POST['hdebut'];
    $hfin = $_POST['hfin'];
    $nbcp = $_POST['nbcp'];
    $nbrtt = $_POST['nbrtt'];
    if($nbcp > $nbcbbefore || $nbrtt > $nbrttbbefore){
        echo "Vous n'avez pas assez de jours de congés !";
        header('Location: /formulaire?error=1');
        exit();
    }
    // convert to date format to be used in the query
    $ddebut = date("Y-m-d", strtotime($ddebut));
    $dfin = date("Y-m-d", strtotime($dfin));
    $hdebut = date("H:i:s", strtotime($hdebut));
    $hfin = date("H:i:s", strtotime($hfin));

    $stmt = $db->connect()->prepare($query);
    $stmt->bindValue(':matriculeemploye', $matricule);
    $stmt->bindValue(':ddebutconge', $ddebut);
    $stmt->bindValue(':dfinconge', $dfin);
    $stmt->bindValue(':hdebutconge', $hdebut);
    $stmt->bindValue(':hfinconge', $hfin);
    $stmt->bindValue(':nbcpconge', $nbcp);
    $stmt->bindValue(':nbrttconge', $nbrtt);
    $stmt->bindValue(':idstatutconge', 2);
    try {
        $stmt->execute();
        header('Location: /demandes?success=1');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    echo "Une erreur est survenue !";
}


?>
<?php
include 'views/header.php';

include 'views/navbar.php';

require_once 'models/database.php';

$db = new Database();
$connection = $db->connect();
$query = "SELECT e.MATRICULEEMPLOYE, e.NOMEMPLOYE, e.PRENOMEMPLOYE, e.MAILEMPLOYE, e.NTELEMPLOYE, e.DEMBAUCHEEMPLOYE, e.DNAISSANCEEMPLOYE, s.NOMSERVICE, f.NOMFONCTION, CONCAT(e2.NOMEMPLOYE,' ', e2.PRENOMEMPLOYE) AS RESPONSABLE FROM employe AS e JOIN service AS s ON e.IDSERVICE = s.IDSERVICE JOIN fonction AS f ON e.IDFONCTION = f.IDFONCTION LEFT JOIN employe AS e2 ON e.MATRICULERESPONSABLE = e2.MATRICULEEMPLOYE;";
$stmt = $connection->prepare($query);
$stmt->execute();

$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mx-auto">
  <div class="bg-white py-8 px-10 rounded-lg shadow-md">
    <h1 class="text-3xl mb-4 font-bold text-gray-800">Annuaire des employés</h1>
    <div class="overflow-x-auto">
    <div class="relative w-full mb-6">
        <input type="search" placeholder="Recherche" id="searchInput"
            class="bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none" onkeyup="searchTable()">
    </div>
      <table class="table-auto border-collapse w-full" id="employesTable">
        <thead>
          <tr class="bg-gray-200 text-gray-700">
            <th class="px-4 py-2">Matricule</th>
            <th class="px-4 py-2">Responsable</th>
            <th class="px-4 py-2">Service</th>
            <th class="px-4 py-2">Fonction</th>
            <th class="px-4 py-2">Nom</th>
            <th class="px-4 py-2">Prénom</th>
            <th class="px-4 py-2">E-mail</th>
            <th class="px-4 py-2">Téléphone</th>
            <th class="px-4 py-2">Date de naissance</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($employes as $employe) : ?>
            <tr class="text-gray-700">
              <td class="border px-4 py-2"><?php echo $employe['MATRICULEEMPLOYE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['RESPONSABLE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['NOMSERVICE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['NOMFONCTION'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['NOMEMPLOYE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['PRENOMEMPLOYE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['MAILEMPLOYE'] ?></td>
              <td class="border px-4 py-2"><?php echo $employe['NTELEMPLOYE'] ?></td>
              <td class="border px
                -4 py-2"><?php echo $employe['DNAISSANCEEMPLOYE'] ?></td>
         <?php endforeach; ?>
        </tbody>
        </table>
    </div>
    </div>
</div>


<?php
include 'views/footer.php';
?>
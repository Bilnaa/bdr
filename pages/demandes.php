<?php
require 'models/database.php';
include 'views/header.php';

include 'views/navbar.php';

$db = new Database();
$connection = $db->connect();


$matricule = $_SESSION['matricule'];
$query ="SELECT * FROM conge JOIN statutconge ON conge.idstatutconge = statutconge.idstatutconge WHERE matriculeemploye = :matriculeemploye";
$stmt = $connection->prepare($query);
$stmt->bindValue(':matriculeemploye', $matricule);
$stmt->execute();
$demandes_conges = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container mx-auto">
  <div class="bg-white py-8 px-10 rounded-lg shadow-md">
    <h1 class="text-3xl mb-4 font-bold text-gray-800">Demandes de congés</h1>
    <div class="flex justify-between">
        <a href="/formulaire" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Faire une demande</a>
        <button onclick="exportTableToCSV('export.csv')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Exporter la liste de demande de mes congés</a>
    </div>
    
    <div class="overflow-x-auto py-4">
      <table class="table-auto border-collapse w-full">
        <thead>
          <tr class="bg-gray-200 text-gray-700">
            <th class="px-4 py-2">Numéro de la demande</th>
            <th class="px-4 py-2">Date début</th>
            <th class="px-4 py-2">Date fin</th>
            <th class="px-4 py-2">Durée</th>
            <th class="px-4 py-2">Statut</th>
            <th class="px-4 py-2">Message</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($demandes_conges as $conge) : ?>
            <tr class="text-gray-700">
              <td class="border px-4 py-2"><?php echo $conge['IDCONGE'] ?></td>
              <td class="border px-4 py-2"><?php $ddebut=$conge['DDEBUTCONGE']; echo  $ddebut ?></td>
              <td class="border px-4 py-2"><?php $dfin =$conge['DFINCONGE']; echo $dfin ?></td>
              <td class="border px-4 py-2"><?php
                                                $datetime1 = new DateTime($ddebut);
                                                $datetime2 = new DateTime($dfin);
                                                $interval = $datetime1->diff($datetime2);
                                                echo $interval->format('%a'); 
              ?> jours</td>
              <td class="border px-4 py-2 <?php echo $conge['IDSTATUTCONGE'] == 3 ? 'text-red-600' : '' ?>"><?php echo $conge['NOMSTATUTCONGE'] ?></td>
              <td class="border px-4 py-2"><?php echo $conge['MESSAGEREFUS'] ?></td>

            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
    if(window.location.href.includes('success=1')){
        // notification tailwind green for success message
        const notification = document.createElement('div');
        notification.classList.add('fixed', 'top-0', 'right-0', 'bg-green-500', 'text-white', 'p-4', 'rounded', 'm-4');
        notification.innerHTML = 'Votre demande de congé a bien été envoyée !';
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
</script>

<?php
include 'views/footer.php';
?>
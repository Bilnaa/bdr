<?php
include 'views/header.php';
include 'views/navbar.php';
require_once 'models/database.php';

$db = new Database();
$connection = $db->connect();

$sql = "SELECT * FROM conge INNER JOIN employe on conge.matriculeemploye = employe.matriculeemploye INNER JOIN statutconge on conge.idstatutconge = statutconge.idstatutconge WHERE matriculeresponsable = :matricule";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':matricule', $_SESSION['matricule']);
$stmt->execute();

$demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="w-full h-full flex flex-col">
  <h2 class="text-2xl font-bold mb-4">Demandes de congés</h2>
  <div class="w-full flex items-center mb-4">
    <span class="mr-2">Filtrer par statut :</span>
    <select class="border border-gray-400 rounded px-4 py-2 mr-2">
      <option value="">Tous</option>
      <option value="en_attente">En attente</option>
      <option value="validees">Validé</option>
      <option value="refusees">Refusé</option>
    </select>
    <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded" onclick="filter()">
      Filtrer
    </button>
  </div>
  <div class="flex-grow overflow-y-scroll">
    <table class="w-full border-collapse border border-gray-400">
      <thead class="bg-gray-200">
        <tr>
          <th class="border border-gray-400 p-2">Matricule</th>
          <th class="border border-gray-400 p-2">Nom</th>
          <th class="border border-gray-400 p-2">Prénom</th>
          <th class="border border-gray-400 p-2">Date de début</th>
          <th class="border border-gray-400 p-2">Date de fin</th>
          <th class="border border-gray-400 p-2">Nombre de jours</th>
          <th class="border border-gray-400 p-2">Statut</th>
          <th class="border border-gray-400 p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
        foreach ($demandes as $demande) {?>
            <tr>
                <td class="border px-4 py-2"><?php echo $demande['MATRICULEEMPLOYE']; ?></td> 
                <td class="border px-4 py-2"><?php echo $demande['NOMEMPLOYE']; ?></td>
                <td class="border px-4 py-2"><?php echo $demande['PRENOMEMPLOYE']; ?></td>
                <td class="border px-4 py-2"><?php $ddebut = $demande['DDEBUTCONGE']; echo $ddebut; ?></td>
                <td class="border px-4 py-2"><?php $dfin = $demande['DFINCONGE']; echo $dfin;  ?></td>
                <td class="border px-4 py-2"><?php // nombre de jours
                $date1 = new DateTime($ddebut);
                $date2 = new DateTime($dfin);
                $interval = $date1->diff($date2);
                echo $interval->format('%a jours');
                 ?></td>
                <td class="border px-4 py-2"><?php echo $demande['NOMSTATUTCONGE']; ?></td>
                <?php 
                    // if the status is not "En attente", don't display the buttons
                    if ($demande['IDSTATUTCONGE'] != 2) {
                        echo '<td class="border px-4 py-2"></td>';
                    } else {
                        echo '<td class="border px-4 py-2">
                        <form action="/libs/validation.php" method="post">
                            <input type="hidden" name="demande_id" value="'.$demande["IDCONGE"].'">
                            <button type="submit" name="valider_demande" id="valider_demande" onclick="validation(\'yes\')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Valider</button>
                            <button type="submit" name="refuser_demande" id="refuser_demande" onclick="validation(\'no\')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Refuser</button>
                        </form>
                    </td>';
                    }
                ?>
                
            </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<script>
    // prevent default on the buttons
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', e => {
            if(e.id == 'valider_demand'){
                e.preventDefault();
                validation('yes');
            } else if(e.id == 'refuser_demand'){
                e.preventDefault();
                validation('no');
            }
        });
    });
    function filter(){
        let select = document.querySelector('select');
        let value = select.value; // Valide, Refusé, En attente
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let statut = row.querySelector('td:nth-child(7)').textContent;
            if (value == 'validees' && statut != 'Validé') {
                row.style.display = 'none';
            } else if (value == 'refusees' && statut != 'Refusé') {
                row.style.display = 'none';
            } else if (value == 'en_attente' && statut != 'En attente') {
                row.style.display = 'none';
            } else {
                row.style.display = '';
            }
        });
    }

    function validation(yesOrNo){
        let form = document.querySelector('form');
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'validation';
        input.value = yesOrNo;
        form.appendChild(input);
        form.submit();
    }

    if(window.location.href.includes('success=1')){
        // tailwind notification green for success message
        const notification = document.createElement('div');
        notification.classList.add('fixed', 'top-0', 'right-0', 'bg-green-500', 'text-white', 'p-4', 'rounded', 'm-4');
        notification.innerHTML = 'Votre changement de statut a bien été effectué !';
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 5000);
    } else if(window.location.href.includes('error=1')) {
        // tailwind notification red for error message
        const notification = document.createElement('div');
        notification.classList.add('fixed', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'p-4', 'rounded', 'm-4');
        notification.innerHTML = 'Une erreur est survenue !';
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
    
    
</script>


<?php
include 'views/footer.php';
?>
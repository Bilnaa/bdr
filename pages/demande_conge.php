<?php
include 'views/header.php';
include 'views/navbar.php';
?>

<div class="container mx-auto">
  <div class="bg-white py-8 px-10 rounded-lg shadow-md">
    <h1 class="text-3xl mb-4 font-bold text-gray-800">Poser une demande de congé</h1>
    <form action="/libs/demande.php" id="conge_form" method="post">
      <div class="mb-4">
        <label for="ddebut" class="block text-gray-700 font-bold mb-2">Date de début:</label>
        <input type="date" id="ddebut" name="ddebut" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="mb-4">
        <label for="dfin" class="block text-gray-700 font-bold mb-2">Date de fin:</label>
        <input type="date" id="dfin" name="dfin" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="mb-4">
        <label for="hdebut" class="block text-gray-700 font-bold mb-2">Heure de début:</label>
        <input type="time" id="hdebut" name="hdebut" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="mb-4">
        <label for="hfin" class="block text-gray-700 font-bold mb-2">Heure de fin:</label>
        <input type="time" id="hfin" name="hfin" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="mb-4">
        <label for="nbcp" class="block text-gray-700 font-bold mb-2">Nombre de jours de congé payés:</label>
        <input type="number" id="nbcp" name="nbcp" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="mb-4">
        <label for="nbrtt" class="block text-gray-700 font-bold mb-2">Nombre de RTT:</label>
        <input type="number" id="nbrtt" name="nbrtt" class="border border-gray-400 p-2 w-full" required>
      </div>
      <div class="flex items-center justify-between">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" id="sumbit_button" type="submit">Envoyer</button>
      </div>
    </form>
  </div>
</div>

<script>
    function isHoliday(date) {
    // Tableau des jours fériés en France
    let holidays = [
        '01/01', // Jour de l'an
        '01/05', // Fête du travail
        '08/05', // Victoire 1945
        '14/07', // Fête nationale
        '15/08', // Assomption
        '01/11', // Toussaint
        '11/11', // Armistice 1918
        '25/12'  // Noël
    ];
    
    // Récupérer le jour et le mois de la date à vérifier
    let day = date.getDate();
    let month = date.getMonth() + 1; // Attention, les mois commencent à 0
    
    // Formater le jour et le mois sous forme de chaîne de caractères "jj/mm"
    let formattedDate = ('0' + day).slice(-2) + '/' + ('0' + month).slice(-2);
    
    // Vérifier si la date est un jour férié
    return holidays.indexOf(formattedDate) !== -1;
    }
    const startDateInput = document.getElementById('ddebut');
    startDateInput.addEventListener('input', function() {
        const startDate = new Date(this.value);
        const today = new Date();
        if (startDate < today) {
            alert('La date de début ne peut pas être antérieure à aujourd\'hui.');
            this.value = '';
        }
    });

    // Récupérer les éléments du formulaire
    let endDateInput = document.getElementById('dfin');
    let submitButton = document.getElementById('sumbit_button');

    // Ajouter un écouteur d'événement sur le bouton de soumission
    submitButton.addEventListener('click', function() {
    // Récupérer les dates saisies par l'utilisateur
    let startDate = new Date(startDateInput.value);
    let endDate = new Date(endDateInput.value);
    
    // Vérifier que les dates sont valides et que la date de début est antérieure à la date de fin
    if (isNaN(startDate.getTime()) || isNaN(endDate.getTime()) || startDate > endDate) {
        alert('Veuillez saisir des dates valides.');
        return;
    }
    // Vérifier que les dates ne correspondent pas à des jours fériés
    let currentDate = new Date(startDate);
    while (currentDate <= endDate) {
        if (isHoliday(currentDate)) {
        alert('Le ' + currentDate.toLocaleDateString() + ' est un jour férié. Veuillez choisir une autre date.');
        return;
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }
    
    // Soumettre le formulaire
    document.getElementById('conge_form').submit();
    });

    if(window.location.href.includes('error=1')){
       // tailwind notification red for error message
       const notification = document.createElement('div');
        notification.classList.add('fixed', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'p-4', 'rounded', 'm-4');
        notification.innerHTML = ' Veuillez saisir des dates valides.';
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

</script>


<?php
include 'views/footer.php';
?>
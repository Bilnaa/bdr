<?php
require "./models/database.php";
require "./views/header.php";

include "./views/navbar.php";

$matricule = $_SESSION['matricule'];

$db = new Database();
$connection = $db->connect();

$sql = "SELECT * FROM employe WHERE matriculeemploye = :matricule";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':matricule', $matricule);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$nom = $result['NOMEMPLOYE'];
$prenom = $result['PRENOMEMPLOYE'];
$nom = strtoupper($nom);
$prenom = ucfirst(strtolower($prenom));
$query = "SELECT * FROM congeacquis WHERE matriculeemploye = :matricule";
$stmt = $connection->prepare($query);
$stmt->bindValue(':matricule', $matricule);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$rttrestant = $result['RTTRESTANT'];
$cprestant = $result['CPRESTANT'];
$nbrttacquis= $result['NBRTTACQUIS'];
$nbrcpacquis= $result['NBCPACQUIS'];

$demande = "SELECT * FROM conge WHERE matriculeemploye = :matricule AND (idstatutconge = 2)";
$stmt = $connection->prepare($demande);
$stmt->bindValue(':matricule', $matricule);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$num = $stmt->rowCount();

?>
<main>
<div class="relative isolate flex items-center gap-x-6 overflow-hidden bg-green-50 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">
        <div class="absolute left-[max(-7rem,calc(50%-52rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
            <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
        </div>
        <div class="absolute left-[max(45rem,calc(50%+8rem))] top-1/2 -z-10 -translate-y-1/2 transform-gpu blur-2xl" aria-hidden="true">
            <div class="aspect-[577/310] w-[36.0625rem] bg-gradient-to-r from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.8% 41.9%, 97.2% 73.2%, 100% 34.9%, 92.5% 0.4%, 87.5% 0%, 75% 28.6%, 58.5% 54.6%, 50.1% 56.8%, 46.9% 44%, 48.3% 17.4%, 24.7% 53.9%, 0% 27.9%, 11.9% 74.2%, 24.9% 54.1%, 68.6% 100%, 74.8% 41.9%)"></div>
        </div>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-2">
            <p class="text-sm leading-6 text-gray-900">
            <strong class="font-semibold">Periode estivale 2023</strong><svg viewBox="0 0 2 2" class="mx-2 inline h-0.5 w-0.5 fill-current" aria-hidden="true"><circle cx="1" cy="1" r="1" /></svg>Les vacances arrivent vite, pensez à faire vos demandes de congés dès maintenant !
            </p>
            <a href="#" class="flex-none rounded-full bg-green-900 px-3.5 py-1 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">Faire une demande<span aria-hidden="true">&rarr;</span></a>
        </div>
        <div class="flex flex-1 justify-end">
            <button type="button" class="-m-3 p-3 focus-visible:outline-offset-[-4px]" id="close-notification">
            <span class="sr-only">Dismiss</span>
            <svg class="h-5 w-5 text-gray-900" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
            </svg>
            </button>
        </div>
    </div>
    <div class="container">
    
    <div class="bg-white py-8 px-10 rounded-lg shadow-md">
        <h1 class="text-3xl mb-4 font-bold text-gray-800">Bonjour <?php echo $nom.' '.$prenom ?></h1>
        <p class="text-gray-700 mb-4">Voici un aperçu de vos acquis </p>
        <ul class="flex divide-y divide-gray-300">
        <li class="py-4 px-4">
            <a href="/demandes" class="block hover:bg-green-100 py-2">
                <h2 class="text-lg font-medium text-gray-800">Demande de congé en cours de traitement</h2>
                <p class="text-gray-700 mt-2"><?php echo $num ?></p>
            </a>
        </li>
        <li class="py-4 px-4">
            <div href="#" class="block py-2">
            <h2 class="text-lg font-medium text-gray-800">Congé sans solde restant</h2>
            <p class="text-gray-700 mt-2"><?php echo $rttrestant.'/'.$nbrttacquis ?></p>
            </div>
        </li>
        <li class="py-4 px-4">
            <div href="#" class="block py-2">
            <h2 class="text-lg font-medium text-gray-800">Congé payé restant </h2>
            <p class="text-gray-700 mt-2"><?php echo $cprestant.'/'.$nbrcpacquis ?></p>
            </div>
        </li>
        </ul>
    </div>
    <canvas id="myChart"></canvas>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
  labels: ["Congés payés", "RTT"],
  datasets: [
    {
      label: "Nombre de jours restants",
      backgroundColor: ["#3B82F6", "#FBBF24"],
      data: [<?php echo $cprestant ?>, <?php echo $rttrestant ?>], // remplacer par les vraies données récupérées de la base de données
    },
  ],
};
const ctx = document.getElementById("myChart").getContext("2d");

const options = {
  title: {
    display: true,
    text: "Récapitulatif des jours de congés payés et RTT restants",
  },
};
const myChart = new Chart(ctx, {
  type: "bar",
  data: data,
  options: options, // ajouter les options
});

</script>

<?php
require "./views/footer.php";
?>
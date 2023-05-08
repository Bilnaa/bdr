<?php
include 'models/database.php';
include 'views/header.php';

include 'views/navbar.php';

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

$birth = $result['DNAISSANCEEMPLOYE'];
$birth = date("d/m/Y", strtotime($birth));
$tel = $result['NTELEMPLOYE'];
$mail = $result['MAILEMPLOYE'];
?>


<div class="container mx-auto">
  <div class="bg-white py-8 px-10 rounded-lg shadow-md">
    <h1 class="text-3xl mb-4 font-bold text-gray-800">Profil</h1>
    <div class="flex flex-col md:flex-row mb-4">
      <div class="w-32 h-32 rounded-full overflow-hidden">
        <img class="object-cover w-full h-full" src="/public/img/generic_logo.jpg" alt="Photo de profil">
      </div>
      <div class="md:ml-4 mt-4 md:mt-0">
      <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="nom">
            Matricule
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $_SESSION['matricule'] ?>
          </span>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="nom">
            Nom
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $nom ?>
          </span>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="prenom">
            Prénom
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $prenom ?>
          </span>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="date_naissance">
            Date de naissance
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $birth ?>
          </span>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="email">
            Email
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $mail ?>
          </span>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-medium mb-2" for="telephone">
            Téléphone / Numéro de poste
          </label>
          <span class="text-gray-800 font-medium">
            <?php echo $tel ?>
          </span>
        </div>
      </div>
      
    </div>
    <p class="italic">Si vous pensez que les informations au dessus sont erronés, 
        merci de contacter votre responsable de service. Si vous voulez changer votre mot de passe,
        merci de cliquer sur le bouton ci-dessous.
    </p>
    <div class="flex items-center justify-between">
      <a href="/login/reinitialisation.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">Changer de mot de passe</a>
    </div>
  </div>
</div>


<?php
include 'views/footer.php';
?>
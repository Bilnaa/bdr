<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bois Du Roy - Première Connexion - Intranet</title>
    <link rel="shortcut icon" href="/img/logo_boi_du_roy.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/logo_boi_du_roy.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/logo_boi_du_roy.png">
    <link rel="stylesheet" href="/public/css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <?php
    session_start();
    if (!isset($_SESSION['matricule'])) {
      http_response_code(401);
      echo 'Vous n\'êtes pas connecté !';
      header('Location:  /login');
    }
    require_once '../models/database.php';
    $db = new Database();
    $connection = $db->connect();
    $sql = "SELECT * FROM employe WHERE matriculeemploye = :matricule";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':matricule', $_SESSION['matricule']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $nom = $result['NOMEMPLOYE'];	
    $prenom = $result['PRENOMEMPLOYE'];
    $nom = strtoupper($nom);
    $prenom = ucfirst(strtolower($prenom));
  ?>
    <body>
        <div class="w-screen h-screen flex justify-center items-center">
          <div class="w-full max-w-md">
            <div class="logo">
              <img class="place-items-center h-34 w-auto"  src="../public/img/logo_boi_du_roy.png" alt="logo_bois_du_roy">
            </div>
            <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900">Bonjour <?php echo $nom.' '.$prenom?></h2> 
            <p class="mt-2 text-center text-sm text-gray-600">
              <span class="font-medium text-gray-900">Vous devez changer votre mot de passe pour continuer</span>
            </p>
            <form class="mt-8 space-y-6" action="/libs/firstConnexion.php" method="POST">
              <input type="hidden" name="login" value="true">
              <div class="inputs -space-y-px">
                <div class="login mb-2">
                  <label class="text-base text-gray-600" for="mdp">Mot de passe</label>
                  <input id="mdp" name="mdp" type="password" autocomplete="" required="true" class="group relative flex w-full justify-center rounded-md bg-gray-100 py-2 px-3 text-sm font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" placeholder="Entrez votre nouveau mot de passe">
                  <!-- <div class="w-60 h-48">
                    <div class="absolute bg-white shadow border rounded-lg border-gray-400" style="width: 243px; height: 192px;">
                        <p class="absolute text-sm font-medium tracking-wide leading-tight"
                            style="left: 13px; top: 24px;">Password Strength : Medium</p>
                        <p class="absolute text-sm font-medium tracking-wide leading-tight text-gray-600"
                            style="left: 13px; top: 53px;">Password must meet the<br />following requirement</p>
                        <p class="absolute text-xs font-bold tracking-wide leading-none"
                            style="left: 13px; top: 103px;"> Contain atleast 8 character<br /> At least one upper case
                            (A-Z)<br /> At least one lower case (a-z)<br /> One number (0-9)<br /> One special character
                            (!,@,#,*,$,%)</p>
                    </div>
                    </div> -->
                </div>
                <div class="passwd mb-2">
                  <label class="text-base text-gray-600" for="mdpConfirm">Entrez à nouveau votre mot de passe</label>
                  <input class="group relative flex w-full justify-center rounded-md bg-gray-100 py-2 px-3 text-sm font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"  id="mdpConfirm" name="mdpConfirm" type="password" required="true" placeholder="Confimez votre mot de passe">
                </div>
              </div>
              <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-md bg-green-500 py-2 px-3 text-sm font-semibold text-white hover:bg-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 border rounded-lg" style="height: 50px;">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-green-500 group-hover:text-green-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" fill="#ffffff" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"></path>
                    </svg>
                  </span>
                  <p class="text-base font-semibold text-white">
                  Se connecter
                  </p>
                </button>
              </div>
            </form>
          </div>
        </div>
    </body>
    <script>

        const mdp = document.querySelector('#mdp');
        const mdpConfirm = document.querySelector('#mdpConfirm');
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            if (mdp.value !== mdpConfirm.value) {
                mdp.style.border = '1px solid red';
                mdpConfirm.style.border = '1px solid red';
                e.preventDefault();
            } else if (mdp.value === mdpConfirm.value && mdp.value.length < 8 && !mdp.value.match(/[A-Z]/) && !mdp.value.match(/[a-z]/) && !mdp.value.match(/[0-9]/) && !mdp.value.match(/[^a-zA-Z0-9]/)) {
                mdp.style.border = '1px solid red';
                mdpConfirm.style.border = '1px solid red';
                e.preventDefault();
            } 
        });


    </script>
</body>
</html>
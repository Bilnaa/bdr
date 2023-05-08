<?php
require_once 'models/database.php';
function isActiveProfile($string) {
  // if the url contains the string, return active bg-gray-100
  if(strpos($_SERVER['REQUEST_URI'], $string) !== false) {
    return 'bg-gray-100';
  } else {
    return '';
  }
}

function isActivePage($string) {
  // return bg-gray-900 text-white
  if(strpos($_SERVER['REQUEST_URI'], $string) !== false) {
    return 'bg-gray-900 text-white';
  } else {
    return 'text-gray-300 hover:bg-gray-700 hover:text-white';
  }
}
$db = new Database();
$connection = $db->connect();

$sql = "SELECT * FROM employe WHERE matriculeresponsable = :matricule";

$stmt = $connection->prepare($sql);
$stmt->bindValue(':matricule', $_SESSION['matricule']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);


// if the user is a manager, display the manager menu



?>
<header>
<nav class="bg-green-700">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <!-- Mobile menu button-->
        <button type="button" class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false" onclick="openHamburger()">
          <span class="sr-only">Open main menu</span>
          <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex flex-shrink-0 items-center">
          <img class="block h-8 w-auto lg:hidden" src="/public/img/logo_boi_du_roy.png" alt="Bois du Roy">
          <img class="hidden h-8 w-auto lg:block" src="/public/img/logo_boi_du_roy.png" alt="Bois du Roy">
        </div>
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="/dashboard" class="<?php echo isActivePage("dashboard")  ?>  rounded-md px-3 py-2 text-sm font-medium" aria-current="page">Tableau de Bord</a>
            <a href="/demandes" class="<?php echo isActivePage("demandes")  ?>  rounded-md px-3 py-2 text-sm font-medium">Mes demandes</a>
            <?php if($result) { ?>
            <a href="/validation" class="<?php echo isActivePage("validation")  ?> rounded-md px-3 py-2 text-sm font-medium" >Les demandes de mon équipe</a>
            <?php } ?>
            <a href="/annuaire" class="<?php echo isActivePage("annuaire")  ?> rounded-md px-3 py-2 text-sm font-medium" >Annuaire</a>
            
          </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        <button type="button" class="rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
          </svg>
        </button>

        <!-- Profile dropdown -->
        <div class="relative ml-3">
          <div>
            <button type="button" class="flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true" onclick="openMenu()">
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full" src="/public/img/generic_logo.jpg" alt="generic logo">
            </button>
          </div>

          <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="user-dropdown" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <!-- Active: "bg-gray-100", Not Active: "" -->
            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 <?php echo isActiveProfile("profile")  ?> hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Mon profil</a>
            <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Se deconnecter</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="sm:hidden hidden" id="mobile-menu" onclick="openHamburger()">
    <div class="space-y-1 px-2 pb-3 pt-2">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      <a href="/dashboard" class="<?php echo isActivePage("dashboard")  ?> block rounded-md px-3 py-2 text-base font-medium" aria-current="page">Tableau de Bord</a>
      <a href="/" class="<?php echo isActivePage("demandes")  ?> hover:text-white block rounded-md px-3 py-2 text-base font-medium">Mes demandes</a>
      <?php if($result) { ?>
      <a href="/validation" class="<?php echo isActivePage("validation")  ?> hover:text-white block rounded-md px-3 py-2 text-base font-medium">Les demandes de mon équipe</a>
      <?php } ?>
      <a href="/annuaire" class="<?php echo isActivePage("annuaire")  ?> hover:text-white block rounded-md px-3 py-2 text-base font-medium">Annuraire service</a>
      
    </div>
  </div>
</nav>
</header>
<script>

function openMenu() {
  if(document.querySelector('#user-dropdown').className.includes('block')) {
    document.querySelector('#user-dropdown').className = document.querySelector('#user-dropdown').className.replace('block', 'hidden');
  } else {
    document.querySelector('#user-dropdown').className = document.querySelector('#user-dropdown').className.replace('hidden', 'block');
  }
}

function openHamburger() {
   let classes = document.querySelector('#mobile-menu').className.split(' ');
    if(classes[1] == 'hidden') {
      classes[1] = 'block';
    } else {
      classes[1] = 'hidden';
    }
    document.querySelector('#mobile-menu').className = classes.join(' ');
}


</script>

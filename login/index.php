<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bois Du Roy - Login - Intranet</title>
    <link rel="shortcut icon" href="/public/img/logo_boi_du_roy.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/img/logo_boi_du_roy.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/img/logo_boi_du_roy.png">
    <link rel="stylesheet" href="/public/css/main.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <?php
    session_start();
    if (isset($_SESSION['matricule'])) {
      header('Location: /dashboard');
    }
    ?>
        <div class="w-screen h-screen flex justify-center items-center">
          <div class="w-full max-w-md">
            <div class="logo">
              <img class="place-items-center h-34 w-auto"  src="../public/img/logo_boi_du_roy.png" alt="logo_bois_du_roy">
            </div>
            <h2 class="text-center text-3xl font-bold tracking-tight text-gray-900">Accéder à votre compte</h2> 
            <form class="mt-8 space-y-6" action="/libs/connexion.php" method="POST">
              <input type="hidden" name="login" value="true">
              <div class="inputs -space-y-px">
                <div class="login mb-2">
                  <label class="text-base text-gray-600" for="matricule">Numéro matricule</label>
                  <input id="matricule" name="matricule" type="" autocomplete="" required="true" class="group relative flex w-full justify-center rounded-md bg-gray-100 py-2 px-3 text-sm font-semibold  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600" placeholder="EXXXX">
                </div>
                <div class="passwd mb-2">
                  <label class="text-base text-gray-600" for="password">Mot de passe</label>
                  <input class="group relative flex w-full justify-center rounded-md bg-gray-100 py-2 px-3 text-sm font-semibold focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600"  id="password" name="password" type="password" autocomplete="current-password" required="true" placeholder="Mot de passe">
                </div>
              </div>
              <div>
                <button type="submit" class="group relative flex w-full justify-center rounded-md bg-green-500 py-2 px-3 text-sm font-semibold  hover:bg-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 border rounded-lg" style="height: 50px;">
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
  // if the url includes error=1, push an error message to the form as the first child of the form element that implies a failure with tailwind
  let errorCode = [{
    "error": "1",
    color: "orange",
    "message": "Vos informations de login ne sont pas correctes."
  },
    {
      error: "2",
      color: "red",
      message: "Votre compte n'existe pas."
    }]
  /* if (window.location.href.includes("error=1")) {
    const form = document.querySelector("form");
    const error = document.createElement("div");
    error.classList.add("bg-orange-100", "border-orange-500", "text-orange-700","p-4", "rounded", "relative", "text-sm", "font-bold", "mb-6", "border-l-4");
    error.setAttribute("role", "alert");
    error.innerHTML = `
    <p class="font-bold">Attention</p>
    <p>Vos informations de login ne sont pas correctes.</p>
    `;
    form.insertBefore(error, form.firstChild);
  } */

  if(window.location.href.includes('error')){
    let error = errorCode.find(error => error.error === window.location.href.split('=')[1])
    const form = document.querySelector("form");
    const errorDiv = document.createElement("div");
    errorDiv.classList.add(`bg-${error.color}-100`, `border-${error.color}-500`, `text-${error.color}-700`, "p-4", "rounded", "relative", "text-sm", "font-bold", "mb-6", "border-l-4");
    errorDiv.setAttribute("role", "alert");
    errorDiv.innerHTML = `
    <p class="font-bold">Attention</p>
    <p>${error.message}</p>
    `;
    form.insertBefore(errorDiv, form.firstChild);
  }
</script>
</html>
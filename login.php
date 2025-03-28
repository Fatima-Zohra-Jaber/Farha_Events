<?php
    require 'config.php';

    if(isset($_POST['connecter'])){
        $erreur;
        if(empty($_POST['email'])){
          $erreur['email'] = "Veuillez entrer votre adresse email";
        }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
          $erreur['email'] = "Veuillez entrer une adresse email valide";
        }
        if(empty($_POST['password'])){
          $erreur['password'] = "Veuillez entrer votre mot de passe";
        }
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim(htmlspecialchars($_POST['password']));
            $sqlConn = "SELECT * FROM utilisateur WHERE mailUser = :email AND motPasse = :motPasse";
            $stmtConn = $conn->prepare($sqlConn);
            $stmtConn->bindParam(':email', $email, PDO::PARAM_STR);
            $stmtConn->bindParam(':motPasse', $password, PDO::PARAM_STR);
            $stmtConn->execute();
            $result = $stmtConn->fetch(PDO::FETCH_ASSOC); 
            if($result){
                $_SESSION['utilisateur'] = $result;
                header("Location:index.php");
                exit;
            }else{
                $erreur['password'] = "Email ou Mot de passe non valide!";
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
     /* @theme {
        --color-clifford: #da373d;
      }*/
    </style>
</head>
<body>
  <div class="flex min-h-full flex-col justify-center px-6 py-8 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <img class="mx-auto h-30 w-auto" src="images/logo.png" alt="Your Company">
      <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Connectez-vous à votre compte</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form class="space-y-6" action="#" method="POST">
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
          <div class="mt-2">
            <input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email']; ?>" autocomplete="email"  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-1 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
          </div>
          <span class="text-sm/6 text-red-600"><?= isset($erreur['email']) ?  $erreur['email'] : ''?></span>
        </div>

        <div>
          <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-900">Mot de passe</label>
            <div class="text-sm">
              <a href="#" class="font-semibold  text-purple-600 hover:text-purple-700">Mot de passe oublié ?</a>
            </div>
          </div>
          <div class="mt-2">
            <input type="password" name="password" id="password" autocomplete="current-password"  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-1 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
          </div>
          <span class="text-sm/6 text-red-600"><?= isset($erreur['password']) ?  $erreur['password'] : ''?></span>
        </div>

        <div>
          <button type="submit" name="connecter" class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-500 to-pink-500 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se connecter</button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm/6 text-gray-500">
        Vous n’avez pas de compte?
        <a href="inscription.php" class="font-semibold  text-purple-600 hover:text-purple-700">S'inscrire</a>
      </p>
    </div>
  </div>
</body>
</html>
<?php
    require 'config.php';

    function getIdUser($conn){
        $sqlId = "SELECT idUser FROM Utilisateur ORDER BY idUser DESC LIMIT 1";
        $stmtId = $conn->prepare($sqlId);
        $stmtId->execute();
        $id = $stmtId->fetch();
        $idValue = $id['idUser'];
        $number = (int)substr($idValue, 3);
        $number++;
        $nextId = "USR" . str_pad($number, 7, "0", STR_PAD_LEFT);
        return $nextId;
    }
    if(isset($_POST['enregistrer'])){
        $erreur;
        if(empty($_POST['nom'])){
            $erreur['nom'] = "Veuillez entrer votre nom";
          }
        if(empty($_POST['prenom'])){
        $erreur['prenom'] = "Veuillez entrer votre prenom";
        }
        if(empty($_POST['email'])){
            $erreur['email'] = "Veuillez entrer votre adresse email";
          }elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $erreur['email'] = "Veuillez entrer une adresse email valide";
          }
          if(empty($_POST['password'])){
            $erreur['password'] = "Veuillez entrer votre mot de passe";
          }
          if(empty($_POST['password2'])){
            $erreur['password2'] = "Veuillez confirmer votre mot de passe";
          }
          if($_POST['password'] !== $_POST['password2']){
            $erreur['password2'] = "Confirmation de votre mot de passe est incorrect";
          }
        if(empty($erreur)){
            $id = getIdUser($conn);
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $sqlUser = "INSERT INTO Utilisateur  VALUES (:id, :nom, :prenom, :email, :motPasse)";
            $stmtUser = $conn->prepare($sqlUser);
            $stmtUser->bindParam(':id', $id, PDO::PARAM_STR);
            $stmtUser->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmtUser->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmtUser->bindParam(':email', $email, PDO::PARAM_STR);
            $stmtUser->bindParam(':motPasse', $password, PDO::PARAM_STR);
            $stmtUser->execute();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>
<body>
<div class="flex items-center justify-center p-12">
    <!-- Author: FormBold Team -->
    <div class="mx-auto w-full max-w-[550px] bg-white">
        <form method="POST">
            <div class="mb-5 md:flex md:justify-between">
                <div>
                    <label for="nom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nom
                    </label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" 
                        value="<?php if(isset($_POST['nom']))  echo $_POST['nom']; ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['nom']) ?  $erreur['nom'] : ''?></span>
                </div>
                <div>
                    <label for="prenom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" 
                        value="<?php if(isset($_POST['prenom']))  echo $_POST['prenom']; ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['prenom']) ?  $erreur['prenom'] : ''?></span>
                </div>
            </div>
        
            <div class="mb-5">
                <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                    Email
                </label>
                <input type="text" name="email" id="email" placeholder="Entez votre email"
                    value="<?php if(isset($_POST['email']))  echo $_POST['email']; ?>"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                <span class="text-sm/6 text-red-600"><?= isset($erreur['email']) ?  $erreur['email'] : ''?></span>
            </div>

            <div class="mb-8 md:flex md:justify-between">
                <div>
                    <label for="password" class="mb-3 block text-base font-medium text-[#07074D]">
                        Mot de passe
                    </label>
                    <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe"
                        value="<?php if(isset($_POST['password']))  echo $_POST['password']; ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['password']) ?  $erreur['password'] : ''?></span>
                </div>
                <div>
                    <label for="password2" class="mb-3 block text-base font-medium text-[#07074D]">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" name="password2" id="password2" placeholder="Confirmer votre mot de passe"
                        value="<?php if(isset($_POST['password2']))  echo $_POST['password2']; ?>"  
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['password2']) ?  $erreur['password2'] : ''?></span>
                </div>
            </div>

            <div>
                <button name="enregistrer"
                    class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-500 to-pink-500 px-4 py-2.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Enregistrer
                </button>
            </div>
           
            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Vous avez un compte?
                <a href="login.php" class="font-semibold text-purple-600 hover:text-purple-700">Connectez-vous</a>
            </p>
            
        </form>
    </div>
</div>
</body>
</html>
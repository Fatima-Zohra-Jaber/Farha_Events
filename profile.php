<?php

require 'config.php'; 

    if (!isset($_SESSION['utilisateur'])) {
        header('Location: login.php');
        exit();
    }

        $idUser = $_SESSION['utilisateur']['idUser'];
        $nom = $_SESSION['utilisateur']['nomUser'];
        $prenom = $_SESSION['utilisateur']['prenomUser'];
        $mail = $_SESSION['utilisateur']['mailUser'];
        $motPasse = $_SESSION['utilisateur']['motPasse'];
        $erreur = [];

        if(isset($_POST['modifier'])){
            if (empty($_POST['nom'])) {
                $erreur['nom'] = "Veuillez entrer votre nom.";
            } elseif ($_POST['nom'] !== $nom) {
                $nom = trim($_POST['nom']);
            }
            
            if (empty($_POST['prenom'])) {
                $erreur['prenom'] = "Veuillez entrer votre prénom.";
            } elseif ($_POST['prenom'] !== $prenom) {
                $prenom = trim($_POST['prenom']);
            }
           
            if (empty($_POST['email'])) {
                $erreur['email'] = "Veuillez entrer votre adresse email.";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $erreur['email'] = "Veuillez entrer une adresse email valide.";
            } elseif ($_POST['email'] !== $mail) {
                $mail = trim($_POST['email']);
            }
            
            if (empty($_POST['password'])) {
                $erreur['password'] = "Veuillez entrer votre mot de passe.";
            } elseif ($_POST['password'] !== $motPasse) {
                $motPasse = trim($_POST['password']);
            }
            if (empty($_POST['password2'])) {
                $erreur['password2'] = "Veuillez confirmer votre mot de passe.";
            } elseif ($_POST['password2'] !== $_POST['password']) {
                $erreur['password2'] = "Les mots de passe ne correspondent pas.";
            }
            if(count($erreur) == 0){
                $sqlUpdate = "UPDATE utilisateur SET nomUser = :nom, prenomUser = :prenom,
                             mailUser = :mail, motPasse = :motPasse WHERE idUser = :idUser";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':nom', $nom, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':mail', $mail, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':motPasse', $motPasse, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':idUser', $idUser, PDO::PARAM_STR);
                if($stmtUpdate->execute()){
                    $_SESSION['utilisateur'] = [
                        'idUser' => $idUser,
                        'nomUser' => $nom,
                        'prenomUser' => $prenom,
                        'mailUser' => $mail,
                        'motPasse' => $motPasse
                    ];
                    header('Location: index.php');
                    exit();
                }else{
                    echo "Erreur lors de la mise à jour des informations.";
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
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>
<body>
<?php
    require 'header.php';
  ?>
<div class="flex items-center justify-center p-12">
    <div class="mx-auto w-full max-w-[550px] bg-white">
        <form method="POST">
            <div class="mb-5 md:flex md:justify-between">
                <div>
                    <label for="nom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nom
                    </label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" 
                        value="<?= htmlspecialchars($nom) ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['nom']) ?  $erreur['nom'] : ''?></span>
                </div>
                <div>
                    <label for="prenom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom" 
                        value="<?= htmlspecialchars($prenom) ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['prenom']) ?  $erreur['prenom'] : ''?></span>
                </div>
            </div>
        
            <div class="mb-5">
                <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                    Email
                </label>
                <input type="text" name="email" id="email" placeholder="Entez votre email"
                    value="<?= htmlspecialchars($mail) ?>"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                <span class="text-sm/6 text-red-600"><?= isset($erreur['email']) ?  $erreur['email'] : ''?></span>
            </div>

            <div class="mb-8 md:flex md:justify-between">
                <div>
                    <label for="password" class="mb-3 block text-base font-medium text-[#07074D]">
                        Mot de passe
                    </label>
                    <input type="password" name="password" id="password" placeholder="Entrez votre mot de passe"
                        value="<?= htmlspecialchars($motPasse) ?>"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['password']) ?  $erreur['password'] : ''?></span>
                </div>
                <div>
                    <label for="password2" class="mb-3 block text-base font-medium text-[#07074D]">
                        Confirmer le mot de passe
                    </label>
                    <input type="password" name="password2" id="password2" placeholder="Confirmer votre mot de passe"
                        value="<?php  ?>"  
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    <span class="text-sm/6 text-red-600"><?= isset($erreur['password2']) ?  $erreur['password2'] : ''?></span>
                </div>
            </div>

            <div>
                <button name="modifier"
                    class="flex w-full justify-center rounded-md bg-gradient-to-r from-purple-500 to-pink-500 px-4 py-2.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Modifier
                </button>
            </div>
           
            
            
        </form>
    </div>
</div>
    <?php
        require 'footer.php';
    ?>
</body>
</html>
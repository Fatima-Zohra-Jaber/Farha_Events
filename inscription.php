<?php
    require 'config.php';

    function getIdUser(){
        $sqlId = "SELECT idUser FROM Utilisateur LIMIT 1";
        $stmtId = $conn->prepare($sqlId);
        $stmtId->execute();
        $id = $stmtId->fetch();
        $number = (int)substr($id, 3);
        $number++;
        $nextId = "USR" . str_pad($number, 7, "0", STR_PAD_LEFT);
        echo $nextId;
        return $nextId;
    }
    if(isset($_POST['enregistrer'])){
        $erreur;
        if(empty($erreur)){
            $id = getIdUser();
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
        <form>
            <div class="mb-5 md:flex md:justify-between">
                <div>
                    <label for="nom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Nom
                    </label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div>
                    <label for="prenom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>
        
            <div class="mb-5">
                <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">
                    Email
                </label>
                <input type="email" name="email" id="email" placeholder="Entez votre email"
                    class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
            </div>

            <div class="mb-8 md:flex md:justify-between">
                <div>
                    <label for="nom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Mot de passe
                    </label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div>
                    <label for="prenom" class="mb-3 block text-base font-medium text-[#07074D]">
                        Confirmer le mot de passe
                    </label>
                    <input type="text" name="prenom" id="prenom" placeholder="Entrez votre prénom"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white px-4 py-2.5 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
            </div>

            <div>
                <button name="enregistrer"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Enregistrer
                </button>
            </div>
           
            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Vous avez un compte?
                <a href="login.php" class="font-semibold text-indigo-600 hover:text-indigo-500">Connectez-vous</a>
            </p>
            
        </form>
    </div>
</div>
</body>
</html>
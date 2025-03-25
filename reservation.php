<?php
    require 'config.php';
    if(!empty($_SESSION['reservation'])){
        $idEdition = $_SESSION['reservation']['editionId'] ;
        $qtNormal = (int)$_SESSION['reservation']['qtNormal'];
        $qtReduit = (int)$_SESSION['reservation']['qtReduit'];
        $idUser = $_SESSION['utilisateur']['idUser'];
        var_dump($idUser);
        $sql = "SELECT ev.eventTitle, ev.eventType, ev.TariffNormal, ev.TariffReduit, ed.image
                FROM evenement ev
                JOIN edition ed ON ev.eventId = ed.eventId
                WHERE ed.editionId = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idEdition);
        $stmt->execute();
        $edition = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($_POST['reserver'])){
            $sql = "INSERT INTO reservation (qteBilletsNormal, qteBilletsReduit, editionId, idUser)
            VALUES (:qtNormal, :qtReduit, :editionId, :idUser)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':qtNormal', $qtNormal);
            $stmt->bindParam(':qtReduit', $qtReduit);
            $stmt->bindParam(':editionId', $idEdition);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();
            
            for($i=0; $i < $qtNormal; $i++){
                $sqlBillet = "INSERT INTO reservation VALUES (:billetId, :typeBillet, :placeNum, :idReservation)";
                $stmtBillet = $conn->prepare($sqlBillet);
                $stmtBillet->bindParam(':billetId', $qtReduit);
                $stmtBillet->bindParam(':typeBillet','Normal');
                $stmtBillet->bindParam(':placeNum', $idEdition);
                $stmtBillet->bindParam(':idReservation', $idUser);
                $stmtBillet->execute();
            }
            for($i=0; $i < $qtReduit; $i++){
                $sqlBillet = "INSERT INTO reservation VALUES (:billetId, :typeBillet, :placeNum, :idReservation)";
                $stmtBillet = $conn->prepare($sqlBillet);
                $stmtBillet->bindParam(':billetId', $qtReduit);
                $stmtBillet->bindParam(':typeBillet', 'Reduit');
                $stmtBillet->bindParam(':placeNum', $idEdition);
                $stmtBillet->bindParam(':idReservation', $idUser);
                $stmtBillet->execute();
            }
            header('Location: facture.php');

        }
    } 
    else {
        header("Location: index.php");
        exit();
    }

    
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 p-8">
        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg px-4">
            <div class="p-6 border-b">
                <h1 class="text-2xl font-bold text-gray-800">Confirmer ma reservation</h1>
            </div>
            <form action="" method="POST">
                <div class="divide-y">
                    <div class="flex p-4 items-center">
                        <img class="w-24 h-24 object-cover rounded mr-4" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                        <div class="flex-grow">
                            <h2 class="font-semibold text-gray-800"><?= $edition['eventTitle'] ?></h2>
                            <p class="text-sm text-gray-600">Offre: NORMAL (Adult)</p>
                            <input type="number" name="qtNormal" disabled value="<?= $qtNormal ?>"  class="w-16 border rounded text-center mt-2">
                        </div>
                        <div class="text-right">
                        <!-- <button class="text-red-500 text-sm">✕</button> -->

                            <p class="font-semibold"><?= $edition['TariffNormal'] ?> MAD</p>
                            <p class="text-sm text-gray-500">Sous-total: <?= $edition['TariffNormal'] * $qtNormal ?> MAD</p>
                        </div>
                    </div>
                    <div class="flex p-4 items-center">
                        <img class="w-24 h-24 object-cover rounded mr-4" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                        <div class="flex-grow">
                            <h2 class="font-semibold text-gray-800"><?= $edition['eventTitle'] ?></h2>
                            <p class="text-sm text-gray-600">Offre: REDUIT (Enfant + Etudiant)</p>
                            <input type="number" name="qtReduit" disabled value="<?= $qtReduit ?>" class="w-16 border rounded text-center mt-2">
                        </div>
                        <div class="text-right">
                        <!-- <button class="text-red-500 text-sm">✕</button> -->
                            <p class="font-semibold"><?= $edition['TariffReduit'] ?> MAD</p>
                            <p class="text-sm text-gray-500">Sous-total: <?= $edition['TariffReduit'] * $qtReduit ?> MAD</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-t flex justify-between items-center">
                    <div >
                        <div class="mb-2">
                            <span class="text-gray-600">Total des billets:</span>
                            <span class="font-semibold ml-2"><?= $qtNormal + $qtReduit ?></span>
                        </div>
                        
                        <div class="mb-4">
                            <span class="text-xl font-bold">Total à payer:</span>
                            <span class="text-xl font-bold ml-2"><?= ($qtNormal*$edition['TariffNormal']) + ($qtReduit*$edition['TariffReduit'])?></span>
                        </div>
                    </div>
                    
                    <button name="reserver" class="text-right bg-indigo-500 text-white p-2 rounded hover:bg-indigo-600">
                        Passer ma reservation
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>
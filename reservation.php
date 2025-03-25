<?php
    require 'header.php';

    if(!empty($_SESSION['reservation'])){
        $reservations = $_SESSION['reservation'];
        // $idUser = $reservations[0]['userId'];
        $idEdition = $reservations[0]['editionId'];
        $qtNormal = $reservations[0]['qtNormal'];
        $qtReduit = $reservations[0]['qtReduit'];
        $sql = "SELECT ev.eventTitle, ev.eventType, ev.TariffNormal, ev.TariffReduit, ed.image
                FROM evenement ev
                JOIN edition ed ON ev.eventId = ed.eventId
                WHERE ed.editionId = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idEdition, PDO::PARAM_INT);
        $stmt->execute();
        $edition = $stmt->fetch(PDO::FETCH_ASSOC);

    } 
    // else {
    //     header("Location: index.php");
    //     exit();
    // }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg">
        <div class="p-6 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Mon panier</h1>
        </div>

        <div class="divide-y">
            
            <div class="flex p-4 items-center">
                <img class="w-24 h-24 object-cover rounded mr-4" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                <div class="flex-grow">
                    <h2 class="font-semibold text-gray-800"><?= $edition['eventTitle'] ?></h2>
                    <p class="text-sm text-gray-600">Offre: NORMAL (Adult)</p>
                    <input type="number" value="<?= $qtNormal ?>" min="1" class="w-16 border rounded text-center mt-2">
                </div>
                <div class="text-right">
                <button class="text-red-500 text-sm">✕</button>

                    <p class="font-semibold"><?= $edition['TariffNormal'] ?> MAD</p>
                    <p class="text-sm text-gray-500">Sous-total: <?= $edition['TariffNormal'] * $qtNormal ?> MAD</p>
                </div>
            </div>
            <div class="flex p-4 items-center">
                <img class="w-24 h-24 object-cover rounded mr-4" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                <div class="flex-grow">
                    <h2 class="font-semibold text-gray-800"><?= $edition['eventTitle'] ?></h2>
                    <p class="text-sm text-gray-600">Offre: REDUIT (Enfant + Etudiant)</p>
                    <input type="number" value="<?= $qtReduit ?>" min="1" class="w-16 border rounded text-center mt-2">
                </div>
                <div class="text-right">
                <button class="text-red-500 text-sm">✕</button>
                    <p class="font-semibold"><?= $edition['TariffReduit'] ?> MAD</p>
                    <p class="text-sm text-gray-500">Sous-total: <?= $edition['TariffReduit'] * $qtReduit ?> MAD</p>
                </div>
            </div>
        </div>

        <div class="p-4 border-t flex justify-between items-center">
            
            <div class="text-right">
                <div class="mb-2">
                    <span class="text-gray-600">Total des billets:</span>
                    <span class="font-semibold ml-2"><?= $qtNormal + $qtReduitr?></span>
                </div>
                
                <div class="mb-4">
                    <span class="text-xl font-bold">Total à payer:</span>
                    <span class="text-xl font-bold ml-2"><?= ($qtNormal*$edition['TariffNormal']) + ($qtReduitr*$edition['TariffReduit'])?></span>
                </div>
                <button class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
                    PASSER MA RESERVATION
                </button>
            </div>
        </div>
    </div>
</body>
</html>
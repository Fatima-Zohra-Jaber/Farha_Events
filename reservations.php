<?php
require  'config.php';

if (isset($_SESSION['utilisateur'])) {
    $sql = "SELECT  r.idReservation, r.qteBilletsNormal, r.qteBilletsReduit,ev.eventTitle,ev.TariffNormal,
                        ev.TariffReduit,ed.editionId, ed.dateEvent, ed.timeEvent
                    FROM reservation r JOIN edition ed on r.editionId = ed.editionId
                    JOIN Evenement ev on ev.eventId = ed.eventId
                    WHERE idUser = :idUser";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUser', $_SESSION['utilisateur']['idUser'], PDO::PARAM_STR);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 font-sans text-gray-900">
    <?php require 'header.php'; ?>

    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-4xl font-bold text-center mb-4 text-[#350fa0]">Mes réservations</h1>
        <p class="text-center text-gray-600 mb-6">Consultez et téléchargez vos factures et tickets.</p>

        <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Id Réservation</th>
                        <th class="px-6 py-3">Titre de l'événement</th>
                        <th class="px-6 py-3">Date et Heure</th>
                        <th class="px-6 py-3">Billets Normaux</th>
                        <th class="px-6 py-3">Billets Réduits</th>
                        <th class="px-6 py-3">Prix Total</th>
                        <th class="px-6 py-3">Liens</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    <?php foreach ($reservations as $reservation): ?>
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="px-6 py-4 font-medium"> <?= $reservation['idReservation'] ?> </td>
                        <td class="px-6 py-4"> <?= htmlspecialchars($reservation['eventTitle']) ?> </td>
                        <td class="px-6 py-4"> <?= htmlspecialchars($reservation['dateEvent'] . ' ' . $reservation['timeEvent']) ?> </td>
                        <td class="px-6 py-4"> <?= $reservation['qteBilletsNormal'] ?> </td>
                        <td class="px-6 py-4"> <?= $reservation['qteBilletsReduit'] ?> </td>
                        <td class="px-6 py-4 font-semibold"> 
                            <?php
                                $total = ($reservation['qteBilletsNormal'] * $reservation['TariffNormal']) + ($reservation['qteBilletsReduit'] * $reservation['TariffReduit']);
                                echo number_format($total, 2, ',', ' ') . ' MAD';
                            ?>
                        </td>
                        <td class="px-6 py-4 flex space-x-4">
                            <a href="facture.php?id=<?= $reservation['idReservation'] ?>" class="text-blue-600 hover:underline">Facture</a>
                            <a href="tickets.php?id=<?= $reservation['idReservation'] ?>" class="text-red-600 hover:underline">Tickets</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</body>
</html>

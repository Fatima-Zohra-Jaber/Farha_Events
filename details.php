<?php
  require  'config.php';
  if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT ev.eventTitle,ev.eventType, ev.eventDescription, ev.TariffNormal,ev.TariffReduit,
                    ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
            FROM evenement ev
            JOIN edition ed ON ev.eventId = ed.eventId
            WHERE ed.editionId = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $edition = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$edition) {
        header("Location: index.php");
        exit();
    }
  } else {
    header("Location: index.php");
    exit();
  }

  if(isset($_POST['acheter'] )) {
    try{
        $qtNormal = isset($_POST['qtNormal']) ? $_POST['qtNormal'] : 0;
        $qtReduit = isset($_POST['qtReduit']) ? $_POST['qtReduit'] : 0;
        $editionId = $_POST['editionId'];
        if($qtNormal > 0 || $qtReduit > 0) {
            // $sql="SELECT s.capSalle FROM  salle s JOIN edition ed 
            //         ON s.NumSalle = ed.NumSalle WHERE ed.editionId = :id";
            // $stmt = $conn->prepare($sql);
            // $stmt->bindParam(':id', $editionId, PDO::PARAM_INT);
            // $stmt->execute();
            // $capSalle = $stmt->fetch(PDO::FETCH_ASSOC);

            $capSalle = getCapSalle($conn, $editionId);
            $totalReserved = getNbBillets($conn, $editionId);
            $qtTotal = (int)$qtNormal + (int)$qtReduit;
            echo "capcite". $capSalle . "totalReserved" . $totalReserved . "qtTotal".$qtTotal;
            // $sqlCount = "SELECT sum(qteBilletsNormal) as total_normal,sum(qteBilletsReduit) as total_reduit 
            //             FROM reservation WHERE editionId = :id";
            // $stmtCount = $conn->prepare($sqlCount);
            // $stmtCount->bindParam(':id', $editionId, PDO::PARAM_INT);
            // $stmtCount->execute();
            // $result = $stmtCount->fetch(PDO::FETCH_ASSOC);
            // $totalReserved = $result['total_normal'] + $result['total_reduit'];
            if(($qtTotal + $totalReserved )> $capSalle) {
                echo("La quantité demandée est supérieure à la capacité de la salle");
            }else {
                $_SESSION['reservation']['editionId'] = $editionId;
                $_SESSION['reservation']['qtNormal'] = $qtNormal;
                $_SESSION['reservation']['qtReduit'] = $qtReduit;
                header("Location: reservation.php");
                exit();
            }
        } else {
            echo("La valeur de quantity doit être supérieure ou égale à 1.");
        }
    } catch (PDOException $e) {
        error_log("Reservation error: " . $e->getMessage());
        $_SESSION['error'] = "Une erreur est survenue lors de la réservation";
    }
}
  
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Edition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php
        require 'header.php';
    ?>
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6"><?=htmlspecialchars($edition['eventTitle'])?></h1>
        
        <div class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:w-2/3">
                <div class="rounded-lg overflow-hidden shadow-lg">
                    <img src="images/<?=htmlspecialchars($edition['image'])?>" alt="<?=htmlspecialchars($edition['eventTitle'])?>" class="w-full"/>
                </div>
            </div>
            
            <div class="w-full md:w-1/3 bg-gray-900 text-white rounded-lg shadow-lg p-6">                               
                <div class="text-center mb-6">
                    <h3 class="font-bold mb-1"><?=htmlspecialchars($edition['dateEvent'])?></h3>
                    <p class="text-sm">Départ à <?=htmlspecialchars($edition['timeEvent'])?></p>
                    <p>Salle: <?=htmlspecialchars($edition['numSalle'])?></p>
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="editionId" value="<?= htmlspecialchars($id) ?>">
                    
                    <div class="flex justify-between items-center mb-4 text-xs bg-indigo-800 bg-opacity-40 p-3 rounded">
                        <label for="tariff" class="block text-sm font-medium mb-2">
                            <p>NORMAL (Adult)</p>
                            <p><?= htmlspecialchars($edition['TariffNormal']) ?> MAD</p>
                        </label>
                        <input type="number" id="qtNormal" name="qtNormal" placeholder="Quantité" min="0" max="50" class="w-1/3 p-2 border rounded text-black" />
                    </div>
                    <div class="flex justify-between items-center mb-4 text-xs bg-indigo-800 bg-opacity-40 p-3 rounded">
                        <label for="tariff" class="block text-sm font-medium mb-2">
                            <p>REDUIT (Enfant + Etudiant)</p>
                            <p><?= htmlspecialchars($edition['TariffReduit']) ?> MAD</p>
                        </label>
                        <input type="number" id="qtReduit" name="qtReduit" placeholder="Quantité" min="0" max="50" class="w-1/3 p-2 border rounded text-black" />     
                    </div>
                    
                    <div class="flex justify-center items-center mb-4 px-2"> 
                        <button type="submit" name="acheter" class="w-3/4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-3 px-4 rounded mb-2">
                            Acheter maintenant
                        </button>
                    </div>
                    <p class="text-center text-sm mb-6">Vite !! Achetez rapidement vos tickets</p>                                      
                </form>
               
                <!-- Compteur -->
                <div class="flex justify-center gap-2 mb-2">
                    <div class="bg-indigo-800 bg-opacity-20 w-12 h-12 rounded-full flex flex-col items-center justify-center">
                        <span class="font-bold" id="days">--</span>
                        <span class="text-xs">Jours</span>
                    </div>
                    <div class="bg-indigo-800 bg-opacity-20 w-12 h-12 rounded-full flex flex-col items-center justify-center">
                        <span class="font-bold" id="hours">--</span>
                        <span class="text-xs">Heure</span>
                    </div>
                    <div class="bg-indigo-800 bg-opacity-20 w-12 h-12 rounded-full flex flex-col items-center justify-center">
                        <span class="font-bold" id="minutes">--</span>
                        <span class="text-xs">Minute</span>
                    </div>
                    <div class="bg-indigo-800 bg-opacity-20 w-12 h-12 rounded-full flex flex-col items-center justify-center">
                        <span class="font-bold" id="seconds">--</span>
                        <span class="text-xs">Second</span>
                    </div>
                </div>
                
              
            </div>
        </div>
    </div>
    <div>
        <h3>Description</h3><hr/>
        <p><?=htmlspecialchars($edition['eventDescription'])?></p>
    </div>

    <script>
        // Script pour calculer le compte à rebours
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer la date de l'événement
            const eventDate = "<?= $edition['dateEvent'] . ' ' . $edition['timeEvent']  ?>";
            const countDownDate = new Date(eventDate).getTime();
            
            // Mettre à jour le compte à rebours toutes les secondes
            const countdownTimer = setInterval(function() {
                const now = new Date().getTime();
                const distance = countDownDate - now;
                
                // Calcul des jours, heures, minutes et secondes
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                // Affichage du résultat
                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
                
                // Si le compte à rebours est terminé
                if (distance < 0) {
                    clearInterval(countdownTimer);
                    document.getElementById("days").textContent = "00";
                    document.getElementById("hours").textContent = "00";
                    document.getElementById("minutes").textContent = "00";
                    document.getElementById("seconds").textContent = "00";
                }
            }, 1000);
        });
    </script>
</body>
</html>
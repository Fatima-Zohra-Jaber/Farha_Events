<?php
  require  'config.php';
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT ev.eventTitle,ev.eventType, ev.eventDescription, ev.TariffNormal,ev.TariffReduit,
                    ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
            FROM evenement ev JOIN edition ed ON ev.eventId = ed.eventId
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

  if(isset($_POST['acheter'])) {
    if((isset($_SESSION['utilisateur']))){
        try{
            $qtNormal = isset($_POST['qtNormal']) ? $_POST['qtNormal'] : 0;
            $qtReduit = isset($_POST['qtReduit']) ? $_POST['qtReduit'] : 0;
            $editionId = $_POST['editionId'];
            if($qtNormal > 0 || $qtReduit > 0) {
                $capSalle = getCapSalle($conn, $editionId);
                $totalReserved = getNbBillets($conn, $editionId);
                $qtTotal = (int)$qtNormal + (int)$qtReduit;
                if(($qtTotal + $totalReserved )> $capSalle) {
                    $_SESSION['error'] ="Il ne reste que ".$capSalle - $totalReserved ." place pour cette édition.";
                }else {
                    $_SESSION['reservation']['editionId'] = $editionId;
                    $_SESSION['reservation']['qtNormal'] = $qtNormal;
                    $_SESSION['reservation']['qtReduit'] = $qtReduit;
                    header("Location: reservation.php");
                    exit();
                }
            } else {
                $_SESSION['error'] ="La valeur de quantity doit être supérieure ou égale à 1.";
            }
        } catch (PDOException $e) {
            error_log("Reservation error: " . $e->getMessage());
            $_SESSION['error'] = "Une erreur est survenue lors de la réservation";
        }
    }else {
        $_SESSION['error'] = "Veuillez vous connecter avant de commander.";
        // header("Location: login.php");
        // exit();
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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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
                <?php 
                 $capSalle = getCapSalle($conn, $_GET['id']);
                 $totalReserved = getNbBillets($conn, $_GET['id']);
                if ($capSalle > $totalReserved):?>
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
                <?php else:?>
                    <div class="flex justify-center items-center mb-4 px-2"> 
                        <a href="#" class="w-3/4 bg-slate-400  text-white text-center font-bold py-3 px-4 rounded mb-2">
                            Guichet Fermé
                        </a>
                    </div>
                <?php endif;?>
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
<?php 
 $eventDate = $edition['dateEvent'] . ' ' . $edition['timeEvent'] ;
 $redirectUrl=isset($_SESSION['error']) && $_SESSION['error'] === 'Veuillez vous connecter avant de commander.' ? 'login.php' : '';
 ?>

    <script>
        const eventDate = "<?= $eventDate ?>";
        const redirectUrl="<?=$redirectUrl?>";
    </script>
    <script src="script.js"></script>
</body>
</html>

<?php if(isset($_SESSION['error'])): ?>
<div id="modelConfirm" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
    <div class="relative top-40 mx-auto shadow-xl rounded-md bg-white max-w-md">
        <div class="flex justify-end p-2">
            <button onclick="closeModal('modelConfirm')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <div class="p-6 pt-0 text-center">
            <svg class="w-20 h-20 text-red-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-normal text-gray-500 mt-5 mb-6">
                <?= $_SESSION['error']; ?>
            </h3>
            <a href="#" onclick="closeModal('modelConfirm')"
                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-5 py-2.5 text-center mr-2">
                OK
            </a>
        </div>
    </div>
</div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

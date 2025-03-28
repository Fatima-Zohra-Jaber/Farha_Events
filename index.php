<?php
  require  'config.php';

  $sql = "SELECT  ev.eventType, ev.eventTitle, ev.eventDescription, ev.TariffReduit,
            ed.editionId, ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
            FROM Evenement ev JOIN Edition ed on ev.eventId = ed.eventId
            WHERE STR_TO_DATE(CONCAT(ed.dateEvent, ' ', ed.timeEvent), '%Y-%m-%d %H:%i:%s') > NOW()";
  $params = [];
  if(isset($_GET['search'])){
    $titre = $_GET['titre'] ?? '';
    $eventType = $_GET['type'] ?? '';
    $dateStart = $_GET['dateStart'] ?? '';
    $dateEnd = $_GET['dateEnd'] ?? '';

    if (!empty($titre)) {
        $sql .= " AND (
        eventTitle LIKE :titre OR eventDescription LIKE :titre)";
        $params[':titre'] = "%".$titre."%";
    }
    if (!empty($eventType)) {
        $sql .= " AND eventType = :eventType";
        $params[':eventType'] = $eventType;
    } 
    if (!empty($dateStart) && !empty($dateEnd)) {
        $sql .= " AND dateEvent BETWEEN :dateStart AND :dateEnd";
        $params[':dateStart'] = $dateStart;
        $params[':dateEnd'] = $dateEnd;
    }
  }
 
  $stmt = $conn->prepare($sql);
  foreach ($params as $key => $value) {
      $stmt->bindValue($key, $value, PDO::PARAM_STR);
  }
  $stmt->execute();
  $editions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss"></style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  
</head>
<body>
  <?php
    require 'header.php';
  ?>
  <!-- Section de recherche -->
<div class="max-w-screen-xl mx-auto p-5  rounded-lg shadow-lg">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <input type="search" name="titre" placeholder="Rechercher par titre ou description"
            value="<?= isset($_GET['titre'])? htmlspecialchars($_GET['titre']):'' ?>" class="p-2 border border-gray-300 rounded-lg">
        <select name="type" class="p-2 border border-gray-300 rounded-lg">
            <option value="">Tous les types</option>
            <option value="Cinéma" <?= isset($_GET['type']) && $_GET['type']  == "Cinéma" ? "selected" : "" ?>>Cinéma</option>
            <option value="Musique" <?= isset($_GET['type']) && $_GET['type']  == "Musique" ? "selected" : "" ?>>Musique</option>
            <option value="Théatre" <?= isset($_GET['type']) && $_GET['type']  == "Théatre" ? "selected" : "" ?>>Théatre</option>
            <option value="Rencontres" <?= isset($_GET['type']) && $_GET['type']  == "Rencontres" ? "selected" : "" ?>>Rencontres</option>
        </select>
        <input type="date" name="dateStart" value="<?= isset($_GET['dateStart'])? $_GET['dateStart'] : "" ?>" class="p-2 border border-gray-300 rounded-lg">
        <input type="date" name="dateEnd" value="<?= isset($_GET['dateEnd'])? $_GET['dateEnd'] : "" ?>" class="p-2 border border-gray-300 rounded-lg">
        <button type="submit" name="search" class=" text-white bg-gradient-to-r from-purple-800 to-indigo-700 px-4 py-2 rounded-lg">
            Rechercher
        </button>
    </form>
</div>

<div class="max-w-screen-xl mx-auto p-5 sm:p-10 md:p-16">
    <div class="grid grid-cols-1 md:grid-cols-3 sm:grid-cols-2 gap-10">
        <?php
        foreach($editions as $edition):
          ?>
        <div class="rounded overflow-hidden shadow-lg">

            <a href="#"></a>
            <div class="relative">
                <a href="#">
                    <img class="w-full" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                    <div
                        class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-900 opacity-25">
                    </div>
                </a>
                <a href="#!">
                    <div class="absolute bottom-0 left-0 bg-indigo-600 px-4 py-2 text-white text-sm hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                        <?= $edition['eventType'] ?>
                    </div>
                </a>

                <a href="details.php?id=<?= $edition['editionId'] ?>">
                    <div
                        class="text-sm absolute top-0 right-0 bg-indigo-600 px-4 text-white rounded-full h-16 w-16 flex flex-col items-center justify-center mt-3 mr-3 hover:bg-white hover:text-indigo-600 transition duration-500 ease-in-out">
                        <small class="font-bold"> Détails Edition</small>
                    </div>
                </a>
            </div>
            <div class="px-6 py-4">

                <a href="#" class="font-semibold text-lg inline-block hover:text-indigo-600 transition duration-500 ease-in-out">
                  <?= $edition['eventTitle'] ?></a>
                <p class="text-gray-500 text-sm">
                  <?= $edition['eventDescription'] ?>
                </p>
            </div>
            <div class="px-6 py-4 flex flex-row items-center">
                <span href="#"
                    class="py-1 text-sm font-regular text-gray-900 mr-1 flex flex-row justify-between items-center">
                    <svg height="13px" width="13px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                        style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                            <g>
                                <path
                                    d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256 c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128 c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z">
                                </path>
                            </g>
                        </g>
                    </svg>
                    <span class="ml-1"><?= $edition['dateEvent'] ?> <?= $edition['timeEvent'] ?></span></span>
            </div>
            <div class="px-6 py-4 flex justify-between items-center">
                <div>
                    <p class="text-gray-500">À partir de</p>
                    <p class="text-indigo-600 "><?= $edition['TariffReduit'] ?> DH</p>
                </div>
                <?php 
                 $capSalle = getCapSalle($conn, $edition['editionId']);
                 $totalReserved = getNbBillets($conn, $edition['editionId']);
                if ($capSalle > $totalReserved):?>
                    <a href="details.php?id=<?= $edition['editionId'] ?>" class=" bg-indigo-600 text-white px-4 py-2 rounded">
                            J'achète
                    </a>
                <?php else:?>
                    <a href="details.php?id=<?= $edition['editionId'] ?>" class=" bg-slate-400 text-white px-4 py-2 rounded">
                            Guichet Fermé
                    </a>
                <?php endif;?>
            </div>
        </div>
        
        <?php
          endforeach;
        ?>
    </div>
</div>
</body>
</html>
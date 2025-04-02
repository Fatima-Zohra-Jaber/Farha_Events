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
    <title>Farha Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script >
        tailwind.config = {
            theme: {
                extend: {
                colors: {
                    primary: {
                         50: '#f3f0ff',
                        100: '#e5e0ff',
                        200: '#cdbbff',
                        300: '#a48aff',
                        400: '#7a56ff',
                        500: '#5a30e0',
                        600: '#4415c0',
                        700: '#350fa0',
                        800: '#2b0c80',
                        900: '#23096b',
                    },
                    accent: {
                         50: '#fff0f7',
                        100: '#ffd9ec',
                        200: '#ffb3d9',
                        300: '#ff80bf',
                        400: '#ff4da6',
                        500: '#ff1a8c',
                        600: '#e00074',
                        700: '#b3005c',
                        800: '#800044',
                        900: '#660033',
                    }
                },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        };
    </script>

  
</head>
<body>
    <?php
        require 'header.php';
    ?>
   <!-- Hero Section -->
   <div class="bg-gradient-to-r from-primary-700 to-accent-500 text-white pt-16 pb-20">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">Découvrez des événements extraordinaires</h1>
                <p class="mt-6 text-xl max-w-4xl">Réservez vos billets pour les meilleurs spectacles, concerts et représentations.</p>
            </div>
        </div>
    </div>
    <!-- Section de recherche -->
    <div class="max-w-screen-xl mx-auto -mt-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-xl p-6 md:p-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input type="search" name="titre" placeholder="Rechercher par titre ou description"
                value="<?= isset($_GET['titre'])? htmlspecialchars($_GET['titre']):'' ?>" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 transition duration-200"> 
            <select name="type" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500">
                <option value="">Tous les types</option>
                <option value="Cinéma" <?= isset($_GET['type']) && $_GET['type']  == "Cinéma" ? "selected" : "" ?>>Cinéma</option>
                <option value="Musique" <?= isset($_GET['type']) && $_GET['type']  == "Musique" ? "selected" : "" ?>>Musique</option>
                <option value="Théatre" <?= isset($_GET['type']) && $_GET['type']  == "Théatre" ? "selected" : "" ?>>Théatre</option>
                <option value="Rencontres" <?= isset($_GET['type']) && $_GET['type']  == "Rencontres" ? "selected" : "" ?>>Rencontres</option>
            </select>
            <input type="date" name="dateStart" value="<?= isset($_GET['dateStart'])? $_GET['dateStart'] : "" ?>" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500">
            <input type="date" name="dateEnd" value="<?= isset($_GET['dateEnd'])? $_GET['dateEnd'] : "" ?>" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500">
            <button type="submit" name="search" class="text-white bg-accent-600 hover:bg-accent-700 focus:outline-none px-4 py-2 rounded-lg">             
                Rechercher
            </button>
        </form>
    </div>
    </div>
        
  
    <!--  Section des évènements -->
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            <?php foreach($editions as $edition): ?>
            <div class="bg-white rounded-xl overflow-hidden shadow-lg transition duration-300 hover:shadow-xl transform hover:-translate-y-1">
                <div class="relative aspect-w-16 aspect-h-9">
                    <a href="details.php?id=<?= $edition['editionId'] ?>">
                        <img class="h-56 w-full object-cover" src="images/<?= $edition['image'] ?>" alt="<?= $edition['eventTitle'] ?>">
                    </a>
                    <div class="absolute top-0 right-0 m-4">
                        <div class="bg-accent-500 text-white text-xs font-bold uppercase rounded-full px-3 py-1.5">
                            <?= $edition['eventType'] ?>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                        <?= $edition['eventTitle'] ?>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        <?= $edition['eventDescription'] ?>
                    </p>
                    
                    <div class="flex items-center mb-4">
                        <svg class="h-5 w-5 text-primary-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="ml-2 text-sm text-gray-700">
                            <?php 
                                $date = DateTime::createFromFormat( 'Y-m-d H:i:s',$edition['dateEvent'] . ' ' . $edition['timeEvent']);
                                $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::SHORT);
                                $formatter->setPattern('d MMMM y \'À\' HH\'H\'mm');
                                echo $formatter->format($date);
                            ?>
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">À partir de</p>
                            <p class="text-xl font-bold text-accent-600"><?= $edition['TariffReduit'] ?> DH</p>
                        </div>
                        
                        <?php 
                            $capSalle = getCapSalle($conn, $edition['editionId']);
                            $totalReserved = getNbBillets($conn, $edition['editionId']);
                            if ($capSalle > $totalReserved):?>
                                <a href="details.php?id=<?= $edition['editionId'] ?>" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-primary-600 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200">
                                        J'achète
                                </a>
                            <?php else:?>
                                <a href="details.php?id=<?= $edition['editionId'] ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gray-400">
                                        Guichet Fermé
                                </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($editions)): ?>
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun événement trouvé</h3>
            <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
        </div>
        <?php endif; ?>
    </div>

     
    <!-- Footer Section -->
    <?php
        require 'footer.php';
    ?>
</body>
</html>
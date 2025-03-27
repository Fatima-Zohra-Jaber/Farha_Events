<?php
    require('config.php');
    if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT ev.eventTitle, ev.TariffNormal,ev.TariffReduit,ed.dateEvent, 
                    ed.timeEvent, r.qteBilletsNormal,r.qteBilletsReduit,ed.numSalle,
                    b.billetId,b.typeBillet,b.placeNum              
            FROM reservation r JOIN edition ed on r.editionId = ed.editionId
            JOIN evenement ev  ON ev.eventId = ed.eventId
            JOIN billet b ON r.idReservation = b.idReservation
            WHERE r.idReservation = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($result);
    if (!$result) {
        header("Location: index.php");
        exit();
    }
    // $formattedDateTime = $dateTime->format('d/m/Y à H:i');
    

    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result[0]['dateEvent'] . ' ' . $result[0]['timeEvent']);

    $formatter = new IntlDateFormatter(
        'fr_FR',
        IntlDateFormatter::FULL,
        IntlDateFormatter::SHORT,
        'Europe/Paris',
        IntlDateFormatter::GREGORIAN,
        "EEEE d MMMM yyyy 'À' HH'H'mm"
    );
    
//     $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result[0]['dateEvent'] . ' ' . $result[0]['timeEvent']);

// setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'fr');

// // Formater la date en français avec strftime() n'est plus possible, on utilise format()
// $formattedDateTime = strftime('%A %d %B %Y À %HH%M', strtotime($dateTime->format('Y-m-d H:i:s')));

// // Afficher en majuscules
// echo mb_strtoupper($formattedDateTime, 'UTF-8');

    
    




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Événement</title>
    <link rel="stylesheet" href="ticket.css">
</head>
<body>
    <?php foreach($result as $billet): ?>
    <div class="ticket">
        <div class="left-section">
            <div class="ticket-number">#<?=$billet['billetId']?></div>
            <div class="ticket-number">Numéro de ticket:</div>
            <div class="circle"></div>
        </div>

        <div class="middle-section">
            <div class="titre">
                <h1><?=$billet['eventTitle']?></h1>
                <div class="date"><?= mb_strtoupper($formatter->format($dateTime), 'UTF-8')?></div>
            <!-- SAMEDI 27 JANVIER 2024 À 20H00 -->
            </div>
            
            <div class="info">
                <div class="association">
                    <div class="dot"></div>
                    <h2>ASSOCIATION FARHA</h2>
                </div>

                <div class="details">
                    <div class="tarif-type">
                        <div class="tarif">
                            <p class="bold">Tarif :</p><span>MAD 150,00</span> 
                        </div>
                        <div class="type">
                            <p class="bold">Type :</p><span> Tarif <?=$billet['typeBillet']?></span> 
                        </div>
                    </div>
                    <div class="adresse">
                        <p class="bold">Adresse :</p><span>  Centre Culturel Farha, Tanger</span> 
                    </div>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="cercleHaut"></div>
            <div class="cercleBas"></div>
            <div class="barcode"></div>
            <div class="rightInfo">
                <div class="seat-info">
                    <div class="label">PLACE</div>
                    <div class="value"><?=$billet['placeNum']?></div>
                </div>
                <div class="seat-info">
                    <div class="label">SALLE</div>
                    <div class="value">0<?=$billet['numSalle']?></div>
                </div>
            </div>
            <div class="cercleBlock">
                <div class="cercleRight"></div>
                <div class="cercleRight"></div>
                <div class="cercleRight"></div>
                <div class="cercleRight"></div>
                <div class="cercleRight"></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</body>
</html>
<?php
    } else {
        header("Location: index.php");
        exit();
    }
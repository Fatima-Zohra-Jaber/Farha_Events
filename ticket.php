<?php
    require('config.php');
    
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

    <div class="ticket">
        <div class="left-section">
            <div class="ticket-number">#0123456789</div>
            <div class="ticket-number">Numéro de ticket:</div>
            <div class="circle"></div>
        </div>

        <div class="middle-section">
            <div class="titre">
                <h1>SOIRÉE MAROCAINE</h1>
                <div class="date">SAMEDI 27 JANVIER 2024 À 20H00</div>
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
                            <p class="bold">Type :</p><span> Tarif réduit</span> 
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
                    <div class="value">67</div>
                </div>
                <div class="seat-info">
                    <div class="label">SALLE</div>
                    <div class="value">02</div>
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>


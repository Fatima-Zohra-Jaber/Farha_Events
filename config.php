<?php
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    try{
        $conn = new PDO("mysql:host=localhost;dbname=farhaevents", "root", 'root');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->query("SELECT  ev.eventType, ev.eventTitle, ev.eventDescription, ev.TariffReduit,
                                ed.editionId, ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
                                FROM Evenement ev JOIN Edition ed on ev.eventId = ed.eventId
                                WHERE STR_TO_DATE(CONCAT(ed.dateEvent, ' ', ed.timeEvent), '%Y-%m-%d %H:%i:%s') > NOW()");  
        $editions = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    }catch(PDOException $e){
        die ("Connexion échouée: " . $e->getMessage());
    }

    function getCapSalle($conn, $editionId){
        $sql="SELECT s.capSalle FROM  salle s JOIN edition ed 
                    ON s.NumSalle = ed.NumSalle WHERE ed.editionId = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $editionId, PDO::PARAM_INT);
        $stmt->execute();
        $capSalle = $stmt->fetch(PDO::FETCH_ASSOC);
        return $capSalle['capSalle'];
    }
    
    function getNbBillets($conn, $editionId){
        $sqlCount = "SELECT sum(qteBilletsNormal) as total_normal,sum(qteBilletsReduit) as total_reduit 
        FROM reservation WHERE editionId = :id";
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bindParam(':id', $editionId, PDO::PARAM_INT);
        $stmtCount->execute();
        $result = $stmtCount->fetch(PDO::FETCH_ASSOC);
        $totalReserved = $result['total_normal'] + $result['total_reduit'];
        return $totalReserved;
    }
    
?>
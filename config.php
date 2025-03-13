<?php
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    try{
        $conn = new PDO("mysql:host=localhost;dbname=farhaevents", "root", 'root');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->query("SELECT ev.eventType, ev.eventTitle, ev.eventDescription, ev.TariffReduit,
                                ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
                                FROM Evenement ev JOIN Edition ed on ev.eventId = ed.eventId
                                WHERE STR_TO_DATE(CONCAT(ed.dateEvent, ' ', ed.timeEvent), '%Y-%m-%d %H:%i:%s') > NOW()");  
        $editions = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    }catch(PDOException $e){
        die ("Connexion échouée: " . $e->getMessage());
    }

    // SELECT ev.eventType, ev.eventTitle, ev.eventDescription, ev.TariffNormal, ev.TariffReduit, 
    // ed.editionId, ed.dateEvent, ed.timeEvent, ed.numSalle, ed.image
    //     FROM Evenement ev JOIN Edition ed on ev.eventId = ed.eventId
    // WHERE STR_TO_DATE(CONCAT(ed.dateEvent, ' ', ed.timeEvent), '%Y-%m-%d %H:%i:%s') > NOW()
   
    
?>
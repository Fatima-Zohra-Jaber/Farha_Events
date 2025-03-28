<?php
require('library/fpdf.php');
require 'config.php';
if (isset($_GET['id']) && (isset($_SESSION['utilisateur']))) {
    $id = $_GET['id'];
    $sql = "SELECT ev.eventTitle, ev.TariffNormal,ev.TariffReduit,
                    ed.dateEvent, ed.timeEvent, r.qteBilletsNormal,r.qteBilletsReduit
            FROM reservation r JOIN edition ed on r.editionId = ed.editionId
            JOIN evenement ev  ON ev.eventId = ed.eventId
            WHERE r.idReservation = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        header("Location: index.php");
        exit();
    }

    class PDF extends FPDF
    {
        // Déclaration des variables dynamiques
        private $client;
        private $email;

        // Constructeur pour recevoir les données
        function __construct($client, $email)
        {
            parent::__construct();
            $this->client = $client;
            $this->email = $email;
            $this->SetMargins(20, 20, 20); // Set page margins (left, top, right)

        }
        function Header()
        {
            // Infos Farha
            $this->SetFont('Arial', 'B', 24);
            $this->Cell(100, 10, 'ASSOCIATION', 0, 1, 'L');
            $this->Cell(100, 10, 'FARHA', 0, 1, 'L');
            $this->SetFont('Arial', '', 10);
            $this->Cell(100, 5, 'Farha Centre Culturel Tanger', 0, 1, 'L');

            // Infos Client
            $this->SetXY(140, 20);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(60, 5, 'Client :', 0, 1, 'L');
            $this->SetXY(140, 25);
            $this->Cell(60, 5,  $this->client, 0, 1, 'L');
            $this->SetDrawColor(0, 0, 0); // Noir
            $this->SetLineWidth(0.3); // Épaisseur de la ligne
            $this->Line(190, 32, 140, 32); // x1, y1, x2, y2 (Ligne horizontale)
            $this->SetXY(140, 35);
            $this->Cell(60, 5, 'Adresse email :', 0, 1, 'L');
            $this->SetFont('Arial', '', 10);
            $this->SetXY(140, 40);
            $this->Cell(60, 5, $this->email, 0, 1, 'L');
            $this->Line(190, 47, 140, 47); 

            // Ajout d'un espace sous l'en-tête
            $this->Ln(15);
        }

        function Footer()
        {
            $this->SetY(-37);
            $this->Line(20, $this->GetY(), $this->w - 20, $this->GetY());

            $this->SetY(-30);
            $this->SetFont('Arial', 'I', 10);
            $this->Cell(0, 10, 'MERCI !', 0, 0, 'C');
        }
    }

    // Création du document PDF
    // **Exemple d'utilisation avec des variables dynamiques**;
    $nomClient = $_SESSION['utilisateur']['nomUser'] . ' ' . $_SESSION['utilisateur']['prenomUser'];
    $emailClient = $_SESSION['utilisateur']['mailUser'];

    // Création du PDF avec les données du client
    $pdf = new PDF($nomClient, $emailClient);
    $pdf->AddPage();

    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['dateEvent'] . ' ' . $result['timeEvent']);
    $formattedDateTime = $dateTime->format('d/m/Y à H:i');

    // Infos événement
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 5, $result['eventTitle'], 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8,iconv('UTF-8', 'windows-1252', $formattedDateTime) , 0, 1, 'L');
    $pdf->Ln(5);

    // Numéro de facture
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->Cell(0, 15, 'FACTURE #76528', 0, 1, 'L');
    $pdf->Ln(5);

    // Table des billets
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(42, 15, 'Tarif', 'B', 0, 'L');
    $pdf->Cell(42, 15, 'Prix', 'B', 0, 'L');
    $pdf->Cell(42, 15, 'Qte', 'B', 0, 'L');
    $pdf->Cell(42, 15, 'Total', 'B', 1, 'L');

    $totalNormal = $result['TariffNormal'] * $result['qteBilletsNormal'];
    $totalReduit = $result['TariffReduit'] * $result['qteBilletsReduit'];
    $total = $totalNormal + $totalReduit;
    $totalQte = $result['qteBilletsNormal'] + $result['qteBilletsReduit'];
    // Lignes des tarifs
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(42, 25, 'Normal', 'B', 0, 'L');
    $pdf->Cell(42, 25, $result['TariffNormal'], 'B', 0, 'L');
    $pdf->Cell(42, 25, $result['qteBilletsNormal'], 'B', 0, 'L');
    $pdf->Cell(42, 25, number_format($totalNormal, 2, ',', ' ') . ' MAD', 'B', 1, 'L');
    $pdf->Cell(42, 25, iconv('UTF-8', 'windows-1252', 'Réduit'), 'B', 0, 'L');
    $pdf->Cell(42, 25, $result['TariffReduit'], 'B', 0, 'L');
    $pdf->Cell(42, 25, $result['qteBilletsReduit'], 'B', 0, 'L');
    $pdf->Cell(42, 25, number_format($totalReduit, 2, ',', ' ') . ' MAD', 'B', 1, 'L');
    $pdf->Cell(42, 25, '', 'B', 0, 'L');
    $pdf->Cell(42, 25, '', 'B', 0, 'L');
    $pdf->Cell(42, 25, $totalQte, 'B', 0, 'L');
    $pdf->Cell(42, 25, number_format($total, 2, ',', ' ') . ' MAD', 'B', 1, 'L');
    // Total à payer
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(42, 30, iconv('UTF-8', 'windows-1252', 'Total à payer :'), 0, 0, 'L');
    $pdf->Cell(42, 30, '', 0, 0, 'L');
    $pdf->Cell(42, 30, '', 0, 0, 'L');
    $pdf->Cell(42, 30, number_format($total, 2, ',', ' '). ' MAD', 0, 1, 'L');
    // Génération du PDF
    $pdf->Output();
} else {
    header("Location: index.php");
    exit();
}

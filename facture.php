<?php
require('library/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Association FARHA
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'ASSOCIATION FARHA', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'Centre Culturel Farha, Tanger', 0, 1, 'L');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'MERCI !', 0, 0, 'C');
    }
}

// Création du document PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Infos Client
$pdf->Cell(0, 5, 'Client : Jamal REGRAGUI', 0, 1, 'R');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Adresse email: jamal.regragui@email.com', 0, 1, 'R');
$pdf->Ln(5);

// Infos événement
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'SOIREE MAROCAINE', 0, 1, 'L');
$pdf->Cell(0, 5, '27/01/2024 à 20H00', 0, 1, 'L');
$pdf->Ln(5);

// Numéro de facture
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'FACTURE #76528', 0, 1, 'L');
$pdf->Ln(5);

// Table des billets
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Tarif', 1, 0, 'C');
$pdf->Cell(40, 10, 'Prix', 1, 0, 'C');
$pdf->Cell(40, 10, 'Qte', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total', 1, 1, 'C');

// Lignes des tarifs
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 10, 'Normal', 1, 0, 'C');
$pdf->Cell(40, 10, '250,00', 1, 0, 'C');
$pdf->Cell(40, 10, '2', 1, 0, 'C');
$pdf->Cell(40, 10, '500,00 MAD', 1, 1, 'C');

$pdf->Cell(40, 10, 'Réduit', 1, 0, 'C');
$pdf->Cell(40, 10, '150,00', 1, 0, 'C');
$pdf->Cell(40, 10, '1', 1, 0, 'C');
$pdf->Cell(40, 10, '150,00 MAD', 1, 1, 'C');

// Total
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(120, 10, 'Total à payer :', 1, 0, 'R');
$pdf->Cell(40, 10, '650,00 MAD', 1, 1, 'C');

// Génération du PDF
$pdf->Output();
?>

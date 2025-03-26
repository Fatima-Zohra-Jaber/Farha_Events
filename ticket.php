<?php
require('library/fpdf.php');

$pdf = new FPDF('L', 'mm', array(140, 60)); // Format ticket
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'SOIREE MAROCAINE', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'SAMEDI 27 JANVIER 2024 A 20H00', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 7, 'ASSOCIATION FARHA', 0, 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 7, 'Tarif :', 0);
$pdf->Cell(50, 7, 'MAD 150,00', 0, 1);
$pdf->Cell(30, 7, 'Type :', 0);
$pdf->Cell(50, 7, 'Tarif réduit', 0, 1);
$pdf->Ln(3);

$pdf->Cell(30, 7, 'Adresse :', 0);
$pdf->Cell(50, 7, 'Centre Culturel Farha, Tanger', 0, 1);
$pdf->Ln(5);

// Place et Salle
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, 7, 'PLACE', 0);
$pdf->Cell(50, 7, '67', 0, 1);
$pdf->Cell(30, 7, 'SALLE', 0);
$pdf->Cell(50, 7, '02', 0, 1);
$pdf->Ln(5);

$pdf->Output();
?>

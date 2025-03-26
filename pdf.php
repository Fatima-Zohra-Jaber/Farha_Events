<?php
require('library/fpdf.php');

class InvoicePDF extends FPDF
{
    // En-tête
    function Header()
    {
        // Logo ou titre de l'association (optionnel)
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'ASSOCIATION FARHA', 0, 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'Centre culturel Farha, Tanger', 0, 1, 'L');
        $this->Ln(10);
    }

    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'MERCI !', 0, 0, 'C');
    }

    // Générer la facture
    function GenerateInvoice($client, $email, $date, $tickets)
    {
        // Informations du client
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'FACTURE #76628', 0, 1, 'C');
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, $date, 0, 1, 'C');
        
        $this->Ln(10);

        // Informations du client
        $this->Cell(100, 6, 'Client:', 0, 0);
        $this->Cell(0, 6, $client, 0, 1);
        $this->Cell(100, 6, 'Email:', 0, 0);
        $this->Cell(0, 6, $email, 0, 1);
        
        $this->Ln(10);

        // En-tête du tableau
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 7, 'Tarif', 1);
        $this->Cell(30, 7, 'Prix', 1, 0, 'R');
        $this->Cell(30, 7, 'Quantité', 1, 0, 'R');
        $this->Cell(40, 7, 'Total', 1, 1, 'R');

        // Lignes de tickets
        $this->SetFont('Arial', '', 10);
        $total_general = 0;

        foreach ($tickets as $ticket) {
            $total_ligne = $ticket['prix'] * $ticket['quantite'];
            $total_general += $total_ligne;

            $this->Cell(90, 7, $ticket['type'], 1);
            $this->Cell(30, 7, number_format($ticket['prix'], 2) . ' MAD', 1, 0, 'R');
            $this->Cell(30, 7, $ticket['quantite'], 1, 0, 'R');
            $this->Cell(40, 7, number_format($total_ligne, 2) . ' MAD', 1, 1, 'R');
        }

        // Total général
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(150, 7, 'Total à payer', 1);
        $this->Cell(40, 7, number_format($total_general, 2) . ' MAD', 1, 1, 'R');
    }
}

// Utilisation
$pdf = new InvoicePDF();
$pdf->AddPage();

// Données de la facture
$client = 'Jamal RHERHAGUI';
$email = 'jamal.pro@gmail.com';
$date = '27/01/2024 à 20h00';

$tickets = [
    [
        'type' => 'Normal',
        'prix' => 250.00,
        'quantite' => 2
    ],
    [
        'type' => 'Réduit',
        'prix' => 150.00,
        'quantite' => 1
    ]
];

$pdf->GenerateInvoice($client, $email, $date, $tickets);

// Sortie du PDF
$pdf->Output('F', 'facture_76628.pdf'); // Enregistrer le fichier
$pdf->Output('I', 'facture_76628.pdf'); // Afficher dans le navigateur
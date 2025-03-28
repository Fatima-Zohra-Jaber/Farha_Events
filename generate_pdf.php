<?php
require 'vendor/autoload.php'; // Charge Dompdf
require 'config.php'; // Charge ton fichier de config

use Dompdf\Dompdf;
use Dompdf\Options;

// Options pour améliorer le rendu du PDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true); // Permet d'utiliser des images externes

$dompdf = new Dompdf($options);

// Capture le contenu de ta page
ob_start();
include 'ticket.php'; // Remplace par le nom de ton fichier PHP contenant le HTML
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Télécharger ou afficher le PDF
$dompdf->stream("ticket.pdf", ["Attachment" => false]); // false = affichage direct
?>

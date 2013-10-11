<?php
//faccio questo per via di un conflitto con la clase printorder
//php merda
session_start();
// I18N support information here
$language = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
putenv('LANG=' . $language);
setlocale(LC_ALL, $language);

// Set the text domain as 'default'
$domain = 'default';
bindtextdomain($domain, $_SERVER["DOCUMENT_ROOT"] . '/melarossa/locale');
textdomain($domain);

include '../../../classes/Session.php';
include '../../../classes/PrintOrder.php';
$session = new Session();

$id = $_GET['id'];
$inv_number = $_GET['inv_number'];
$pdf = new PrintOrder($id);

$pdf->setInv_number($inv_number);

//crea pdf
$path = $pdf->createPDF('invoices');
$pdf->savePDF($path, 'invoices');

//header('location:show.php?id=' . $id);
?>
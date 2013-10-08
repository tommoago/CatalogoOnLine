<?php
//include '../../conf/config.php';
include '../../classes/Session.php';
include '../../classes/PrintOrder.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$pdf = new PrintOrder(0);
$pdf->printTemplate();

?>

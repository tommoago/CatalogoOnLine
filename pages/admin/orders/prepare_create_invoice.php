<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/orders/create_invoice.phtml');

$id = $_GET['id'];
$result = array();

try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    $stmt5 = $DBH->prepare('SELECT MAX(number) AS max FROM invoices WHERE orders_id = :id');
    $stmt5->execute(array('id' => $id));
    $stmt5->fetchColumn() == '' ? $inv_number = 1 :  $inv_number++; 
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('o_id' => $id, 'inv_number' => $inv_number));
?>

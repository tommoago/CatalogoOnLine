<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
include '../../../classes/PrintOrder.php';
$session = new Session();

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new data_Base();
    $DBH = $db->connect();
    $pdf = new PrintOrder($id);
    $pdf->deletePDF();
    if (file_exists($pdf->getPath())) {
        unlink($pdf->getPath());
    }

    //se non ho vincoli, elimino.
    $STH = $DBH->prepare('DELETE FROM orders_has_products WHERE orders_id = :id');
    $STH->execute($data);

    $STH = $DBH->prepare('DELETE FROM orders WHERE id = :id');
    $STH->execute($data);


    $message = gettext('del.succ');

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

header('location:list.php?message=' . $message);
?>

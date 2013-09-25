<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();

    //cerco prodotti associati
    $STH = $DBH->prepare('SELECT * FROM products WHERE suppliers_id = :id');
    $STH->execute($data);
    $products = $STH->fetchAll();
    if (empty($products)) {
        //se non ho vincoli, elimino.
        $STH = $DBH->prepare('DELETE FROM suppliers WHERE id = :id');
        $STH->execute($data);
        $message = 'Delete successful';
    } else {
        $message = 'Cannot delete because of depency with associate products';
    }


    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

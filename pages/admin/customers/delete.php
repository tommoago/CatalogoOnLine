<?php

include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();

    //cerco ordini associati
    $stmt = $DBH->prepare('SELECT * FROM orders WHERE customers_id = :id');
    $stmt->execute($data);
    $orders = $stmt->fetchAll();

    if (empty($orders)) {
        //se non ho vincoli, elimino.
        $STH = $DBH->prepare('DELETE FROM customers WHERE id = :id');
        $STH->execute($data);
        $message = 'Delete successful';
    } else {
        $STH = $DBH->prepare('UPDATE customers SET active = 0 WHERE id = :id');
        $STH->execute($data);
        $message = 'Cannot delete because of depency with 1 or more orders, the account has been disactivated';
    }

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

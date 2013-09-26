<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$message = '';
$data = array('id' => $_GET['id']);
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
        $message = gettext('del.succ');
    } else {
        $message = gettext('del.dep.prod');
    }

    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

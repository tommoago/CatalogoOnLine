<?php

include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    //utente può disattivare il suo profilo, ma non lo cancella
    $STH = $DBH->prepare('UPDATE customers SET active = 0 WHERE id = :id');
    $STH->execute($data);

    $session->logout();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

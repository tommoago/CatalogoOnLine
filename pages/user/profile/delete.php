<?php

include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    $STH = $DBH->prepare('DELETE FROM customers WHERE id = :id');
    $STH->execute($data);

    $session->logout();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

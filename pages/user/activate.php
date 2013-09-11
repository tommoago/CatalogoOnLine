<?php

include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $data = array('active' => 1, 'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  active = :active WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
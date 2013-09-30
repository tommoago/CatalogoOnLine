<?php
include '../../conf/config.php';

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();

    $data = array('active' => 1, 'id' => $id);

    $STH = $DBH->prepare('UPDATE customers SET  active = :active WHERE id = :id');
    $STH->execute($data);
    header('location:login.php?message='.gettext('act.succ'));
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
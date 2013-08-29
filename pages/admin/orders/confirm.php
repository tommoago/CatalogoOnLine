<?php
include '../../../classes/dataBase.php';

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
     $data = array('id' => $id);

    $STH = $DBH->prepare('UPDATE orders SET  
                            confirmed = 1
                          WHERE id = :id');
    $STH->execute($data);
    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
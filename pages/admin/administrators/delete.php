<?php
include '../../../classes/dataBase.php';

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();

    //cerco customers associati
    $stmt = $DBH->prepare('SELECT * FROM customers WHERE administrators_id = :id');
    $stmt->execute($data);
    $customers = $stmt->fetchAll();

    if (empty($customers)) {
        //se non ho vincoli, elimino.
        $STH = $DBH->prepare('DELETE FROM administrators WHERE id = :id');
        $STH->execute($data);
        $message = 'Delete successful';
    } else {
        $message = 'Cannot delete because of depency with an associated customer';
    }


    header('location:list.php?message=' . $message);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

<?php

$username = 'root';
$password = 'root';

$id = $_GET['id'];
$message = '';
$data = array('id' => $id);
try {
    $DBH = new PDO('mysql:host=localhost;dbname=melarossa', $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

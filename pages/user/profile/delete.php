<?php
include '../../../classes/data_Base.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];
$data = array('id' => $id);
try {
    $db = new data_Base();
    $DBH = $db->connect();
    
    //elimino anche la traccia degli indirizzi associati
    $STH = $DBH->prepare('DELETE FROM customers_has_addresses WHERE customers_id = :id');
    $STH->execute($data);
    
    $STH2 = $DBH->prepare('DELETE FROM customers WHERE id = :id');
    $STH2->execute($data);

    $session->logout();
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

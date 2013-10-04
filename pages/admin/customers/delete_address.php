<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$a_id = $_GET['id'];
$c_id = $_GET['cus_id'];

$data = array('id' => $id);
try {
    $db = new dataBase();
    $DBH = $db->connect();
    
    $STH = $DBH->prepare('DELETE FROM customers_has_addresses
                                 WHERE customers_id = :c_id AND addresses_id = :a_id');
    $STH->execute(array('c_id' => $c_id, 'a_id' => $a_id ));

    $STH2 = $DBH->prepare('DELETE FROM addresses WHERE id = :id');
    $STH2->execute(array('id' => $a_id));

    header('location:show.php?id=' . $c_id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

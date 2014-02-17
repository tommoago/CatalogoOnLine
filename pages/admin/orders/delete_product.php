<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$o_id = $_GET['o_id'];
$p_id = $_GET['p_id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    
    $STH = $DBH->prepare('DELETE FROM orders_has_products
                                 WHERE orders_id = :o_id AND products_id = :p_id');
    $STH->execute(array('o_id' => $o_id, 'p_id' => $p_id ));

    header('location:show.php?id=' . $o_id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

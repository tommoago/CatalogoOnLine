<?php
include '../../../conf/config.php';
include '../../../classes/Session.php';
$session = new Session();

$id = $_GET['id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();

    $STH = $DBH->prepare('UPDATE orders SET
                            confirmed = 1,
                            quotation = 0
                          WHERE id = :id');
    $STH->execute(array(('id') => $id));

    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>

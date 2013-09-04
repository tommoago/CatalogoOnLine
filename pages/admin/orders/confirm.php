<?php
include '../../../classes/dataBase.php';
include '../../../classes/Session.php';
include '../../../classes/Mailer.php';
$session = new Session();
$mailer = new Mailer();
$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('id' => $id, 'operator' => $session->getUser_id());

    $STH = $DBH->prepare('UPDATE orders SET  
                            confirmed = 1,
                            operator = :operator
                          WHERE id = :id');
    $STH->execute($data);
    
    require '../../../classes/mailer/class.phpmailer.php';


    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
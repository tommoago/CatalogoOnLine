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
    $data = array('id' => $id, 'conf' => date("Y-m-d H:i:s"), 'operator' =>$_SESSION['user']['name']);

    $STH = $DBH->prepare('UPDATE orders SET  
                            confirmed = 1,
                            confirm_date = :conf,
                            operator = :operator
                          WHERE id = :id');
    $STH->execute($data);
    
    $STH = $DBH->prepare('SELECT * FROM orders WHERE id = :id');
    $STH->execute(array('id' => $id));
    $order = $STH->fetch();
    
    $STH = $DBH->prepare('SELECT * FROM customers WHERE id = :id');
    $STH->execute(array('id' => $order['customers_id']));
    $customer = $STH->fetch();
    
    $mailer->send($customer['email'], "lmao", "Order ". $order['id'] ." confirmation", "This mail is automatically sent to confirm your order with id: ". $order['id']);

    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
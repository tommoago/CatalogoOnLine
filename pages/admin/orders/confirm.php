<?php

include '../../../classes/Session.php';
include '../../../classes/PrintOrder.php';
include_once '../../../classes/dataBase.php';
require_once '../../../vendor/phpmailer/phpmailer/class.phpmailer.php';
$session = new Session();
$mail = new PHPMailer();
$id = $_GET['id'];
$pdf = new PrintOrder($id);

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $data = array('id' => $id, 'conf' => date("Y-m-d H:i:s"), 'operator' => $_SESSION['user']['name']);

    $STH = $DBH->prepare('UPDATE orders SET  
                            confirmed = 1,
                            confirm_date = :conf,
                            operator = :operator
                          WHERE id = :id');
    $STH->execute($data);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
    //crea pdf
    $path = $pdf->createPDF('invoices');
    $pdf->savePDF($path);
    $customer = $pdf->getCustomer();
    $order = $pdf->getOrder();

    //manda mail
    $mail->AddReplyTo("info@ozntone.com", "First Last");

    $mail->SetFrom('info@ozntone.com', 'First Last');

    $address = $customer['email'];
    $mail->AddAddress($address, "John Doe");

    $mail->Subject = "Order " . $order['id'] . " confirmation";

//    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

    $mail->MsgHTML("This mail is automatically sent to confirm your order with id: " . $order['id']);

    $mail->AddAttachment($path);      // attachment

    if (!$mail->Send()) {
        print_r("Mailer Error: " . $mail->ErrorInfo);
    } else {
        print_r("Message sent!");
    }

    header('location:show.php?id=' . $id);
?>
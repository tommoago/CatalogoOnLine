<?php
//faccio questo per via di un conflitto con la clase printorder
//php merda
session_start();
// I18N support information here
$language =  isset($_SESSION['lang'])? $_SESSION['lang']: 'en';
putenv('LANG='.$language); 
setlocale(LC_ALL, $language);

// Set the text domain as 'default'
$domain = 'default';
bindtextdomain($domain, $_SERVER["DOCUMENT_ROOT"] .'/catalogoonline/locale'); 
textdomain($domain);

include '../../../classes/Session.php';
include '../../../classes/PrintOrder.php';
require_once '../../../vendor/phpmailer/phpmailer/class.phpmailer.php';
$session = new Session();
$mail = new PHPMailer();
$id = $_GET['id'];
$pdf = new PrintOrder($id);

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $data = array('id' => $id, 'conf' => date('Y-m-d H:i:s'), 'operator' => $_SESSION['user']['name']);

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
    $path = $pdf->createPDF('order_details');
    $pdf->savePDF($path, 'order_details');
    $customer = $pdf->getCustomer();
    $order = $pdf->getOrder();

    //manda mail con il pdf, non la fattura TO DO : aggiunge nome ditta!
    $mail->AddReplyTo('info@ozntone.com', 'Mela Rossa Cash n Carry');
    $mail->SetFrom('info@ozntone.com', 'Mela Rossa Cash n Carry');
    $address = $customer['email'];
    $mail->AddAddress($address, $customer['name'].' '.$customer['surname']);
    $mail->Subject = gettext('ord').' '.$order['id'].' '.gettext('conf');
    $mail->MsgHTML(gettext('ord.mail.body').' '.$order['id']);
    $mail->AddAttachment($path);      // attachment

    if (!$mail->Send()) {
       header('location:show.php?id=' . $id .'&message=' . $mail->ErrorInfo);
    } else {
        header('location:show.php?id=' . $id);
    }
?>
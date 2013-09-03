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

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'jswan';                            // SMTP username
$mail->Password = 'secret';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'from@example.com';
$mail->FromName = 'Mailer';
$mail->AddAddress('josh@example.net', 'Josh Adams');  // Add a recipient
$mail->AddAddress('ellen@example.com');               // Name is optional
$mail->AddReplyTo('info@example.com', 'Information');
$mail->AddCC('cc@example.com');
$mail->AddBCC('bcc@example.com');

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
//    header('location:show.php?id=' . $id);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
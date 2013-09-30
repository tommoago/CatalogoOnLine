<?php
include '../conf/config.php';
include '../classes/Mailer.php';

$email = $_POST['email'];
$subject = $_POST['sub'];
$text = $_POST['question'];

$mailer = new Mailer();
$mailer->send('info@ozntone.com', $email, $subject, $text);
header('location:contact_us.php?message='.gettext('msg.sent'));
?>

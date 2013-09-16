<?php

include '../classes/Mailer.php';

$email = $_POST['email'];
$text = $_POST['question'];

$mailer = new Mailer();
$mailer->send('info@ozntone.com', $email, 'question', $text);
header('location:contact_us.php?message=Message sent. You will be contacted as sooon as possible.');
?>

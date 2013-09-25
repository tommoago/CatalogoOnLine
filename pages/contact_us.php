<?php
include '../conf/config.php';
include '../conf/twig.php';

$template = $twig->loadTemplate('site/contact_us.phtml');

$message = '';
if(isset( $_GET['message']))
 $message = $_GET['message'];

$template->display(array('message' => $message, 'index' =>'yes'));
?>

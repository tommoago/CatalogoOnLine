<?php
include '../../conf/config.php';
include '../../conf/twig.php';

if (isset($_SESSION['user']['type'])) {
    header('location:index.php');
}

$template = $twig->loadTemplate('user/login/login.phtml');

$order = isset($_GET['order'])?  $_GET['order']: '';

$message = isset($_GET['message'])? $_GET['message']: '';


$template->display(array('message' => $message, 'order' => $order));
?>

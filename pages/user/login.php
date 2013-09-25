<?php
include '../../conf/config.php';
include '../../../conf/twig.php';

if (isset($_SESSION['user']['type'])) {
    header('location:index.php');
}

$template = $twig->loadTemplate('user/login/login.phtml');

isset($_GET['order'])? $order = $_GET['order']: $order = '';

isset($_GET['message'])? $message = $_GET['message']: $message = '';


$template->display(array('message' => $message, 'order' => $order));
?>

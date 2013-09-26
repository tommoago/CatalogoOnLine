<?php
include '../../conf/config.php';
include '../../conf/twig.php';

if (isset($_SESSION['user']['role'])) {
    header('location:index.php');
}

$template = $twig->loadTemplate('admin/login/login.phtml');

$message = isset($_GET['message'])? $_GET['message']: '';

$template->display(array('message' => $message));
?>

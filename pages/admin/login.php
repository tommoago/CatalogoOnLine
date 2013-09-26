<?php
include '../../conf/config.php';
include '../../conf/twig.php';

if (isset($_SESSION['user']['role'])) {
    header('location:index.php');
}

$template = $twig->loadTemplate('admin/login/login.phtml');

$template->display(array('message' => isset($_GET['message'])? $_GET['message']: ''));
?>

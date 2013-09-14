<?php
session_start();
require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

if (isset($_SESSION['user']['role'])) {
    header('location:index.php');
}
$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/login/login.phtml');

$message = '';
if (isset($_GET['message']))
    $message = $_GET['message'];

$template->display(array('message' => $message));
?>

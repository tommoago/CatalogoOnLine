<?php
session_start();
require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

if (isset($_SESSION['user']['type'])) {
    header('location:index.php');
}
$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/*, array('cache' => '../../../templates/cache')*/);
$template = $twig->loadTemplate('user/login/login.phtml');

isset($_GET['order'])? $order = $_GET['order']: $order = '';

isset($_GET['message'])? $message = $_GET['message']: $message = '';


$template->display(array('message' => $message, 'order' => $order));
?>

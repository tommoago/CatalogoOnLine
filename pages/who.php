<?php

session_start();
include '../classes/Cart.php';
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();


$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('site/who.phtml');

$template->display(array('index' =>'yes'));
?>

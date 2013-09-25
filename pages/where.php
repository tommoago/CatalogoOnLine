<?php
include '../conf/twig.php';
include '../classes/Cart.php';
session_start();

isset($_SESSION['cart'])?  : $_SESSION['cart'] = new Cart();

$template = $twig->loadTemplate('site/where.phtml');

$template->display(array('index' =>'yes'));
?>

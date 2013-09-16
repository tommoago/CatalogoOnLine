<?php

session_start();
require_once '../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('index.phtml');

//$splitted = split('/', $_SERVER['HTTP_REFERER']);
//$relativeDir = '';
//
//for ($i = 0; $i < sizeof($splitted) - 1; $i++) {
//    $relativeDir .= $splitted[$i] . '/';
//}
//
//$link = $relativeDir . "activate.php?id=";
//
//print_r($link);

$template->display(array('index' =>'yes'));
?>

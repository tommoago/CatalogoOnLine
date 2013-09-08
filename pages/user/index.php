<?php

include '../../classes/Session.php';
$session = new Session();

require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('user/structure/index.phtml');

$template->display(array('usr' => $_SESSION['user'], 'index' => 'true'));
?>
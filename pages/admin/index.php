<?php

include '../../classes/Session.php';
$session = new Session();

require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/index.phtml');
print_r($_SESSION['user']);
$template->display(array('adm' => $_SESSION['user']));
?>

<?php

include '../../classes/Session.php';
$session = new Session();

require_once '../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/structure/index.phtml');

$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

$template->display(array('adm' => $_SESSION['user'], 'index' => 'true', 'message' =>$message));
?>

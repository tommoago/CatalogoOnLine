<?php

include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message= Unauthorized access.'); 
}

require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../../../templates');
$twig = new Twig_Environment($loader/* , array('cache' => '../../../templates/cache') */);
$template = $twig->loadTemplate('admin/company/add_image.phtml');

$template->display(array('id' => $_GET['id'], 'message' => isset($_GET['message'])? $_GET['message'] :''));
?>

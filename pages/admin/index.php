<?php
include '../../conf/config.php';
include '../../conf/twig.php';
include '../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/structure/index.phtml');

$template->display(array('adm' => $_SESSION['user'], 
                         'index' => 'true', 
                         'message' =>isset($_GET['message'])? $_GET['message']: ''));
?>

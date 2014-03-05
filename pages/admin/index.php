<?php
include '../../conf/config.php';
include '../../conf/twig.php';
include '../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/structure/index.phtml');

$template->display(array('index' => 'yes', 'usr' => $_SESSION['user']));
?>

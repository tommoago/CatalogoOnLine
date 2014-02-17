<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('user/administer/structure/index.phtml');

$template->display(array('usr' => $_SESSION['user']));
?>

<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/users/insert.phtml');


$template->display(array('message' => isset($_GET['message']) ? $_GET['message'] : '', 'regios' => $regs));
?>

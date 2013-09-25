<?php
require_once '../../../vendor/twig/twig/lib/Twig/Autoloader.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/suppliers/insert.phtml');

$template->display(array());
?>

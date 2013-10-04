<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/insert_address.phtml');

$template->display(array('cus_id' => isset($_GET['cus_id'])? $_GET['cus_id']: ''));
?>

<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/customers/insert.phtml');

$db = new data_Base();
$DBH = $db->connect();
$stmt = $DBH->prepare('SELECT * FROM regioni ORDER BY nome');
$stmt->execute();
$regs = $stmt->fetchAll();

$template->display(array('message' => isset($_GET['message']) ? $_GET['message'] : '', 'regios' => $regs));
?>

<?php
include '../../conf/config.php';
include '../../conf/twig.php';
include '../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/structure/index.phtml');

$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

$template->display(array('adm' => $_SESSION['user'], 'index' => 'true', 'message' =>$message));
?>

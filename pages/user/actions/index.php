<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

if (isset($_GET['client_id'])) {
    $_SESSION['client'] = $_GET['client_id'];
};

$template = $twig->loadTemplate('user/actions/index.phtml');


$template->display(array());
?>

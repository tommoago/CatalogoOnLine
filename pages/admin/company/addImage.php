<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$template = $twig->loadTemplate('admin/company/add_image.phtml');

$template->display(array('id' => $_GET['id'], 'message' => isset($_GET['message'])? $_GET['message'] :''));
?>

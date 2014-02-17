<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$template = $twig->loadTemplate('admin/company/list.phtml');

$result = array();
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM company_info');
    $stmt->execute();
    $result = $stmt->fetchAll();

} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('data' => $result));
?>

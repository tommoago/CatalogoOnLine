<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$template = $twig->loadTemplate('admin/company/view_images.phtml');

$id = $_GET['id'];

try {
    $db = new dataBase();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM company_images WHERE company_info_id = :id');
    $stmt->execute(array('id' => $id));
    $result = $stmt->fetchAll();
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('images' => $result));
?>

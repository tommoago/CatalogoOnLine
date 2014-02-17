<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();
if(!$session->check_role('jack')){
   header('location:../index.php?message='. gettext('unauth')); 
}

$template = $twig->loadTemplate('admin/administrators/update.phtml');

$id = $_GET['id'];

try {
    $db = new data_Base();
    $DBH = $db->connect();
    $stmt = $DBH->prepare('SELECT * FROM administrators WHERE id = :id');
    $stmt->execute(array('id' => $id));
    //tira fuori solo un risultato
    $admin = $stmt->fetch();
    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('admin' => $admin));
?>

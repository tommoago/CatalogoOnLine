<?php
include '../../../conf/config.php';
include '../../../conf/twig.php';
include '../../../classes/Session.php';
$session = new Session();

$template = $twig->loadTemplate('admin/products/catalog.phtml');
$message = isset($_GET['message'])? $_GET['message']: '';
$result = array();
$offset = isset($_GET['offset'])? $_GET['offset']: 0;
$limit = 20;
$numPages = 0;

try {
    $db = new data_Base();
    $DBH = $db->connect();


    $stmt = $DBH->prepare('SELECT * FROM catalog ');
    $stmt->execute();
    $result = $stmt->fetchAll();

    
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

$template->display(array('catls' => $result, 'message' => $message));
?>